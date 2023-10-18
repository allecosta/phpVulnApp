<?php

require_once 'includes/session.php';

$conn = $pdo->open();
$output = ['error' => false];
$id = $_POST['id'];
$quantity = $_POST['quantity'];

if (isset($_SESSION['user'])) {
	$sql = "SELECT *, COUNT(*) AS numrows FROM cart WHERE user_id=:user_id AND product_id=:product_id";
	$stmt = $conn->prepare($sql);
	$stmt->execute(['user_id' => $user['id'], 'product_id' => $id]);
	$row = $stmt->fetch();

	if ($row['numrows'] < 1) {
		try {
			$sql = "INSERT INTO cart (user_id, product_id, quantity) VALUES (:user_id, :product_id, :quantity)";
			$stmt = $conn->prepare($sql);
			$stmt->execute(['user_id' => $user['id'], 'product_id' => $id, 'quantity' => $quantity]);
			$output['message'] = 'Item adicionado ao carrinho';
			
		} catch(PDOException $e) {
			$output['error'] = true;
			$output['message'] = $e->getMessage();
		}
	} else {
		$output['error'] = true;
		$output['message'] = 'Product already in cart';
	}
} else {
	if (!isset($_SESSION['cart'])) {
		$_SESSION['cart'] = [];
	}

	$exist = [];

	foreach($_SESSION['cart'] as $row) {
		array_push($exist, $row['productid']);
	}

	if (in_array($id, $exist)) {
		$output['error'] = true;
		$output['message'] = 'Este produto já existe no carrinho';
	} else {
		$data['productid'] = $id;
		$data['quantity'] = $quantity;

		if (array_push($_SESSION['cart'], $data)) {
			$output['message'] = 'Item adicionado de carrinho';
		} else {
			$output['error'] = true;
			$output['message'] = 'Não é possível adicionar este item ao carrinho';
		}
	}
}

$pdo->close();

echo json_encode($output);
