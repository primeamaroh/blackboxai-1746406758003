<?php
ob_start(); // Start output buffering
session_start();

// Include database configuration
require_once __DIR__ . '/../config/database.php';

// Include routes
require_once __DIR__ . '/../app/routes.php';

// Default route handling
if (!isset($_GET['page'])) {
    ob_end_clean(); // Clean output buffer
    header('Location: ?page=home');
    exit();
}

// End output buffering and send output
ob_end_flush();
