<?php

require 'includes/session.php';

if (isset($_POST['id'])) {
	$id = $_POST['id'];

	$conn = $pdo->open();

	$sql = "SELECT 
				*, products.id AS prodid, products.name AS prodname, category.name AS catname 
			FROM 
				products 
			LEFT JOIN 
				category ON category.id = products.category_id 
			WHERE 
				products.id = :id";

	$stmt = $conn->prepare($sql);
	$stmt->execute(['id' => $id]);
	$row = $stmt->fetch();

	$pdo->close();

	echo json_encode($row);
}
