<?php

require_once 'includes/session.php';

if (isset($_GET['pay'])) {
	$payid = $_GET['pay'];
	$date = date('Y-m-d');

	$conn = $pdo->open();

	try {
		$sql = "INSERT INTO sales (user_id, pay_id, sales_date) VALUES (:user_id, :pay_id, :sales_date)";
		$stmt = $conn->prepare($sql);
		$stmt->execute([
						'user_id' => $user['id'], 
						'pay_id' => $payid, 
						'sales_date' => $date
					]);

		$salesid = $conn->lastInsertId();
		
		try {
			$sql = "SELECT * FROM cart LEFT JOIN products ON products.id = cart.product_id WHERE user_id = :user_id";
			$stmt = $conn->prepare($sql);
			$stmt->execute(['user_id'=>$user['id']]);

			foreach($stmt as $row) {
				$sql = "INSERT INTO details (sales_id, product_id, quantity) VALUES (:sales_id, :product_id, :quantity)";
				$stmt = $conn->prepare($sql);
				$stmt->execute(['
								sales_id' => $salesid, 
								'product_id' => $row['product_id'], 
								'quantity' => $row['quantity']
							]);
			}

			$sql = "DELETE FROM cart WHERE user_id = :user_id";
			$stmt = $conn->prepare($sql);
			$stmt->execute(['user_id' => $user['id']]);

			$_SESSION['success'] = 'Transação bem sucedida! Obrigado(a).';

		} catch(PDOException $e) {
			$_SESSION['error'] = $e->getMessage();
		}

	} catch(PDOException $e) {
		$_SESSION['error'] = $e->getMessage();
	}

	$pdo->close();
}

header('location: profile.php');
exit();
