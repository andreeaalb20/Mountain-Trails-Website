<?php
	session_start();
	
	$username = $password = $confirm_password = "";
	$username_err = $password_err = $confirm_password_err = "";
	
	require 'db.php';
	
	if(isset($_SESSION["uname"]) && $_SESSION["uname"] === true){
		header("location:logout.php");
		exit;
	}
	
	if($_SERVER["REQUEST_METHOD"] == "POST"){
 
		// Validate username
		if(empty(trim($_POST["username"]))){
			$username_err = "Please enter a username.";
		} else {
			// Prepare a select statement
			$sql = "SELECT id FROM users WHERE user = ?";
			
			if($stmt = $conn->prepare($sql)){
				// Bind variables to the prepared statement as parameters
				$stmt->bind_param("s", $param_username);
				
				// Set parameters
				$param_username = htmlspecialchars(stripslashes(trim($_POST["username"])));

				// Attempt to execute the prepared statement
				if($stmt->execute()){
					// store result
					$stmt->store_result();
					
					if($stmt->num_rows == 1){
						$username_err = "This username is already taken.";
					} else {
						$username = htmlspecialchars(stripslashes(trim($_POST["username"])));
						// echo "username:".$username;
					}
				} else{
					echo "Oops! Something went wrong. Please try again later.";
				}

				// Close statement
				$stmt->close();
			}
		}
		
		// Validate password
		if(empty(trim($_POST["password"]))){
			$password_err = "Please enter a password.";     
		} elseif(strlen(trim($_POST["password"])) < 6){
			$password_err = "Password must have atleast 6 characters.";
		} else{
			$password = htmlspecialchars(stripslashes(trim($_POST["password"])));
		}
		
		// Validate confirm password
		if(empty(trim($_POST["confirm_password"]))){
			$confirm_password_err = "Please confirm password.";     
		} else{
			$confirm_password = htmlspecialchars(stripslashes(trim($_POST["confirm_password"])));
			if(empty($password_err) && ($password != $confirm_password)){
				$confirm_password_err = "Password did not match.";
			}
		}
		
		// Check input errors before inserting in database
		if(empty($username_err) && empty($password_err) && empty($confirm_password_err)){
			
			// Prepare an insert statement
			$sql = "INSERT INTO users (user, password) VALUES (?, ?)";
			 
			if($stmt = $conn->prepare($sql)){
				// Bind variables to the prepared statement as parameters
				$stmt->bind_param("ss", $param_username, $param_password);
				
				// Set parameters
				$param_username = $username;
				$param_password = password_hash($password, PASSWORD_DEFAULT); // Creates a password hash
				
				// Attempt to execute the prepared statement
				if($stmt->execute()){
					// Redirect to login page
					header("location: login_form.php");
				} else{
					echo "Oops! Something went wrong. Please try again later.";
				}

				// Close statement
				$stmt->close();
			}
		}
		// echo $username_err;
		// Close connection
		$conn->close();
	}
?>