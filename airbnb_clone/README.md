# Airbnb Clone

A simplified Airbnb clone built with PHP, MySQL, and Tailwind CSS. This project includes user authentication, property listings, booking management, and a responsive design.

## Features

- 🏠 Property listing and search
- 👤 User registration and authentication
- 📅 Booking system
- 💳 Price calculation
- 📱 Responsive design
- 🎨 Modern UI with Tailwind CSS
- 🔒 Secure password hashing
- 🗺️ Location-based search
- 📸 Image gallery for properties

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
airbnb_clone/
├── app/
│   ├── controllers/    # Application controllers
│   ├── models/        # Database models
│   └── routes.php     # Route definitions
├── config/
│   └── database.php   # Database configuration
├── public/
│   ├── index.php      # Entry point
│   └── .htaccess     # URL rewriting rules
└── views/
    ├── auth/          # Authentication views
    ├── properties/    # Property-related views
    ├── bookings/      # Booking-related views
    ├── error/         # Error pages
    └── layouts/       # Common layout files
```

## Usage

1. Start your Apache server and MySQL database

2. Access the application through your web browser:
```
http://localhost/airbnb-clone/
```

3. Register a new account or use the demo accounts:
- Email: john@example.com
- Password: password

## Features in Detail

### User Authentication
- User registration with email
- Secure password hashing
- Session-based authentication
- Password reset functionality (coming soon)

### Property Management
- Property listing creation
- Image upload support
- Detailed property views
- Search and filtering options

### Booking System
- Date-based availability
- Price calculation
- Booking management
- Cancellation support

### User Interface
- Responsive design
- Modern UI components
- Interactive elements
- Mobile-friendly layout

## Security Features

- Password hashing using PHP's password_hash()
- SQL injection prevention using PDO prepared statements
- XSS protection with output escaping
- CSRF protection for forms
- Secure session handling

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

- [ ] Add payment integration
- [ ] Implement real-time messaging
- [ ] Add email notifications
- [ ] Enhance search functionality
- [ ] Add user reviews and ratings
- [ ] Implement social login
- [ ] Add property amenities management
- [ ] Implement host dashboard
