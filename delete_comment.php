<?php
session_start();
require 'db.php';

// Verificam daca cel logat este ADMIN (id 1)
if (isset($_SESSION['uid']) && $_SESSION['uid'] == 1 && isset($_GET['id'])) {
    
    $comment_id = $_GET['id'];
    $gallery_id = $_GET['gallery_id']; // Avem nevoie de el ca sa ne intoarcem la pagina corecta

    // Stergem comentariul
    $sql = "DELETE FROM comments WHERE id = $comment_id";

    if ($conn->query($sql) === TRUE) {
        // Succes! Ne intoarcem la galerie
        header("Location: show_gallery.php?id=" . $gallery_id);
        exit();
    } else {
        echo "Error deleting record: " . $conn->error;
    }
} else {
    // Daca nu e admin sau nu e logat, il dam afara
    die("Unauthorized access! You must be an administrator.");
}

$conn->close();
?>