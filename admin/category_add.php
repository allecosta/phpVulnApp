<?php

require 'includes/session.php';

if (isset($_POST['add'])) {
	$name = $_POST['name'];

	$conn = $pdo->open();

	$stmt = $conn->prepare("SELECT *, COUNT(*) AS numrows FROM category WHERE name = :name");
	$stmt->execute(['name' => $name]);
	$row = $stmt->fetch();

	if ($row['numrows'] > 0) {
		$_SESSION['error'] = 'Essa categoria já existe.';
	} else {
		try {
			$stmt = $conn->prepare("INSERT INTO category (name) VALUES (:name)");
			$stmt->execute(['name' => $name]);
			$_SESSION['success'] = 'Categoria adicionada com sucesso.';
		} catch (PDOException $e) {
			$_SESSION['error'] = $e->getMessage();
		}
	}

	$pdo->close();
} else {
	$_SESSION['error'] = 'Favor primeiro preencher o formulário de categoria.';
}

header('location: category.php');
