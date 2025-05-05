<?php

require_once __DIR__ . '/../models/User.php';

class UserController {
    private $userModel;

    public function __construct($pdo) {
        $this->userModel = new User($pdo);
    }

    public function register() {
        $errors = [];

        // Validate input
        $name = trim($_POST['name'] ?? '');
        $email = trim($_POST['email'] ?? '');
        $password = $_POST['password'] ?? '';
        $confirmPassword = $_POST['confirm_password'] ?? '';

        if (empty($name)) {
            $errors[] = 'Name is required';
        }

        if (empty($email)) {
            $errors[] = 'Email is required';
        } elseif (!filter_var($email, FILTER_VALIDATE_EMAIL)) {
            $errors[] = 'Invalid email format';
        }

        if (empty($password)) {
            $errors[] = 'Password is required';
        } elseif (strlen($password) < 6) {
            $errors[] = 'Password must be at least 6 characters';
        }

        if ($password !== $confirmPassword) {
            $errors[] = 'Passwords do not match';
        }

        if (!empty($errors)) {
            $_SESSION['errors'] = $errors;
            $_SESSION['old_input'] = ['name' => $name, 'email' => $email];
            header('Location: ?page=register');
            exit();
        }

        // Attempt to create user
        $result = $this->userModel->create($name, $email, $password);

        if (isset($result['error'])) {
            $_SESSION['errors'] = [$result['error']];
            $_SESSION['old_input'] = ['name' => $name, 'email' => $email];
            header('Location: ?page=register');
            exit();
        }

        // Log the user in
        $_SESSION['user_id'] = $result['user_id'];
        $_SESSION['user_name'] = $name;
        $_SESSION['success'] = 'Registration successful! Welcome to AirbnbClone.';
        
        header('Location: ?page=home');
        exit();
    }

    public function login() {
        $errors = [];

        // Validate input
        $email = trim($_POST['email'] ?? '');
        $password = $_POST['password'] ?? '';

        if (empty($email) || empty($password)) {
            $errors[] = 'Both email and password are required';
        }

        if (!empty($errors)) {
            $_SESSION['errors'] = $errors;
            $_SESSION['old_input'] = ['email' => $email];
            header('Location: ?page=login');
            exit();
        }

        // Attempt to authenticate
        $result = $this->userModel->authenticate($email, $password);

        if (isset($result['error'])) {
            $_SESSION['errors'] = [$result['error']];
            $_SESSION['old_input'] = ['email' => $email];
            header('Location: ?page=login');
            exit();
        }

        // Set session
        $_SESSION['user_id'] = $result['user_id'];
        $_SESSION['user_name'] = $result['name'];
        $_SESSION['success'] = 'Welcome back!';

        header('Location: ?page=home');
        exit();
    }

    public function logout() {
        // Clear all session variables
        $_SESSION = [];

        // Destroy the session
        session_destroy();

        // Redirect to home page
        header('Location: ?page=home');
        exit();
    }

    public function profile() {
        if (!isset($_SESSION['user_id'])) {
            header('Location: ?page=login');
            exit();
        }

        $user = $this->userModel->getById($_SESSION['user_id']);
        
        if (!$user) {
            $_SESSION['errors'] = ['User not found'];
            header('Location: ?page=home');
            exit();
        }

        // Load profile view with user data
        view('users/profile', ['user' => $user]);
    }

    public function updateProfile() {
        if (!isset($_SESSION['user_id'])) {
            header('Location: ?page=login');
            exit();
        }

        $errors = [];
        $name = trim($_POST['name'] ?? '');
        $email = trim($_POST['email'] ?? '');
        $currentPassword = $_POST['current_password'] ?? '';
        $newPassword = $_POST['new_password'] ?? '';
        $confirmNewPassword = $_POST['confirm_new_password'] ?? '';

        // Validate input
        if (empty($name)) {
            $errors[] = 'Name is required';
        }

        if (empty($email)) {
            $errors[] = 'Email is required';
        } elseif (!filter_var($email, FILTER_VALIDATE_EMAIL)) {
            $errors[] = 'Invalid email format';
        }

        // If changing password
        if (!empty($newPassword)) {
            if (empty($currentPassword)) {
                $errors[] = 'Current password is required to set new password';
            }
            if (strlen($newPassword) < 6) {
                $errors[] = 'New password must be at least 6 characters';
            }
            if ($newPassword !== $confirmNewPassword) {
                $errors[] = 'New passwords do not match';
            }
        }

        if (!empty($errors)) {
            $_SESSION['errors'] = $errors;
            header('Location: ?page=profile');
            exit();
        }

        // Update user data
        $updateData = [
            'name' => $name,
            'email' => $email
        ];

        if (!empty($newPassword)) {
            $updateData['password'] = password_hash($newPassword, PASSWORD_DEFAULT);
        }

        $result = $this->userModel->update($_SESSION['user_id'], $updateData);

        if (isset($result['error'])) {
            $_SESSION['errors'] = [$result['error']];
            header('Location: ?page=profile');
            exit();
        }

        $_SESSION['success'] = 'Profile updated successfully';
        header('Location: ?page=profile');
        exit();
    }
}
