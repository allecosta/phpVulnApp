<?php

require 'includes/session.php';

if (isset($_POST['edit'])) {
	$userID = $_POST['userid'];
	$cartID = $_POST['cartid'];
	$quantity = $_POST['quantity'];

	$conn = $pdo->open();

	try {
		$sql = "UPDATE cart SET quantity = :quantity WHERE id = :id";
		$stmt = $conn->prepare($sql);
		$stmt->execute(['quantity' => $quantity, 'id' => $cartID]);
		$_SESSION['success'] = 'Quantidade atualizada com sucesso.';
	} catch (PDOException $e) {
		$_SESSION['error'] = $e->getMessage();
	}

	$pdo->close();

	header('location: cart.php?user=' . $userID);
	exit();
}
