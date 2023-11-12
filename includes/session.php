<?php

require 'includes/Database.php';

session_start();

if (isset($_SESSION['admin'])) {
	header('location: admin/home.php');
	exit();
}

if (isset($_SESSION['user'])) {
	$conn = $pdo->open();

	try {
		$sql = "SELECT * FROM users WHERE id = :id";
		$stmt = $conn->prepare($sql);
		$stmt->execute(['id' => $_SESSION['user']]);
		$user = $stmt->fetch();

	} catch(PDOException $e) {
		echo "OPS! Há algum problema de conexão: " . $e->getMessage();
	}

	$pdo->close();
}