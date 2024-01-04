<?php

require 'includes/session.php';

if (isset($_POST['upload'])) {
	$id = $_POST['id'];
	$filename = $_FILES['photo']['name'];

	if (!empty($filename)) {
		move_uploaded_file($_FILES['photo']['tmp_name'], '../images/' . $filename);
	}

	$conn = $pdo->open();

	try {
		$sql = "UPDATE users SET photo = :photo WHERE id = :id";
		$stmt = $conn->prepare($sql);
		$stmt->execute(['photo' => $filename, 'id' => $id]);
		$_SESSION['success'] = 'Foto do usuário atualizada com sucesso.';
	} catch (PDOException $e) {
		$_SESSION['error'] = $e->getMessage();
	}

	$pdo->close();
} else {
	$_SESSION['error'] = 'Favor, primeiro selecione a foto do usuário a ser atualizado.';
}

header('location: users.php');
