<?php

require 'includes/session.php';

if (isset($_POST['delete'])) {
	$id = $_POST['id'];

	$conn = $pdo->open();

	try {
		$sql = "DELETE FROM users WHERE id = :id";
		$stmt = $conn->prepare($sql);
		$stmt->execute(['id' => $id]);

		$_SESSION['success'] = 'Usuário excluído com sucesso.';
	} catch (PDOException $e) {
		$_SESSION['error'] = $e->getMessage();
	}

	$pdo->close();
} else {
	$_SESSION['error'] = 'Favor, primeiro selecionar o usuário a ser excluído.';
}

header('location: users.php');
