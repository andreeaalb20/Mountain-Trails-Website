<?php
session_start();
require 'db.php';

if ($_SERVER['REQUEST_METHOD'] == 'POST' && isset($_SESSION['uid'])) {
    $id_gallery = intval($_POST['id_gallery']);
    
    if (isset($_FILES['new_photo']) && $_FILES['new_photo']['error'] == 0) {
        $upload_dir = "templates/pictures/";
        $file_extension = pathinfo($_FILES['new_photo']['name'], PATHINFO_EXTENSION);
        
        // Generam un nume unic: ex: extra_2_1645234.jpg
        $new_filename = "extra_" . $id_gallery . "_" . time() . "." . $file_extension;
        $target_file = $upload_dir . $new_filename;

        if (move_uploaded_file($_FILES['new_photo']['tmp_name'], $target_file)) {
            // Salvam in tabelul 'pictures'
            $stmt = $conn->prepare("INSERT INTO pictures (id_gallery, picture) VALUES (?, ?)");
            $stmt->bind_param("is", $id_gallery, $new_filename);
            
            if ($stmt->execute()) {
                header("Location: manage_gallery_pictures.php?id=$id_gallery&msg=success");
            } else {
                echo "Eroare la baza de date.";
            }
        } else {
            echo "Eroare la mutarea fisierului.";
        }
    } else {
        echo "Nu a fost selectata nicio imagine valida.";
    }
}
$conn->close();
?>