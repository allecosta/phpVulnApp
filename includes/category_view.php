<?php

/**
 * Arquivo inserido em category.php
 * 
 */

require 'includes/session.php';

$slug = $_GET['category'];

$conn = $pdo->open();

try {
    $sql = "SELECT * FROM category WHERE cat_slug = :slug";
    $stmt = $conn->prepare($sql);
    $stmt->execute(['slug' => $slug]);
    $category = $stmt->fetch();
    $categoryID = $category['id'];
} catch (PDOException $e) {
    echo "OPS! Há algum problema na conexão: " . $e->getMessage();
}

$pdo->close();

require_once 'includes/header.php';
