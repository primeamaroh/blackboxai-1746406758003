-- Create database
CREATE DATABASE IF NOT EXISTS airbnb_clone;
USE airbnb_clone;

-- Users table (added credit_score field)
CREATE TABLE IF NOT EXISTS users (
    id INT AUTO_INCREMENT PRIMARY KEY,
    name VARCHAR(255) NOT NULL,
    email VARCHAR(255) NOT NULL UNIQUE,
    password VARCHAR(255) NOT NULL,
    credit_score INT DEFAULT 650,
    created_at DATETIME DEFAULT CURRENT_TIMESTAMP,
    updated_at DATETIME DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

-- Properties table (can be used as collateral)
CREATE TABLE IF NOT EXISTS properties (
    id INT AUTO_INCREMENT PRIMARY KEY,
    user_id INT NOT NULL,
    title VARCHAR(255) NOT NULL,
    description TEXT NOT NULL,
    location VARCHAR(255) NOT NULL,
    estimated_value DECIMAL(10,2) NOT NULL,
    image_url VARCHAR(255) NOT NULL,
    created_at DATETIME DEFAULT CURRENT_TIMESTAMP,
    FOREIGN KEY (user_id) REFERENCES users(id) ON DELETE CASCADE
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

-- Property images table (for additional images)
CREATE TABLE IF NOT EXISTS property_images (
    id INT AUTO_INCREMENT PRIMARY KEY,
    property_id INT NOT NULL,
    image_url VARCHAR(255) NOT NULL,
    created_at DATETIME DEFAULT CURRENT_TIMESTAMP,
    FOREIGN KEY (property_id) REFERENCES properties(id) ON DELETE CASCADE
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

-- Loans table
CREATE TABLE IF NOT EXISTS loans (
    id INT AUTO_INCREMENT PRIMARY KEY,
    borrower_id INT NOT NULL,
    loan_amount DECIMAL(10,2) NOT NULL,
    funded_amount DECIMAL(10,2) DEFAULT 0,
    interest_rate DECIMAL(5,2) NOT NULL,
    term_months INT NOT NULL,
    has_collateral BOOLEAN DEFAULT FALSE,
    property_id INT,
    status ENUM('open', 'funded', 'active', 'overdue', 'for_sale', 'completed', 'defaulted') DEFAULT 'open',
    due_date DATE NOT NULL,
    created_at DATETIME DEFAULT CURRENT_TIMESTAMP,
    updated_at DATETIME DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
    FOREIGN KEY (borrower_id) REFERENCES users(id) ON DELETE CASCADE,
    FOREIGN KEY (property_id) REFERENCES properties(id) ON DELETE SET NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

-- Loan Fundings table (for partial fundings)
CREATE TABLE IF NOT EXISTS loan_fundings (
    id INT AUTO_INCREMENT PRIMARY KEY,
    loan_id INT NOT NULL,
    lender_id INT NOT NULL,
    amount DECIMAL(10,2) NOT NULL,
    created_at DATETIME DEFAULT CURRENT_TIMESTAMP,
    FOREIGN KEY (loan_id) REFERENCES loans(id) ON DELETE CASCADE,
    FOREIGN KEY (lender_id) REFERENCES users(id) ON DELETE CASCADE
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

-- Loan Payments table
CREATE TABLE IF NOT EXISTS loan_payments (
    id INT AUTO_INCREMENT PRIMARY KEY,
    loan_id INT NOT NULL,
    amount DECIMAL(10,2) NOT NULL,
    payment_date DATE NOT NULL,
    status ENUM('pending', 'completed', 'failed') DEFAULT 'pending',
    created_at DATETIME DEFAULT CURRENT_TIMESTAMP,
    FOREIGN KEY (loan_id) REFERENCES loans(id) ON DELETE CASCADE
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

-- Sample data for testing
INSERT INTO users (name, email, password, credit_score) VALUES
('John Doe', 'john@example.com', '$2y$10$92IXUNpkjO0rOQ5byMi.Ye4oKoEa3Ro9llC/.og/at2.uheWG/igi', 720), -- password: password
('Jane Smith', 'jane@example.com', '$2y$10$92IXUNpkjO0rOQ5byMi.Ye4oKoEa3Ro9llC/.og/at2.uheWG/igi', 680),
('Mike Johnson', 'mike@example.com', '$2y$10$92IXUNpkjO0rOQ5byMi.Ye4oKoEa3Ro9llC/.og/at2.uheWG/igi', 750);

INSERT INTO properties (user_id, title, description, location, estimated_value, image_url) VALUES
(1, 'Luxury Beach Villa', 'Beautiful beachfront villa with stunning ocean views', 'Malibu, California', 1200000.00, 'https://images.pexels.com/photos/1396122/pexels-photo-1396122.jpeg'),
(2, 'Modern City Apartment', 'Stylish apartment in the heart of downtown', 'New York City', 800000.00, 'https://images.pexels.com/photos/1571460/pexels-photo-1571460.jpeg'),
(3, 'Mountain Cabin Retreat', 'Cozy cabin with breathtaking mountain views', 'Aspen, Colorado', 600000.00, 'https://images.pexels.com/photos/803975/pexels-photo-803975.jpeg');

-- Sample loans
INSERT INTO loans (borrower_id, loan_amount, interest_rate, term_months, has_collateral, property_id, status, due_date) VALUES
(2, 50000.00, 5.5, 12, true, 2, 'open', DATE_ADD(CURRENT_DATE, INTERVAL 12 MONTH)),
(3, 25000.00, 8.0, 6, false, NULL, 'open', DATE_ADD(CURRENT_DATE, INTERVAL 6 MONTH));

-- Create indexes for better performance
CREATE INDEX idx_properties_user_id ON properties(user_id);
CREATE INDEX idx_loans_borrower_id ON loans(borrower_id);
CREATE INDEX idx_loans_property_id ON loans(property_id);
CREATE INDEX idx_loan_fundings_loan_id ON loan_fundings(loan_id);
CREATE INDEX idx_loan_fundings_lender_id ON loan_fundings(lender_id);
CREATE INDEX idx_loan_payments_loan_id ON loan_payments(loan_id);
