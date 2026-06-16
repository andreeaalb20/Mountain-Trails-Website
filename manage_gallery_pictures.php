<?php
session_start();
require 'db.php';
require_once 'vendor/autoload.php';

if(!isset($_SESSION['uid'])) { header("Location: login_form.php"); exit; }

$id_gallery = intval($_GET['id']);

// Verificam daca galeria exista si cine e proprietarul
$stmt = $conn->prepare("SELECT title, id_user FROM galleries WHERE id = ?");
$stmt->bind_param("i", $id_gallery);
$stmt->execute();
$gallery = $stmt->get_result()->fetch_assoc();

if(!$gallery || ($gallery['id_user'] != $_SESSION['uid'] && $_SESSION['uid'] != 1)) {
    header("Location: manage_galleries.php");
    exit;
}

// Luam toate pozele secundare pentru aceasta galerie
$stmt = $conn->prepare("SELECT * FROM pictures WHERE id_gallery = ?");
$stmt->bind_param("i", $id_gallery);
$stmt->execute();
$pictures = $stmt->get_result();

$loader = new \Twig\Loader\FilesystemLoader('templates');
$twig = new \Twig\Environment($loader);
$sql = "SELECT * FROM carousel";
$result_c = $conn->query($sql);

echo $twig->render('manage_gallery_pictures.tpl.html', [
    'result_c' => $result_c,
    'gallery_title' => $gallery['title'],
    'id_gallery' => $id_gallery,
    'pictures' => $pictures,
    'user_name' => $_SESSION['uname'],
    'user_id' => $_SESSION['uid'],
    'user_image' => $_SESSION['uimage'],
    'user_description' => $_SESSION['udescription'],
    'pagetitle' => 'Manage Photos | Mountain Trails'
]);
?>