<?php

/**
 * Arquivo inserido em products.php
 * 
 */

require 'includes/session.php';

//$where = '';

if (isset($_GET['category'])) {
    $catID = $_GET['category'];
    //$where = 'WHERE category_id =' . $catID;
}

require_once 'includes/header.php';
