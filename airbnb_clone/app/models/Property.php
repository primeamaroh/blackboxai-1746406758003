<?php

class Property {
    private $pdo;

    public function __construct($pdo) {
        $this->pdo = $pdo;
    }

    public function create($data) {
        try {
            $sql = "INSERT INTO properties (
                user_id, title, description, location, price, 
                image_url, created_at
            ) VALUES (?, ?, ?, ?, ?, ?, NOW())";

            $stmt = $this->pdo->prepare($sql);
            $stmt->execute([
                $data['user_id'],
                $data['title'],
                $data['description'],
                $data['location'],
                $data['price'],
                $data['image_url']
            ]);

            return ['success' => true, 'property_id' => $this->pdo->lastInsertId()];
        } catch (PDOException $e) {
            error_log("Error creating property: " . $e->getMessage());
            return ['error' => 'Failed to create property. Please try again.'];
        }
    }

    public function getAll($limit = null, $offset = 0) {
        try {
            $sql = "SELECT p.*, u.name as host_name 
                   FROM properties p 
                   JOIN users u ON p.user_id = u.id 
                   ORDER BY p.created_at DESC";

            if ($limit !== null) {
                $sql .= " LIMIT ? OFFSET ?";
            }

            $stmt = $this->pdo->prepare($sql);
            
            if ($limit !== null) {
                $stmt->execute([$limit, $offset]);
            } else {
                $stmt->execute();
            }

            return $stmt->fetchAll(PDO::FETCH_ASSOC);
        } catch (PDOException $e) {
            error_log("Error fetching properties: " . $e->getMessage());
            return [];
        }
    }

    public function getById($id) {
        try {
            $sql = "SELECT p.*, u.name as host_name 
                   FROM properties p 
                   JOIN users u ON p.user_id = u.id 
                   WHERE p.id = ?";
            
            $stmt = $this->pdo->prepare($sql);
            $stmt->execute([$id]);
            
            return $stmt->fetch(PDO::FETCH_ASSOC);
        } catch (PDOException $e) {
            error_log("Error fetching property: " . $e->getMessage());
            return null;
        }
    }

    public function update($id, $data) {
        try {
            $fields = [];
            $values = [];
            
            foreach ($data as $key => $value) {
                if ($key !== 'id' && $key !== 'user_id') {
                    $fields[] = "$key = ?";
                    $values[] = $value;
                }
            }
            
            $values[] = $id;
            $values[] = $data['user_id']; // For owner verification

            $sql = "UPDATE properties 
                   SET " . implode(', ', $fields) . " 
                   WHERE id = ? AND user_id = ?";
            
            $stmt = $this->pdo->prepare($sql);
            $result = $stmt->execute($values);

            if ($stmt->rowCount() === 0) {
                return ['error' => 'Property not found or unauthorized'];
            }

            return ['success' => true];
        } catch (PDOException $e) {
            error_log("Error updating property: " . $e->getMessage());
            return ['error' => 'Update failed. Please try again.'];
        }
    }

    public function delete($id, $user_id) {
        try {
            $stmt = $this->pdo->prepare("DELETE FROM properties WHERE id = ? AND user_id = ?");
            $stmt->execute([$id, $user_id]);

            if ($stmt->rowCount() === 0) {
                return ['error' => 'Property not found or unauthorized'];
            }

            return ['success' => true];
        } catch (PDOException $e) {
            error_log("Error deleting property: " . $e->getMessage());
            return ['error' => 'Delete failed. Please try again.'];
        }
    }

    public function search($params) {
        try {
            $conditions = [];
            $values = [];

            if (!empty($params['location'])) {
                $conditions[] = "location LIKE ?";
                $values[] = '%' . $params['location'] . '%';
            }

            if (!empty($params['min_price'])) {
                $conditions[] = "price >= ?";
                $values[] = $params['min_price'];
            }

            if (!empty($params['max_price'])) {
                $conditions[] = "price <= ?";
                $values[] = $params['max_price'];
            }

            $sql = "SELECT p.*, u.name as host_name 
                   FROM properties p 
                   JOIN users u ON p.user_id = u.id";

            if (!empty($conditions)) {
                $sql .= " WHERE " . implode(' AND ', $conditions);
            }

            $sql .= " ORDER BY p.created_at DESC";

            $stmt = $this->pdo->prepare($sql);
            $stmt->execute($values);

            return $stmt->fetchAll(PDO::FETCH_ASSOC);
        } catch (PDOException $e) {
            error_log("Error searching properties: " . $e->getMessage());
            return [];
        }
    }

    public function getUserProperties($user_id) {
        try {
            $stmt = $this->pdo->prepare(
                "SELECT * FROM properties WHERE user_id = ? ORDER BY created_at DESC"
            );
            $stmt->execute([$user_id]);
            return $stmt->fetchAll(PDO::FETCH_ASSOC);
        } catch (PDOException $e) {
            error_log("Error fetching user properties: " . $e->getMessage());
            return [];
        }
    }
}
