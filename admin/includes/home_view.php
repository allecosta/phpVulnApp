<?php

/**
 * Arquivo inserido em home.php
 * 
 */

require 'includes/session.php';
require 'includes/format.php';

$today = date('Y-m-d');
$year = date('Y');

if (isset($_GET['year'])) {
    $year = $_GET['year'];
}

$conn = $pdo->open();

require_once 'includes/header.php';
