<?php
	include '../includes/conn.php';
	session_start();
	// $type = $_GET['type'];
	if((!isset($_SESSION['admin']) || trim($_SESSION['admin']) == '') && (!isset($_SESSION['employee']) || trim($_SESSION['employee']) == '')){
		header('location: ../index.php');
		exit();
	}

	$conn = $pdo->open();

	$stmt = $conn->prepare("SELECT * FROM users WHERE id=:id");
	$stmt->execute(['id'=>$_SESSION['admin']]);
	$admin = $stmt->fetch();

	$pdo->close();

?>