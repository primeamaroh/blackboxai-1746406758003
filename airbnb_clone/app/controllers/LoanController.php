<?php

require_once __DIR__ . '/../models/Loan.php';
require_once __DIR__ . '/../models/Property.php';
require_once __DIR__ . '/../models/User.php';

class LoanController {
    private $loanModel;
    private $propertyModel;
    private $userModel;

    public function __construct($pdo) {
        $this->loanModel = new Loan($pdo);
        $this->propertyModel = new Property($pdo);
        $this->userModel = new User($pdo);
    }

    public function listLoans() {
        // Check if user is logged in
        if (!isset($_SESSION['user_id'])) {
            header('Location: ?page=login');
            exit();
        }

        // Get filter type from URL
        $filter = isset($_GET['type']) ? $_GET['type'] : null;
        
        // Get loans based on filter
        $loans = $this->loanModel->getAllLoans($filter);

        // Load the view with loans
        view('loans/list', [
            'loans' => $loans,
            'filter' => $filter
        ]);
    }

    public function viewLoan($id) {
        // Check if user is logged in
        if (!isset($_SESSION['user_id'])) {
            header('Location: ?page=login');
            exit();
        }

        // Get loan details
        $loan = $this->loanModel->getById($id);
        if (!$loan) {
            $_SESSION['errors'] = ['Loan not found'];
            header('Location: ?page=loans');
            exit();
        }

        // Get funding details
        $fundings = $this->loanModel->getLoanFundings($id);

        // Load the view with loan details
        view('loans/detail', [
            'loan' => $loan,
            'fundings' => $fundings
        ]);
    }

    public function create() {
        // Check if user is logged in
        if (!isset($_SESSION['user_id'])) {
            header('Location: ?page=login');
            exit();
        }

        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            $errors = [];

            // Validate input
            $loan_amount = floatval($_POST['loan_amount'] ?? 0);
            $interest_rate = floatval($_POST['interest_rate'] ?? 0);
            $has_collateral = isset($_POST['has_collateral']) ? true : false;
            $property_id = $has_collateral ? intval($_POST['property_id'] ?? 0) : null;
            $due_date = trim($_POST['due_date'] ?? '');

            if ($loan_amount <= 0) {
                $errors[] = 'Valid loan amount is required';
            }
            if ($interest_rate <= 0) {
                $errors[] = 'Valid interest rate is required';
            }
            if ($has_collateral && $property_id <= 0) {
                $errors[] = 'Valid property for collateral is required';
            }
            if (empty($due_date) || strtotime($due_date) <= time()) {
                $errors[] = 'Valid future due date is required';
            }

            if (!empty($errors)) {
                $_SESSION['errors'] = $errors;
                $_SESSION['old_input'] = $_POST;
                header('Location: ?page=loan/create');
                exit();
            }

            // Create loan request
            $result = $this->loanModel->create(
                $_SESSION['user_id'],
                $loan_amount,
                $interest_rate,
                $has_collateral,
                $property_id,
                $due_date
            );

            if (isset($result['error'])) {
                $_SESSION['errors'] = [$result['error']];
                $_SESSION['old_input'] = $_POST;
                header('Location: ?page=loan/create');
                exit();
            }

            $_SESSION['success'] = 'Loan request created successfully!';
            header('Location: ?page=loan&id=' . $result['loan_id']);
            exit();
        }

        // Get user's properties for collateral selection
        $properties = $this->propertyModel->getUserProperties($_SESSION['user_id']);

        // Show create form
        view('loans/create', ['properties' => $properties]);
    }

    public function fund($id) {
        // Check if user is logged in
        if (!isset($_SESSION['user_id'])) {
            header('Location: ?page=login');
            exit();
        }

        if ($_SERVER['REQUEST_METHOD'] !== 'POST') {
            header('Location: ?page=loan&id=' . $id);
            exit();
        }

        $errors = [];
        $amount = floatval($_POST['amount'] ?? 0);

        if ($amount <= 0) {
            $errors[] = 'Valid funding amount is required';
        }

        if (!empty($errors)) {
            $_SESSION['errors'] = $errors;
            header('Location: ?page=loan&id=' . $id);
            exit();
        }

        // Process funding
        $result = $this->loanModel->fund($id, $_SESSION['user_id'], $amount);

        if (isset($result['error'])) {
            $_SESSION['errors'] = [$result['error']];
        } else {
            $_SESSION['success'] = 'Funding processed successfully!';
        }

        header('Location: ?page=loan&id=' . $id);
        exit();
    }

    public function myLoans() {
        // Check if user is logged in
        if (!isset($_SESSION['user_id'])) {
            header('Location: ?page=login');
            exit();
        }

        // Get user's loans (both as borrower and lender)
        $borrowing = $this->loanModel->getAllLoans(['borrower_id' => $_SESSION['user_id']]);
        $lending = $this->loanModel->getAllLoans(['lender_id' => $_SESSION['user_id']]);

        // Load the view
        view('loans/my-loans', [
            'borrowing' => $borrowing,
            'lending' => $lending
        ]);
    }

    public function forSale() {
        // Get all loans with status 'for_sale'
        $forSaleLoans = $this->loanModel->getAllLoans('for_sale');

        // Load the view
        view('loans/for-sale', [
            'loans' => $forSaleLoans
        ]);
    }

    public function updateStatus($id) {
        // Check if user is logged in and is admin (you might want to add admin check)
        if (!isset($_SESSION['user_id'])) {
            header('Location: ?page=login');
            exit();
        }

        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            $status = trim($_POST['status'] ?? '');
            
            $result = $this->loanModel->updateStatus($id, $status);

            if (isset($result['error'])) {
                $_SESSION['errors'] = [$result['error']];
            } else {
                $_SESSION['success'] = 'Loan status updated successfully!';
            }
        }

        header('Location: ?page=loan&id=' . $id);
        exit();
    }
}
