<?php
	session_start();
	require_once 'vendor/autoload.php';
	require 'db.php';
	$loader = new \Twig\Loader\FilesystemLoader('templates');
	$twig = new \Twig\Environment($loader);
	$pagetitle = 'Login | Mountain Trails';
	$sql = "SELECT * FROM carousel";
	$result_c = $conn->query($sql);
	echo $twig->render('login_form_base.tpl.html', [
		'pagetitle' => $pagetitle,
		'result_c' => $result_c,
		'user_name'=>$_SESSION['uname'],
		'user_id' =>$_SESSION['uid'],
		'user_image'=>$_SESSION['uimage'],
		'user_description'=>$_SESSION['udescription']]);
?>