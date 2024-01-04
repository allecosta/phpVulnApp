<?php

require_once '../includes/Database.php';

session_start();

if (!isset($_SESSION['admin']) || trim($_SESSION['admin']) == '') {
	header('location: ../index.php');
	exit();
}

$conn = $pdo->open();

$sql = "SELECT * FROM users WHERE id = :id";
$stmt = $conn->prepare($sql);
$stmt->execute(['id' => $_SESSION['admin']]);
$admin = $stmt->fetch();

$pdo->close();
