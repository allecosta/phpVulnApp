<?php

/**
 * Arquivo inserido em signup.php
 * 
 */

require 'includes/session.php';

if (isset($_SESSION['user'])) {
    header('location: cart_view.php');
    exit();
}

if (isset($_SESSION['captcha'])) {
    $now = time();

    if ($now >= $_SESSION['captcha']) {
        unset($_SESSION['captcha']);
    }
}

require_once 'includes/header.php';
