<?php
session_start();
require 'db.php';

// Verificam daca utilizatorul este logat si daca a trimis datele prin POST
if (isset($_SESSION['uid']) && $_SERVER['REQUEST_METHOD'] == 'POST') {
    
    $gallery_id = $_POST['gallery_id'];
    $user_id = $_SESSION['uid'];
    $comment_text = $conn->real_escape_string($_POST['comment_text']);

    // Inserwm comentariul in baza de date
    $sql = "INSERT INTO comments (gallery_id, user_id, comment_text) 
            VALUES ('$gallery_id', '$user_id', '$comment_text')";

    if ($conn->query($sql) === TRUE) {
        // Daca s-a salvat cu succes, ne intoarcem la pagina traseului
        header("Location: show_gallery.php?id=" . $gallery_id);
        exit();
    } else {
        echo "Error: " . $sql . "<br>" . $conn->error;
    }
} else {
    // Daca cineva incearca sa acceseze fisierul direct, il trimitem la prima pagina
    header("Location: index.php");
    exit();
}

$conn->close();
?>