<?php

require 'includes/session.php';

if (isset($_POST['id'])) {
	$id = $_POST['id'];

	$conn = $pdo->open();

	$sql = "SELECT * FROM users WHERE id = :id";
	$stmt = $conn->prepare($sql);
	$stmt->execute(['id' => $id]);
	$row = $stmt->fetch();

	$pdo->close();

	echo json_encode($row);
}
