<?php

/**
 * Arquivo inserido em login.php
 * 
 */

require 'includes/session.php';

if (isset($_SESSION['user'])) {
    header('location: cart_view.php');
    exit();
}

require_once 'includes/header.php';
