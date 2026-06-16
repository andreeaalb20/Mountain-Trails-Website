<?php
	session_start();
	$loginuser = htmlspecialchars(stripslashes(trim($_POST['username'])));
	$loginpassword = htmlspecialchars(stripslashes(trim($_POST['password'])));
	require 'db.php';

	$stmt = $conn->prepare("SELECT * FROM users WHERE user = ?");
	$stmt->bind_param("s", $loginuser);
	$stmt->execute();
	$row = $stmt->get_result()->fetch_assoc();
	if ($row && password_verify($loginpassword, $row['password'])){
		echo "valid!";
		$_SESSION['uname'] = $loginuser;
		$_SESSION['uid'] = $row['id'];
		$_SESSION['uimage'] = $row['user_image'];
		$_SESSION['udescription'] = $row['user_short_description'];
		Header("Location:index.php");
	} else {
		echo '<script>alert("Wrong username or password!!!");location.replace("login_form.php");</script>';
		//sleep(5);
		//Header("Location:login_form.php");
	}
	$stmt->close();
	$conn->close();
?>