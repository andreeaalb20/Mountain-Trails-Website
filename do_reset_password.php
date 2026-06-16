<?php
session_start();
require 'db.php';

if ($_SERVER['REQUEST_METHOD'] == 'POST' && isset($_SESSION['uid'])) {
    $pass1 = $_POST['new_password'];
    $pass2 = $_POST['confirm_password'];
    $user_id = $_SESSION['uid'];

    if ($pass1 !== $pass2) {
        header("Location: reset_password_form.php?error=mismatch");
        exit();
    }

    // Criptăm noua parolă folosind metoda modernă (pe care am testat-o la admin)
    $hashed_password = password_hash($pass1, PASSWORD_DEFAULT);

    $sql = "UPDATE users SET password = '$hashed_password' WHERE id = $user_id";

    if ($conn->query($sql) === TRUE) {
        // Redirecționăm la setări cu un mesaj de succes
        header("Location: settings.php?success=password");
        exit();
    } else {
        echo "Error updating password: " . $conn->error;
    }
}
$conn->close();
?>