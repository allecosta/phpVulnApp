<?php

/**
 * Arquivo inserido em cart.php
 * 
 */

require 'includes/session.php';

if (!isset($_GET['user'])) {
    header('location: users.php');
    exit();
} else {
    $conn = $pdo->open();

    $sql = "SELECT * FROM users WHERE id = :id";
    $stmt = $conn->prepare($sql);
    $stmt->execute(['id' => $_GET['user']]);
    $user = $stmt->fetch();

    $pdo->close();
}

require_once 'includes/header.php';
