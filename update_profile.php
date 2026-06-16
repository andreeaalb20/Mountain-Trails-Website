<?php
session_start();
require 'db.php';

// Verificăm dacă userul este logat
if (!isset($_SESSION['uid']) || $_SESSION['uid'] == 0) {
    header("Location: login_form.php");
    exit();
}

$user_id = $_SESSION['uid'];

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    // 1. Preluăm și curățăm descrierea
    $description = $conn->real_escape_string($_POST['description']);
    
    // Actualizăm descrierea în baza de date și în sesiune
    $sql_desc = "UPDATE users SET user_short_description = '$description' WHERE id = $user_id";
    if ($conn->query($sql_desc)) {
        $_SESSION['udescription'] = $description;
    }

    // 2. Logica pentru încărcarea pozei de profil (dacă a fost selectată una)
    if (isset($_FILES['user_image']) && $_FILES['user_image']['error'] == 0) {
        $target_dir = "templates/pictures/users/";
        
        // Creăm un nume unic pentru poză folosind timestamp-ul
        $file_extension = pathinfo($_FILES["user_image"]["name"], PATHINFO_EXTENSION);
        $file_name = "user_" . $user_id . "_" . time() . "." . $file_extension;
        $target_file = $target_dir . $file_name;

        // Verificăm dacă fișierul este imagine
        $check = getimagesize($_FILES["user_image"]["tmp_name"]);
        if ($check !== false) {
            if (move_uploaded_file($_FILES["user_image"]["tmp_name"], $target_file)) {
                // Actualizăm numele pozei în baza de date
                $sql_img = "UPDATE users SET user_image = '$file_name' WHERE id = $user_id";
                if ($conn->query($sql_img)) {
                    // Ștergem poza veche din sesiune și folder (opțional, pentru curățenie)
                    if ($_SESSION['uimage'] != 'user_image.jpg' && file_exists($target_dir . $_SESSION['uimage'])) {
                        unlink($target_dir . $_SESSION['uimage']);
                    }
                    // Actualizăm sesiunea cu noua poză
                    $_SESSION['uimage'] = $file_name;
                }
            }
        }
    }

    // Redirecționăm înapoi la setări cu succes
    header("Location: settings.php?success=1");
    exit();
}

$conn->close();
?>