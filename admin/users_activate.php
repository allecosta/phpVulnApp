<?php

include 'includes/session.php';

if (isset($_POST['activate'])) {
	$id = $_POST['id'];

	$conn = $pdo->open();

	try {
		$sql = "UPDATE users SET status = :status WHERE id = :id";
		$stmt = $conn->prepare($sql);
		$stmt->execute(['status' => 1, 'id' => $id]);
		$_SESSION['success'] = 'Usuário ativado com sucesso.';
	} catch (PDOException $e) {
		$_SESSION['error'] = $e->getMessage();
	}

	$pdo->close();
} else {
	$_SESSION['error'] = 'Favor, primeiro selecione o usuário para que seja ativado.';
}

header('location: users.php');
