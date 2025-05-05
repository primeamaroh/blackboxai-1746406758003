<?php

// Get the requested page from URL
$page = $_GET['page'] ?? 'home';

// Include helper functions
require_once __DIR__ . '/helpers.php';

// Simple router
switch ($page) {
    case 'home':
        view('home');
        break;

    case 'login':
        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            require_once __DIR__ . '/controllers/UserController.php';
            $controller = new UserController($pdo);
            $controller->login();
        } else {
            view('auth/login');
        }
        break;

    case 'register':
        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            require_once __DIR__ . '/controllers/UserController.php';
            $controller = new UserController($pdo);
            $controller->register();
        } else {
            view('auth/register');
        }
        break;

    case 'logout':
        require_once __DIR__ . '/controllers/UserController.php';
        $controller = new UserController($pdo);
        $controller->logout();
        break;

    // Loan Routes
    case 'loans':
        if (!isset($_SESSION['user_id'])) {
            redirect('login');
        }
        require_once __DIR__ . '/controllers/LoanController.php';
        $controller = new LoanController($pdo);
        $controller->listLoans();
        break;

    case 'loan':
        if (!isset($_SESSION['user_id'])) {
            redirect('login');
        }
        require_once __DIR__ . '/controllers/LoanController.php';
        $controller = new LoanController($pdo);
        $id = $_GET['id'] ?? null;
        if ($id) {
            $controller->viewLoan($id);
        } else {
            redirect('loans');
        }
        break;

    case 'loan/create':
        if (!isset($_SESSION['user_id'])) {
            redirect('login');
        }
        require_once __DIR__ . '/controllers/LoanController.php';
        $controller = new LoanController($pdo);
        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            $controller->create();
        } else {
            $controller->create();
        }
        break;

    case 'loan/fund':
        if (!isset($_SESSION['user_id'])) {
            redirect('login');
        }
        require_once __DIR__ . '/controllers/LoanController.php';
        $controller = new LoanController($pdo);
        $id = $_GET['id'] ?? null;
        if ($id && $_SERVER['REQUEST_METHOD'] === 'POST') {
            $controller->fund($id);
        } else {
            redirect('loans');
        }
        break;

    case 'my-loans':
        if (!isset($_SESSION['user_id'])) {
            redirect('login');
        }
        require_once __DIR__ . '/controllers/LoanController.php';
        $controller = new LoanController($pdo);
        $controller->myLoans();
        break;

    case 'for-sale':
        require_once __DIR__ . '/controllers/LoanController.php';
        $controller = new LoanController($pdo);
        $controller->forSale();
        break;

    case 'properties':
        view('properties/list', ['properties' => [], 'searchParams' => []]);
        break;

    case 'property':
        $id = $_GET['id'] ?? null;
        if ($id) {
            // Sample property data
            $sampleProperties = [
                1 => [
                    'id' => 1,
                    'title' => 'Luxury Beach Villa',
                    'description' => 'Experience luxury living in this stunning beach villa with panoramic ocean views. This spacious property features 4 bedrooms, 3 bathrooms, a fully equipped kitchen, and a private pool. Perfect for family vacations or group getaways.',
                    'location' => 'Malibu, California',
                    'price' => 599.99,
                    'image_url' => 'https://images.pexels.com/photos/1396122/pexels-photo-1396122.jpeg',
                    'host_name' => 'John Doe',
                    'additional_images' => [
                        'https://images.pexels.com/photos/1396132/pexels-photo-1396132.jpeg',
                        'https://images.pexels.com/photos/1396133/pexels-photo-1396133.jpeg',
                        'https://images.pexels.com/photos/1396134/pexels-photo-1396134.jpeg'
                    ]
                ],
                2 => [
                    'id' => 2,
                    'title' => 'Modern City Apartment',
                    'description' => 'Stay in the heart of the city in this stylish modern apartment. Features include high-end appliances, floor-to-ceiling windows with city views, and designer furnishings. Walking distance to major attractions.',
                    'location' => 'New York City',
                    'price' => 299.99,
                    'image_url' => 'https://images.pexels.com/photos/1571460/pexels-photo-1571460.jpeg',
                    'host_name' => 'Jane Smith',
                    'additional_images' => [
                        'https://images.pexels.com/photos/1571461/pexels-photo-1571461.jpeg',
                        'https://images.pexels.com/photos/1571462/pexels-photo-1571462.jpeg',
                        'https://images.pexels.com/photos/1571463/pexels-photo-1571463.jpeg'
                    ]
                ],
                3 => [
                    'id' => 3,
                    'title' => 'Mountain Cabin Retreat',
                    'description' => 'Escape to this cozy mountain cabin surrounded by nature. Perfect for outdoor enthusiasts, featuring a wood-burning fireplace, hot tub, and stunning mountain views. Close to skiing and hiking trails.',
                    'location' => 'Aspen, Colorado',
                    'price' => 399.99,
                    'image_url' => 'https://images.pexels.com/photos/803975/pexels-photo-803975.jpeg',
                    'host_name' => 'Mike Johnson',
                    'additional_images' => [
                        'https://images.pexels.com/photos/803976/pexels-photo-803976.jpeg',
                        'https://images.pexels.com/photos/803977/pexels-photo-803977.jpeg',
                        'https://images.pexels.com/photos/803978/pexels-photo-803978.jpeg'
                    ]
                ]
            ];

            if (isset($sampleProperties[$id])) {
                view('properties/detail', ['property' => $sampleProperties[$id]]);
            } else {
                redirect('properties');
            }
        } else {
            redirect('properties');
        }
        break;

    case 'bookings':
        if (!isset($_SESSION['user_id'])) {
            redirect('login');
        }
        require_once __DIR__ . '/controllers/BookingController.php';
        $controller = new BookingController($pdo);
        $controller->listUserBookings();
        break;

    case 'book':
        if (!isset($_SESSION['user_id'])) {
            redirect('login');
        }
        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            require_once __DIR__ . '/controllers/BookingController.php';
            $controller = new BookingController($pdo);
            $controller->bookProperty();
        } else {
            redirect('properties');
        }
        break;

    default:
        http_response_code(404);
        view('error/404');
        break;
}
