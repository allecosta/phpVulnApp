<?php

require_once 'includes/session.php';

$conn = $pdo->open();
$output = ['error' => false];

$id = $_POST['id'];
$quantity = $_POST['qty'];

if (isset($_SESSION['user'])) {
	try {
		$sql = "UPDATE cart SET quantity=:quantity WHERE id=:id";
		$stmt = $conn->prepare($sql);
		$stmt->execute(['quantity' => $quantity, 'id' => $id]);
		$output['message'] = 'Atualizado!';

	} catch(PDOException $e) {
		$output['message'] = $e->getMessage();
	}
} else {
	foreach($_SESSION['cart'] as $key => $row) {
		if ($row['productid'] == $id) {
			$_SESSION['cart'][$key]['quantity'] = $$quantity;
			$output['message'] = 'Atualizado!';
		}
	}
}

$pdo->close();

echo json_encode($output);
