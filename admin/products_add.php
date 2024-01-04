<?php

require 'includes/session.php';
require 'includes/slugify.php';

if (isset($_POST['add'])) {
	$name = $_POST['name'];
	$slug = slugify($name);
	$category = $_POST['category'];
	$price = $_POST['price'];
	$description = $_POST['description'];
	$filename = $_FILES['photo']['name'];

	$conn = $pdo->open();

	$sql = "SELECT *, COUNT(*) AS numrows FROM products WHERE slug = :slug";
	$stmt = $conn->prepare($sql);
	$stmt->execute(['slug' => $slug]);
	$row = $stmt->fetch();

	if ($row['numrows'] > 0) {
		$_SESSION['error'] = 'Este produto já existe.';
	} else {
		if (!empty($filename)) {
			$ext = pathinfo($filename, PATHINFO_EXTENSION);
			$newFilename = $slug . '.' . $ext;

			move_uploaded_file($_FILES['photo']['tmp_name'], '../images/' . $newFilename);
		} else {
			$newFilename = '';
		}

		try {
			$sql = "INSERT INTO 
						products (category_id, name, description, slug, price, photo) 
					VALUES 
						(:category, :name, :description, :slug, :price, :photo)";

			$stmt = $conn->prepare($sql);
			$stmt->execute(['category' => $category, 'name' => $name, 'description' => $description, 'slug' => $slug, 'price' => $price, 'photo' => $newFilename]);
			$_SESSION['success'] = 'Usuário adicionado com sucesso.';
		} catch (PDOException $e) {
			$_SESSION['error'] = $e->getMessage();
		}
	}

	$pdo->close();
} else {
	$_SESSION['error'] = 'Favor primeiro preencher o formulário de produto.';
}

header('location: products.php');
