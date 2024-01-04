<?php

require 'includes/session.php';

if (isset($_POST['upload'])) {
	$id = $_POST['id'];
	$filename = $_FILES['photo']['name'];

	$conn = $pdo->open();

	$sql = "SELECT * FROM products WHERE id = :id";
	$stmt = $conn->prepare($sql);
	$stmt->execute(['id' => $id]);
	$row = $stmt->fetch();

	if (!empty($filename)) {
		$ext = pathinfo($filename, PATHINFO_EXTENSION);
		$newFilename = $row['slug'] . '_' . time() . '.' . $ext;

		move_uploaded_file($_FILES['photo']['tmp_name'], '../images/' . $newFilename);
	}

	try {
		$sql = "UPDATE products SET photo = :photo WHERE id = :id";
		$stmt = $conn->prepare($sql);
		$stmt->execute(['photo' => $newFilename, 'id' => $id]);
		$_SESSION['success'] = 'Foto do produto atualizada com sucesso.';
	} catch (PDOException $e) {
		$_SESSION['error'] = $e->getMessage();
	}

	$pdo->close();
} else {
	$_SESSION['error'] = 'Favor selecionar primeiro a foto do produto a ser atualizada.';
}

header('location: products.php');
