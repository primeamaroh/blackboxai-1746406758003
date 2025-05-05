<?php

// Function to load view with header and footer
function view($name, $data = []) {
    extract($data);
    require_once __DIR__ . '/../views/layouts/header.php';
    require_once __DIR__ . "/../views/{$name}.php";
    require_once __DIR__ . '/../views/layouts/footer.php';
}

// Function to redirect
function redirect($page) {
    ob_clean(); // Clean any output before redirect
    header("Location: ?page=$page");
    exit();
}

// Function to check if user is logged in
function isLoggedIn() {
    return isset($_SESSION['user_id']);
}

// Function to get current user
function getCurrentUser($pdo) {
    if (isLoggedIn()) {
        require_once __DIR__ . '/models/User.php';
        $userModel = new User($pdo);
        return $userModel->getById($_SESSION['user_id']);
    }
    return null;
}
