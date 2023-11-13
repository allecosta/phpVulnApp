<?php

require 'includes/session.php';

if (isset($_POST['delete'])) {
	$userID = $_POST['userid'];
	$cartID = $_POST['cartid'];

	$conn = $pdo->open();

	try {
		$sql = "DELETE FROM cart WHERE id = :id";
		$stmt = $conn->prepare($sql);
		$stmt->execute(['id' => $cartID]);
		$_SESSION['success'] = 'Produto excluído do carrinho.';
	} catch (PDOException $e) {
		$_SESSION['error'] = $e->getMessage();
	}

	$pdo->close();

	header('location: cart.php?user=' . $userID);
	exit();
}
