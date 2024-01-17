<?php

/**
 * Arquivo inserido em profile.php
 * 
 */

require 'includes/session.php';

if (!isset($_SESSION['user'])) {
    header('location: index.php');
    exit();
}

require_once 'includes/header.php';
