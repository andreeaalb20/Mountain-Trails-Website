<?php
session_start();
if(!isset($_SESSION['uid']) || $_SESSION['uid'] == 0){
    header("Location: login_form.php");
    exit;
}

require_once 'vendor/autoload.php';
require 'db.php';

$loader = new \Twig\Loader\FilesystemLoader('templates');
$twig = new \Twig\Environment($loader);

$pagetitle = 'Add New Trail | Mountain Trails';

echo $twig->render('add_gallery.tpl.html', [
    'pagetitle' => $pagetitle,
    'user_name' => $_SESSION['uname'],
    'user_id' => $_SESSION['uid'],
    'user_image' => $_SESSION['uimage'],
    'user_description' => $_SESSION['udescription']
]);
?>