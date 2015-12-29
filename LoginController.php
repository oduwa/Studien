<?php
	
	session_start();
	
	$_SESSION['current_username'] = $_GET['username'];
	$_SESSION['current_firstName'] = $_GET['fname'];
	$_SESSION['current_lastName'] = $_GET['lname'];
	$_SESSION['current_bio'] = $_GET['bio'];
	$_SESSION['current_userRole'] = $_GET['role'];

	header('Location: Dashboard.php');
	
	
?>