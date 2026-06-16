<?php
session_start();
require 'db.php';

if ($_SERVER['REQUEST_METHOD'] == 'POST' && isset($_SESSION['uid'])) {
    $title = $conn->real_escape_string($_POST['title']);
    $t_desc = $conn->real_escape_string($_POST['title_description']);
    $l_desc = $conn->real_escape_string($_POST['long_description']);
    $user_id = $_SESSION['uid'];

    // Logica pentru Upload Imagine
    $target_dir = "templates/pictures/";
    $file_name = time() . "_" . basename($_FILES["img"]["name"]); // Nume unic
    $target_file = $target_dir . $file_name;

    if (move_uploaded_file($_FILES["img"]["tmp_name"], $target_file)) {
        // Dacă poza s-a încărcat, salvăm în baza de date
        $sql = "INSERT INTO galleries (title, title_description, long_description, img, id_user) 
                VALUES ('$title', '$t_desc', '$l_desc', '$file_name', '$user_id')";

        if ($conn->query($sql) === TRUE) {
            header("Location: manage_galleries.php");
            exit();
        } else {
            echo "Database error: " . $conn->error;
        }
    } else {
        echo "Sorry, there was an error uploading your file.";
    }
}
$conn->close();
?>