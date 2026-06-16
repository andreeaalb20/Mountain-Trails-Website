<?php
session_start();
require 'db.php';

// Verificăm dacă cel care execută este ADMIN (ID 1)
if (!isset($_SESSION['uid']) || $_SESSION['uid'] != 1 || !isset($_GET['id'])) {
    die("Unauthorized access!");
}

$id_to_delete = $_GET['id'];

// Nu permitem Adminului să se șteargă pe sine însuși
if ($id_to_delete == 1) {
    die("You cannot delete the main administrator!");
}

// 1. Ștergem comentariile făcute de acest user
$conn->query("DELETE FROM comments WHERE user_id = $id_to_delete");

// 2. Ștergem galeriile create de acest user 
$conn->query("DELETE FROM galleries WHERE id_user = $id_to_delete");

// 3. Ștergem utilizatorul din tabelul users
$sql = "DELETE FROM users WHERE id = $id_to_delete";

if ($conn->query($sql) === TRUE) {
    header("Location: manage_users.php");
    exit();
} else {
    echo "Error: " . $conn->error;
}

$conn->close();
?>