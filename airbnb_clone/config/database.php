<?php
// Database configuration
define('DB_HOST', 'localhost');
define('DB_NAME', 'airbnb_clone');
define('DB_USER', 'root');
define('DB_PASS', '');

// Make database connection optional for initial testing
$pdo = null;
try {
    $pdo = new PDO(
        "mysql:host=" . DB_HOST . ";dbname=" . DB_NAME,
        DB_USER,
        DB_PASS,
        [PDO::ATTR_ERRMODE => PDO::ERRMODE_EXCEPTION]
    );
} catch(PDOException $e) {
    error_log("Database connection not available: " . $e->getMessage());
    // Continue without database connection
}
