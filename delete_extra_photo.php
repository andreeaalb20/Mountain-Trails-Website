<?php
session_start();
require 'db.php';

if (isset($_GET['id']) && isset($_SESSION['uid'])) {
    $id_photo = intval($_GET['id']);
    $id_gallery = intval($_GET['id_gallery']);

    // 1. Aflăm numele fișierului pentru a-l șterge de pe disc
    $stmt = $conn->prepare("SELECT picture FROM pictures WHERE id = ?");
    $stmt->bind_param("i", $id_photo);
    $stmt->execute();
    $result = $stmt->get_result();
    
    if ($row = $result->fetch_assoc()) {
        $file_path = "templates/pictures/" . $row['picture'];
        
        // Ștergem fișierul fizic
        if (file_exists($file_path)) {
            unlink($file_path);
        }

        // 2. Ștergem înregistrarea din baza de date
        $stmt = $conn->prepare("DELETE FROM pictures WHERE id = ?");
        $stmt->bind_param("i", $id_photo);
        $stmt->execute();
    }

    header("Location: manage_gallery_pictures.php?id=$id_gallery&msg=deleted");
} else {
    header("Location: manage_galleries.php");
}
$conn->close();
?>