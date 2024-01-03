<?php

require 'includes/session.php';

if (isset($_POST['edit'])) {
	$id = $_POST['id'];
	$name = $_POST['name'];

	try {
		$stmt = $conn->prepare("UPDATE category SET name = :name WHERE id = :id");
		$stmt->execute(['name' => $name, 'id' => $id]);
		$_SESSION['success'] = 'Categoria atualizada com sucesso';
	} catch (PDOException $e) {
		$_SESSION['error'] = $e->getMessage();
	}

	$pdo->close();
} else {
	$_SESSION['error'] = 'Favor primeiro preencher o formulário de edição. ';
}

header('location: category.php');
