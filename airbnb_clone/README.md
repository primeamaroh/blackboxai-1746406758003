# LendConnect - P2P Lending Platform

A modern peer-to-peer lending platform built with PHP, MySQL, and Tailwind CSS. This platform enables users to request and fund loans, with support for both collateral and non-collateral based lending.

## Features

- 💰 Loan request creation and management
- 🏠 Property-backed collateral loans
- 📊 Credit score integration
- 💸 Partial funding support
- 📱 Responsive design
- 🎨 Modern UI with Tailwind CSS
- 🔒 Secure transaction handling
- 📈 Interest rate calculation
- 🏦 Defaulted property marketplace

## Prerequisites

- PHP 7.4 or higher
- MySQL 5.7 or higher
- Apache web server with mod_rewrite enabled
- Composer (optional, for future package management)

## Installation

1. Clone the repository:
```bash
git clone https://github.com/yourusername/airbnb-clone.git
cd airbnb-clone
```

2. Set up the database:
```bash
mysql -u root -p < database.sql
```

3. Configure the database connection:
- Open `config/database.php`
- Update the database credentials:
```php
define('DB_HOST', 'localhost');
define('DB_NAME', 'airbnb_clone');
define('DB_USER', 'your_username');
define('DB_PASS', 'your_password');
```

4. Configure Apache:
- Ensure mod_rewrite is enabled
- Point your virtual host to the `public` directory
- Make sure .htaccess is allowed (AllowOverride All)

## Project Structure

```
lendconnect/
├── app/
│   ├── controllers/    # Application controllers
│   │   ├── LoanController.php
│   │   ├── UserController.php
│   │   └── PropertyController.php
│   ├── models/        # Database models
│   │   ├── Loan.php
│   │   ├── User.php
│   │   └── Property.php
│   └── routes.php     # Route definitions
├── config/
│   └── database.php   # Database configuration
├── public/
│   ├── index.php      # Entry point
│   └── .htaccess     # URL rewriting rules
└── views/
    ├── auth/          # Authentication views
    ├── loans/         # Loan-related views
    │   ├── list.php
    │   ├── detail.php
    │   ├── create.php
    │   └── for-sale.php
    ├── properties/    # Property-related views
    ├── error/         # Error pages
    └── layouts/       # Common layout files
```

## Usage

1. Start your Apache server and MySQL database

2. Access the platform through your web browser:
```
http://localhost/lendconnect/
```

3. Register a new account or use the demo accounts:
- Borrower Account:
  - Email: john@example.com
  - Password: password
  - Credit Score: 720
- Lender Account:
  - Email: jane@example.com
  - Password: password
  - Credit Score: 680

## Features in Detail

### User Authentication & Profile
- User registration with credit score integration
- Secure password hashing and session management
- Separate borrower and lender dashboards
- Credit score tracking and history

### Loan Management
- Create and manage loan requests
- Set flexible interest rates and terms
- Track funding progress in real-time
- Automated payment calculations
- Late payment handling
- Manage loan status and payments

### Property Collateral System
- Add and manage property collateral
- Property valuation tracking
- Defaulted property marketplace
- Automated collateral claim processing
- Property inspection reports
- Title verification system

### Security & Compliance Features
- Secure transaction processing
- Credit score verification
- KYC documentation support
- Anti-fraud measures
- PDO prepared statements for SQL injection prevention
- XSS protection and CSRF tokens
- Secure session management

## Platform Workflow

### For Borrowers
1. Registration & Verification
   - Create an account
   - Complete profile with credit score
   - Add properties for collateral (optional)

2. Loan Request
   - Specify loan amount and terms
   - Choose collateral/no-collateral
   - Set interest rate
   - Submit for funding

3. Loan Management
   - Track funding progress
   - Receive notifications
   - Make payments
   - Monitor loan status

### For Lenders
1. Account Setup
   - Register as a lender
   - Verify identity
   - Set investment preferences

2. Investment Process
   - Browse loan requests
   - Review borrower profiles
   - Assess risk factors
   - Fund loans (partial or full)

3. Portfolio Management
   - Track investments
   - Monitor repayments
   - Handle defaulted loans
   - Access collateral marketplace

## Technical Documentation

### API Endpoints

#### Loan Management
```
GET    /loans                 # List all loans
GET    /loans?type=collateral # List collateral loans
GET    /loans?type=no_collateral # List no-collateral loans
POST   /loan/create          # Create new loan request
GET    /loan/{id}            # Get loan details
POST   /loan/fund/{id}       # Fund a loan
GET    /my-loans             # Get user's loans
GET    /for-sale             # Get defaulted properties
```

#### User Management
```
POST   /register             # Create new account
POST   /login               # Authenticate user
GET    /profile             # Get user profile
PUT    /profile             # Update user profile
GET    /credit-score        # Get user's credit score
```

#### Property Management
```
GET    /properties          # List user's properties
POST   /property/create     # Add new property
GET    /property/{id}       # Get property details
PUT    /property/{id}       # Update property
DELETE /property/{id}       # Remove property
```

### Database Schema
```sql
users
  - id (PK)
  - name
  - email
  - password
  - credit_score
  - created_at
  - updated_at

loans
  - id (PK)
  - borrower_id (FK)
  - loan_amount
  - funded_amount
  - interest_rate
  - term_months
  - has_collateral
  - property_id (FK)
  - status
  - due_date
  - created_at
  - updated_at

properties
  - id (PK)
  - user_id (FK)
  - title
  - description
  - location
  - estimated_value
  - image_url
  - created_at
```

## Contributing

1. Fork the repository
2. Create your feature branch (`git checkout -b feature/AmazingFeature`)
3. Commit your changes (`git commit -m 'Add some AmazingFeature'`)
4. Push to the branch (`git push origin feature/AmazingFeature`)
5. Open a Pull Request

## License

This project is licensed under the MIT License - see the LICENSE file for details.

## Acknowledgments

- Design inspired by Airbnb
- Icons from Font Awesome
- Images from Pexels
- Styling with Tailwind CSS

## Future Enhancements

- [ ] Add payment gateway integration
- [ ] Implement automated credit scoring
- [ ] Add email notifications for loan status
- [ ] Enhance risk assessment algorithms
- [ ] Add user reputation system
- [ ] Implement KYC verification
- [ ] Add loan portfolio analytics
- [ ] Implement lender dashboard
