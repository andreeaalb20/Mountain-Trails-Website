<?php
	session_start();
	if(!isset($_SESSION['uname'])){
		header("Location:login_form.php");
		exit;
	}elseif(!isset($_GET['id'])){
		header("Location:logout.php");
		exit;
	}else{
		//check if user is owner of gallery
		require 'db.php';
		$stmt = $conn->prepare("SELECT id_user,img FROM galleries WHERE id = ?");
		$stmt->bind_param("i", $_GET['id']);
		$stmt->execute();
		$row = $stmt->get_result()->fetch_assoc();
		if($row && ($row['id_user']==$_SESSION['uid'] || $_SESSION['uid']==1)){
			//ok proceed to delete
			//delete gallery image from server
			unlink("templates/pictures/".$row['img']);
			
			//delete gallery images files from server
			$stmt = $conn->prepare("SELECT picture FROM pictures WHERE id_gallery = ?");
			$stmt->bind_param("i", $_GET['id']);
			$stmt->execute();
			$result = $stmt->get_result();
			while($row = $result->fetch_assoc()){
				unlink("templates/pictures/".$row['picture']);
			}
			
			$stmt = $conn->prepare("DELETE FROM comments WHERE gallery_id = ?");
            $stmt->bind_param("i", $_GET['id']);
            $stmt->execute();
			
			//delete gallery from database
			//no need to delete records from table"pictures" if we have FK and on delete cascade option enabled
			$stmt = $conn->prepare("DELETE FROM galleries WHERE id = ?");
			$stmt->bind_param("i", $_GET['id']);
			$stmt->execute();
			$stmt->close();
			$conn->close();
			header("Location:manage_galleries.php");
			exit;
		}else{
			header("Location:logout.php");
			exit;
		}
	}
?>