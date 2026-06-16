<?php
session_start();
require 'db.php';

// Verificăm dacă suntem logați și dacă primim date prin POST
if ($_SERVER['REQUEST_METHOD'] == 'POST' && isset($_SESSION['uid'])) {
    
    $id = intval($_POST['id']);
    $title = $conn->real_escape_string($_POST['title']);
    $short_desc = $conn->real_escape_string($_POST['title_description']);
    $long_desc = $conn->real_escape_string($_POST['long_description']);

    // Verificăm drepturile: doar proprietarul sau adminul (ID 1) pot edita
    $check = $conn->query("SELECT id_user FROM galleries WHERE id = $id");
    $row = $check->fetch_assoc();

    if ($row && ($row['id_user'] == $_SESSION['uid'] || $_SESSION['uid'] == 1)) {
        
        // Comanda SQL de actualizare
        $sql = "UPDATE galleries SET 
                title = '$title', 
                title_description = '$short_desc', 
                long_description = '$long_desc' 
                WHERE id = $id";

        if ($conn->query($sql)) {
            // Dacă totul e ok, mergem la lista de galerii
            header("Location: manage_galleries.php?success=updated");
            exit();
        } else {
            echo "Eroare SQL: " . $conn->error;
        }
    } else {
        echo "Acces interzis. Nu ai permisiunea de a edita acest traseu.";
    }
} else {
    echo "Metodă de acces nevalidă.";
}

$conn->close();
?>