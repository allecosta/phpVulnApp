<?php

require 'includes/session.php';

if (isset($_POST['delete'])) {
	$id = $_POST['id'];

	$conn = $pdo->open();

	try {
		$stmt = $conn->prepare("DELETE FROM category WHERE id = :id");
		$stmt->execute(['id' => $id]);

		$_SESSION['success'] = 'Categoria excluida com sucesso.';
	} catch (PDOException $e) {
		$_SESSION['error'] = $e->getMessage();
	}

	$pdo->close();
} else {
	$_SESSION['error'] = 'Selecione primeiro a categoria a ser excluida.';
}

header('location: category.php');
