<?php
// Start output buffering and session at the very beginning
ob_start();
session_start();

// Enable error reporting for debugging
error_reporting(E_ALL);
ini_set('display_errors', 1);

// Set default timezone
date_default_timezone_set('UTC');

// Include helper functions first
require_once __DIR__ . '/../app/helpers.php';

// Include database configuration
require_once __DIR__ . '/../config/database.php';

// Check database connection
if (!isset($pdo)) {
    die("Database connection failed. Please check your configuration.");
}

// Default route handling
if (!isset($_GET['page'])) {
    redirect('home');
}

// Include routes
require_once __DIR__ . '/../app/routes.php';

// Flush output buffer
ob_end_flush();
