<?php
session_start();
require 'db.php';
require_once 'vendor/autoload.php';

if(!isset($_SESSION['uid'])) { header("Location: login_form.php"); exit; }

$id = intval($_GET['id']);
// Preluăm datele traseului
$stmt = $conn->prepare("SELECT * FROM galleries WHERE id = ?");
$stmt->bind_param("i", $id);
$stmt->execute();
$trail = $stmt->get_result()->fetch_assoc();

// Verificăm dacă userul are voie să editeze (e proprietar sau admin)
if(!$trail || ($trail['id_user'] != $_SESSION['uid'] && $_SESSION['uid'] != 1)) {
    header("Location: manage_galleries.php");
    exit;
}

$loader = new \Twig\Loader\FilesystemLoader('templates');
$twig = new \Twig\Environment($loader);
$sql = "SELECT * FROM carousel";
$result_c = $conn->query($sql);

echo $twig->render('edit_gallery_form.tpl.html', [
    'result_c' => $result_c,
    'trail' => $trail,
    'user_name' => $_SESSION['uname'],
    'user_id' => $_SESSION['uid'],
    'user_image' => $_SESSION['uimage'],
    'user_description' => $_SESSION['udescription'],
    'pagetitle' => 'Edit Trail | Mountain Trails'
]);
?>