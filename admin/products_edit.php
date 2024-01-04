<?php

require 'includes/session.php';
require 'includes/slugify.php';

if (isset($_POST['edit'])) {
	$id = $_POST['id'];
	$name = $_POST['name'];
	$slug = slugify($name);
	$category = $_POST['category'];
	$price = $_POST['price'];
	$description = $_POST['description'];

	$conn = $pdo->open();

	try {
		$sql = "UPDATE 
					products 
				SET 
					name = :name, slug = :slug, category_id = :category, price = :price, description = :description 
				WHERE 
					id = :id";

		$stmt = $conn->prepare($sql);
		$stmt->execute(['name' => $name, 'slug' => $slug, 'category' => $category, 'price' => $price, 'description' => $description, 'id' => $id]);
		$_SESSION['success'] = 'Produto atualizado com sucesso';
	} catch (PDOException $e) {
		$_SESSION['error'] = $e->getMessage();
	}

	$pdo->close();
} else {
	$_SESSION['error'] = 'Favor primeiro preencher o formulário de edição de produto.';
}

header('location: products.php');
