<?php

require 'includes/session.php';

if (isset($_POST['add'])) {
	$id = $_POST['id'];
	$product = $_POST['product'];
	$quantity = $_POST['quantity'];

	$conn = $pdo->open();

	try {
		$sql = "SELECT *, COUNT(*) AS numrows FROM cart WHERE product_id=:id";
		$stmt = $conn->prepare($sql);
		$stmt->execute(['id' => $product]);
		$row = $stmt->fetch();
	} catch (PDOException $e) {
		echo "OPS! Há algum problema na conexão: " . $e->getMessage();
	}

	if ($row['numrows'] > 0) {
		$_SESSION['error'] = 'OPS! Este produto já existe no carrinho.';
	} else {
		try {
			$sql = "INSERT INTO cart (user_id, product_id, quantity) VALUES (:user, :product, :quantity)";
			$stmt = $conn->prepare($sql);
			$stmt->execute(['user' => $id, 'product' => $product, 'quantity' => $quantity]);
			$_SESSION['success'] = 'Produto adicionado no carrinho.';
		} catch (PDOException $e) {
			$_SESSION['error'] = $e->getMessage();
		}
	}

	$pdo->close();

	header('location: cart.php?user=' . $id);
	exit();
}
