<?php

class Booking {
    private $pdo;

    public function __construct($pdo) {
        $this->pdo = $pdo;
    }

    public function create($data) {
        try {
            // First check if the property is available for these dates
            if (!$this->isPropertyAvailable($data['property_id'], $data['check_in'], $data['check_out'])) {
                return ['error' => 'Property is not available for these dates'];
            }

            $sql = "INSERT INTO bookings (
                user_id, property_id, check_in, check_out, 
                total_price, created_at
            ) VALUES (?, ?, ?, ?, ?, NOW())";

            $stmt = $this->pdo->prepare($sql);
            $stmt->execute([
                $data['user_id'],
                $data['property_id'],
                $data['check_in'],
                $data['check_out'],
                $data['total_price']
            ]);

            return ['success' => true, 'booking_id' => $this->pdo->lastInsertId()];
        } catch (PDOException $e) {
            error_log("Error creating booking: " . $e->getMessage());
            return ['error' => 'Booking failed. Please try again.'];
        }
    }

    public function isPropertyAvailable($property_id, $check_in, $check_out) {
        try {
            $sql = "SELECT COUNT(*) FROM bookings 
                   WHERE property_id = ? 
                   AND ((check_in BETWEEN ? AND ?) 
                   OR (check_out BETWEEN ? AND ?))";

            $stmt = $this->pdo->prepare($sql);
            $stmt->execute([
                $property_id,
                $check_in,
                $check_out,
                $check_in,
                $check_out
            ]);

            return $stmt->fetchColumn() === 0;
        } catch (PDOException $e) {
            error_log("Error checking property availability: " . $e->getMessage());
            return false;
        }
    }

    public function getUserBookings($user_id) {
        try {
            $sql = "SELECT b.*, p.title, p.location, p.image_url, u.name as host_name 
                   FROM bookings b 
                   JOIN properties p ON b.property_id = p.id 
                   JOIN users u ON p.user_id = u.id 
                   WHERE b.user_id = ? 
                   ORDER BY b.check_in DESC";

            $stmt = $this->pdo->prepare($sql);
            $stmt->execute([$user_id]);
            return $stmt->fetchAll(PDO::FETCH_ASSOC);
        } catch (PDOException $e) {
            error_log("Error fetching user bookings: " . $e->getMessage());
            return [];
        }
    }

    public function getPropertyBookings($property_id) {
        try {
            $sql = "SELECT b.*, u.name as guest_name 
                   FROM bookings b 
                   JOIN users u ON b.user_id = u.id 
                   WHERE b.property_id = ? 
                   ORDER BY b.check_in DESC";

            $stmt = $this->pdo->prepare($sql);
            $stmt->execute([$property_id]);
            return $stmt->fetchAll(PDO::FETCH_ASSOC);
        } catch (PDOException $e) {
            error_log("Error fetching property bookings: " . $e->getMessage());
            return [];
        }
    }

    public function getById($id) {
        try {
            $sql = "SELECT b.*, p.title, p.location, p.image_url, 
                          u.name as guest_name, host.name as host_name 
                   FROM bookings b 
                   JOIN properties p ON b.property_id = p.id 
                   JOIN users u ON b.user_id = u.id 
                   JOIN users host ON p.user_id = host.id 
                   WHERE b.id = ?";

            $stmt = $this->pdo->prepare($sql);
            $stmt->execute([$id]);
            return $stmt->fetch(PDO::FETCH_ASSOC);
        } catch (PDOException $e) {
            error_log("Error fetching booking: " . $e->getMessage());
            return null;
        }
    }

    public function cancel($id, $user_id) {
        try {
            // Only allow cancellation if check-in date hasn't passed
            $sql = "DELETE FROM bookings 
                   WHERE id = ? AND user_id = ? 
                   AND check_in > CURDATE()";

            $stmt = $this->pdo->prepare($sql);
            $stmt->execute([$id, $user_id]);

            if ($stmt->rowCount() === 0) {
                return ['error' => 'Booking not found or cannot be cancelled'];
            }

            return ['success' => true];
        } catch (PDOException $e) {
            error_log("Error cancelling booking: " . $e->getMessage());
            return ['error' => 'Cancellation failed. Please try again.'];
        }
    }

    public function calculateTotalPrice($property_id, $check_in, $check_out) {
        try {
            // Get property price
            $stmt = $this->pdo->prepare("SELECT price FROM properties WHERE id = ?");
            $stmt->execute([$property_id]);
            $property = $stmt->fetch(PDO::FETCH_ASSOC);

            if (!$property) {
                return ['error' => 'Property not found'];
            }

            // Calculate number of nights
            $start = new DateTime($check_in);
            $end = new DateTime($check_out);
            $nights = $end->diff($start)->days;

            // Calculate total price
            $total_price = $property['price'] * $nights;

            return ['success' => true, 'total_price' => $total_price];
        } catch (PDOException $e) {
            error_log("Error calculating total price: " . $e->getMessage());
            return ['error' => 'Price calculation failed'];
        }
    }
}
