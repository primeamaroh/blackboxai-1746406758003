<?php

class User {
    private $pdo;

    public function __construct($pdo) {
        $this->pdo = $pdo;
    }

    public function create($name, $email, $password) {
        try {
            // Check if email already exists
            $stmt = $this->pdo->prepare("SELECT id FROM users WHERE email = ?");
            $stmt->execute([$email]);
            if ($stmt->fetch()) {
                return ['error' => 'Email already exists'];
            }

            // Hash password
            $hashedPassword = password_hash($password, PASSWORD_DEFAULT);

            // Insert new user
            $stmt = $this->pdo->prepare("
                INSERT INTO users (name, email, password, created_at, updated_at) 
                VALUES (?, ?, ?, datetime('now'), datetime('now'))
            ");
            
            $stmt->execute([$name, $email, $hashedPassword]);
            return ['success' => true, 'user_id' => $this->pdo->lastInsertId()];
        } catch (PDOException $e) {
            error_log("Error creating user: " . $e->getMessage());
            return ['error' => 'Registration failed. Please try again.'];
        }
    }

    public function authenticate($email, $password) {
        try {
            $stmt = $this->pdo->prepare("SELECT id, password, name, credit_score FROM users WHERE email = ?");
            $stmt->execute([$email]);
            $user = $stmt->fetch(PDO::FETCH_ASSOC);

            if ($user && password_verify($password, $user['password'])) {
                return [
                    'success' => true,
                    'user_id' => $user['id'],
                    'name' => $user['name'],
                    'credit_score' => $user['credit_score']
                ];
            }
            return ['error' => 'Invalid email or password'];
        } catch (PDOException $e) {
            error_log("Error authenticating user: " . $e->getMessage());
            return ['error' => 'Login failed. Please try again.'];
        }
    }

    public function getById($id) {
        try {
            $stmt = $this->pdo->prepare("SELECT id, name, email, credit_score, created_at FROM users WHERE id = ?");
            $stmt->execute([$id]);
            return $stmt->fetch(PDO::FETCH_ASSOC);
        } catch (PDOException $e) {
            error_log("Error fetching user: " . $e->getMessage());
            return null;
        }
    }

    public function update($id, $data) {
        try {
            $fields = [];
            $values = [];
            foreach ($data as $key => $value) {
                if ($key !== 'id') {
                    $fields[] = "$key = ?";
                    $values[] = $value;
                }
            }
            $values[] = $id;

            $sql = "UPDATE users SET " . implode(', ', $fields) . ", updated_at = datetime('now') WHERE id = ?";
            $stmt = $this->pdo->prepare($sql);
            $stmt->execute($values);

            return ['success' => true];
        } catch (PDOException $e) {
            error_log("Error updating user: " . $e->getMessage());
            return ['error' => 'Update failed. Please try again.'];
        }
    }

    public function delete($id) {
        try {
            $stmt = $this->pdo->prepare("DELETE FROM users WHERE id = ?");
            $stmt->execute([$id]);
            return ['success' => true];
        } catch (PDOException $e) {
            error_log("Error deleting user: " . $e->getMessage());
            return ['error' => 'Delete failed. Please try again.'];
        }
    }
}
