<?php

require_once 'includes/session.php';

$conn = $pdo->open();
$output = ['error' => false];
$id = $_POST['id'];

if (isset($_SESSION['user'])) {
	try {
		$sql = "DELETE FROM cart WHERE id=:id";
		$stmt = $conn->prepare($sql);
		$stmt->execute(['id'=>$id]);
		$output['message'] = 'Excluido';
		
	} catch(PDOException $e) {
		$output['message'] = $e->getMessage();
	}
} else {
	foreach($_SESSION['cart'] as $key => $row) {
		if ($row['productid'] == $id) {
			unset($_SESSION['cart'][$key]);

			$output['message'] = 'Excluido';
		}
	}
}

$pdo->close();

echo json_encode($output);
