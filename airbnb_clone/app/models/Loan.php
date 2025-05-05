<?php

class Loan {
    private $pdo;

    public function __construct($pdo) {
        $this->pdo = $pdo;
    }

    public function create($borrower_id, $loan_amount, $interest_rate, $has_collateral, $due_date, $property_id = null) {
        try {
            // Validate loan amount and interest rate
            if (!is_numeric($loan_amount) || $loan_amount <= 0) {
                return ['error' => 'Invalid loan amount'];
            }
            if (!is_numeric($interest_rate) || $interest_rate < 0) {
                return ['error' => 'Invalid interest rate'];
            }

            // If has collateral, verify property belongs to borrower
            if ($has_collateral && $property_id) {
                $stmt = $this->pdo->prepare("SELECT id FROM properties WHERE id = ? AND user_id = ?");
                $stmt->execute([$property_id, $borrower_id]);
                if (!$stmt->fetch()) {
                    return ['error' => 'Invalid property for collateral'];
                }
            }

            $stmt = $this->pdo->prepare("
                INSERT INTO loans (
                    borrower_id, 
                    loan_amount, 
                    interest_rate, 
                    has_collateral, 
                    property_id, 
                    due_date, 
                    status, 
                    created_at, 
                    updated_at
                ) VALUES (
                    ?, ?, ?, ?, ?, ?, 'open', datetime('now'), datetime('now')
                )
            ");
            
            $stmt->execute([
                $borrower_id,
                $loan_amount,
                $interest_rate,
                $has_collateral ? 1 : 0,
                $property_id,
                $due_date
            ]);
            
            return ['success' => true, 'loan_id' => $this->pdo->lastInsertId()];
        } catch (PDOException $e) {
            error_log("Error creating loan: " . $e->getMessage());
            return ['error' => 'Failed to create loan request. Please try again.'];
        }
    }

    public function fund($loan_id, $lender_id, $amount) {
        try {
            $this->pdo->beginTransaction();

            // Get loan details
            $stmt = $this->pdo->prepare("
                SELECT loan_amount, funded_amount, status 
                FROM loans 
                WHERE id = ?
            ");
            $stmt->execute([$loan_id]);
            $loan = $stmt->fetch(PDO::FETCH_ASSOC);

            if (!$loan) {
                $this->pdo->rollBack();
                return ['error' => 'Loan not found'];
            }

            if ($loan['status'] !== 'open') {
                $this->pdo->rollBack();
                return ['error' => 'Loan is not open for funding'];
            }

            $new_funded_amount = $loan['funded_amount'] + $amount;
            if ($new_funded_amount > $loan['loan_amount']) {
                $this->pdo->rollBack();
                return ['error' => 'Funding amount exceeds remaining loan amount'];
            }

            // Record the funding
            $stmt = $this->pdo->prepare("
                INSERT INTO loan_fundings (loan_id, lender_id, amount, created_at)
                VALUES (?, ?, ?, datetime('now'))
            ");
            $stmt->execute([$loan_id, $lender_id, $amount]);

            // Update loan funded amount
            $stmt = $this->pdo->prepare("
                UPDATE loans 
                SET funded_amount = funded_amount + ?,
                    status = CASE 
                        WHEN funded_amount + ? >= loan_amount THEN 'funded'
                        ELSE status 
                    END,
                    updated_at = datetime('now')
                WHERE id = ?
            ");
            $stmt->execute([$amount, $amount, $loan_id]);

            $this->pdo->commit();
            return ['success' => true];
        } catch (PDOException $e) {
            $this->pdo->rollBack();
            error_log("Error funding loan: " . $e->getMessage());
            return ['error' => 'Failed to process funding. Please try again.'];
        }
    }

    public function getById($id) {
        try {
            $stmt = $this->pdo->prepare("
                SELECT l.*, u.name as borrower_name, u.credit_score,
                       p.title as property_title, p.image_url as property_image
                FROM loans l
                JOIN users u ON l.borrower_id = u.id
                LEFT JOIN properties p ON l.property_id = p.id
                WHERE l.id = ?
            ");
            $stmt->execute([$id]);
            return $stmt->fetch(PDO::FETCH_ASSOC);
        } catch (PDOException $e) {
            error_log("Error fetching loan: " . $e->getMessage());
            return null;
        }
    }

    public function getAllLoans($filter = null) {
        try {
            $sql = "
                SELECT l.*, u.name as borrower_name, u.credit_score,
                       p.title as property_title, p.image_url as property_image
                FROM loans l
                JOIN users u ON l.borrower_id = u.id
                LEFT JOIN properties p ON l.property_id = p.id
                WHERE 1=1
            ";
            $params = [];

            if ($filter === 'collateral') {
                $sql .= " AND l.has_collateral = 1";
            } elseif ($filter === 'no_collateral') {
                $sql .= " AND l.has_collateral = 0";
            } elseif ($filter === 'for_sale') {
                $sql .= " AND l.status = 'for_sale'";
            }

            $sql .= " ORDER BY l.created_at DESC";
            
            $stmt = $this->pdo->prepare($sql);
            $stmt->execute($params);
            return $stmt->fetchAll(PDO::FETCH_ASSOC);
        } catch (PDOException $e) {
            error_log("Error fetching loans: " . $e->getMessage());
            return [];
        }
    }

    public function updateStatus($id, $status) {
        try {
            $valid_statuses = ['open', 'funded', 'active', 'overdue', 'for_sale', 'completed', 'defaulted'];
            if (!in_array($status, $valid_statuses)) {
                return ['error' => 'Invalid status'];
            }

            $stmt = $this->pdo->prepare("
                UPDATE loans 
                SET status = ?, 
                    updated_at = datetime('now')
                WHERE id = ?
            ");
            $stmt->execute([$status, $id]);
            return ['success' => true];
        } catch (PDOException $e) {
            error_log("Error updating loan status: " . $e->getMessage());
            return ['error' => 'Failed to update loan status'];
        }
    }

    public function getLoanFundings($loan_id) {
        try {
            $stmt = $this->pdo->prepare("
                SELECT lf.*, u.name as lender_name
                FROM loan_fundings lf
                JOIN users u ON lf.lender_id = u.id
                WHERE lf.loan_id = ?
                ORDER BY lf.created_at DESC
            ");
            $stmt->execute([$loan_id]);
            return $stmt->fetchAll(PDO::FETCH_ASSOC);
        } catch (PDOException $e) {
            error_log("Error fetching loan fundings: " . $e->getMessage());
            return [];
        }
    }
}
