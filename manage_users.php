<?php
session_start();

// Securitate: Doar ADMIN-ul (ID 1) are voie aici
if (!isset($_SESSION['uid']) || $_SESSION['uid'] != 1) {
    header("Location: index.php");
    exit;
}

require_once 'vendor/autoload.php';
require 'db.php';

$loader = new \Twig\Loader\FilesystemLoader('templates');
$twig = new \Twig\Environment($loader);

// Titlul paginii
$pagetitle = 'User Management | Mountain Trails';

// Luam toti utilizatorii, in afara de admin (ca sa nu se stearga singur din greseala)
$sql = "SELECT id, user, user_image FROM users WHERE id != 1";
$result_u = $conn->query($sql);

// Trebuie sa iei datele pentru carusel (fara asta, caruselul e invizibil)
$sql_car = "SELECT * FROM carousel";
$result_c = $conn->query($sql_car);

echo $twig->render('manage_users.tpl.html', [
    'result_c'  => $result_c, // Transmite rezultatul interogarii
    'pagetitle' => $pagetitle,
    'users' => $result_u,
    'user_name' => $_SESSION['uname'],
    'user_id' => $_SESSION['uid'],
    'user_image' => $_SESSION['uimage'],
    'user_description' => $_SESSION['udescription']
]);

$conn->close();
?>