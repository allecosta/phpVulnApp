<?php

require 'includes/session.php';

if (isset($_POST['id'])) {
	$id = $_POST['id'];

	$conn = $pdo->open();

	try {
		$sql = "SELECT 
					*, cart.id AS cartid 
				FROM 
					cart 
				LEFT JOIN 
					products ON products.id = cart.product_id 
				WHERE cart.id = :id";

		$stmt = $conn->prepare($sql);
		$stmt->execute(['id' => $id]);
		$row = $stmt->fetch();
	} catch (PDOException $e) {
		echo "OPS! Há algum problema na conexão: " . $e->getMessage();
	}

	$pdo->close();

	echo json_encode($row);
}
