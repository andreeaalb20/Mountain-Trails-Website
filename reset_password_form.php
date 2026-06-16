<?php
session_start();
if(!isset($_SESSION['uid']) || $_SESSION['uid'] == 0){
    header("Location: login_form.php");
    exit;
}

require_once 'vendor/autoload.php';
$loader = new \Twig\Loader\FilesystemLoader('templates');
$twig = new \Twig\Environment($loader);

echo $twig->render('reset_password_form.tpl.html', [
    'pagetitle' => 'Change Password',
    'user_name' => $_SESSION['uname'],
    'user_id' => $_SESSION['uid'],
    'user_image' => $_SESSION['uimage'],
    'user_description' => $_SESSION['udescription']
]);
?>