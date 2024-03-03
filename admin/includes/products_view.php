<?php

/**
 * Arquivo inserido em products.php
 * 
 */

require 'includes/session.php';

$catID = 0;

if (isset($_GET['category'])) {
    $catID = $_GET['category'];
}

require_once 'includes/header.php';
