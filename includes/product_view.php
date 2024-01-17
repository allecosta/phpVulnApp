<?php

/**
 * Arquivo inserido em product.php
 * 
 */

require 'includes/session.php';

$conn = $pdo->open();

$slug = $_GET['product'];

try {
    $sql = "SELECT 
				*, products.name AS prodname, category.name AS catname, products.id AS prodid 
			FROM 
				products 
			LEFT JOIN 
				category ON category.id = products.category_id 
			WHERE slug = :slug";

    $stmt = $conn->prepare($sql);
    $stmt->execute(['slug' => $slug]);
    $product = $stmt->fetch();
} catch (PDOException $e) {
    echo "OPS! Há algum problema de conexão: " . $e->getMessage();
}

$now = date('Y-m-d');

if ($product['date_view'] == $now) {
    $sql = "UPDATE products SET counter = counter + 1 WHERE id = :id";
    $stmt = $conn->prepare($sql);
    $stmt->execute(['id' => $product['prodid']]);
} else {
    $sql = "UPDATE products SET counter = 1, date_view = :now WHERE id = :id";
    $stmt = $conn->prepare($sql);
    $stmt->execute(['id' => $product['prodid'], 'now' => $now]);
}


require_once 'includes/header.php';
