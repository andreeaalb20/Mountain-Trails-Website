<?php
	session_start();
	$gallery_id=$_GET['id'];

	require_once 'vendor/autoload.php'; // incarca bibliotecile externe (precum TWIG)
	require 'db.php'; // face conexiunea la baza de date, in db.php e definit obiectul de conexiune, variabila $conn

	$loader = new \Twig\Loader\FilesystemLoader('templates');
	$twig = new \Twig\Environment($loader);

    $pagetitle = $sitetitle . ' | Breathtaking Mountain Trails';

    // interogarile SQL:
    $sql = "SELECT * FROM carousel";
	$result_c = $conn->query($sql); // rezultatele primite din interogare le salvam in $result_c 

	$sql= "SELECT * FROM galleries WHERE id = $gallery_id";
	$result_g = $conn->query($sql);

	$sql = "SELECT * FROM pictures WHERE id_gallery = $gallery_id";
	$result_p = $conn->query($sql);

	// --- LINII NOI PENTRU COMENTARII ---
	// Luam comentariile si facem legatura cu coloana 'user' din tabela 'users'
		$sql_comm = "SELECT comments.*, users.user as username 
             FROM comments 
             JOIN users ON comments.user_id = users.id 
             WHERE gallery_id = $gallery_id 
             ORDER BY created_at DESC";
		$result_comm = $conn->query($sql_comm);
	// ---------------------------------- ----------------------------------

    // toat datele adunate din baza de date le trimitem catre sablonul vizual pt a genera pagina pe care o vede utilizatorul
    echo $twig->render('show_gallery_base.tpl.html', [
        'pagetitle' => $pagetitle, //'pagetitle' e cheia (cum o vede TWIG) iar $ e ce contine variabila din php
        'result_c' => $result_c,
        'result_g' => $result_g,
        'result_p' => $result_p,
        'comments' => $result_comm,
        'gallery_id' => $gallery_id, 
        'user_name'=>$_SESSION['uname'],
        'user_id' =>$_SESSION['uid'],
        'user_image'=>$_SESSION['uimage'],
        'user_description'=>$_SESSION['udescription']
    ]);
    $conn->close();
?>