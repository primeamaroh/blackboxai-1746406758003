<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Airbnb Clone</title>
    <!-- Tailwind CSS -->
    <script src="https://cdn.tailwindcss.com"></script>
    <!-- Google Fonts -->
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@400;500;600;700&display=swap" rel="stylesheet">
    <!-- Font Awesome -->
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0-beta3/css/all.min.css">
    <style>
        body {
            font-family: 'Inter', sans-serif;
        }
    </style>
</head>
<body class="bg-gray-50">
    <!-- Navigation -->
    <nav class="bg-white shadow-lg">
        <div class="max-w-7xl mx-auto px-4">
            <div class="flex justify-between h-16">
                <!-- Logo -->
                <div class="flex-shrink-0 flex items-center">
                    <a href="?page=home" class="text-red-500 text-xl font-bold">
                        <i class="fab fa-airbnb"></i> AirbnbClone
                    </a>
                </div>

                <!-- Navigation Links -->
                <div class="hidden md:flex items-center space-x-4">
                    <a href="?page=home" class="text-gray-700 hover:text-red-500 px-3 py-2 rounded-md text-sm font-medium">Home</a>
                    <a href="?page=properties" class="text-gray-700 hover:text-red-500 px-3 py-2 rounded-md text-sm font-medium">Properties</a>
                    <?php if (isset($_SESSION['user_id'])): ?>
                        <a href="?page=bookings" class="text-gray-700 hover:text-red-500 px-3 py-2 rounded-md text-sm font-medium">My Bookings</a>
                        <a href="?page=logout" class="bg-red-500 text-white px-4 py-2 rounded-md text-sm font-medium hover:bg-red-600">Logout</a>
                    <?php else: ?>
                        <a href="?page=login" class="text-gray-700 hover:text-red-500 px-3 py-2 rounded-md text-sm font-medium">Login</a>
                        <a href="?page=register" class="bg-red-500 text-white px-4 py-2 rounded-md text-sm font-medium hover:bg-red-600">Register</a>
                    <?php endif; ?>
                </div>

                <!-- Mobile menu button -->
                <div class="md:hidden flex items-center">
                    <button type="button" class="mobile-menu-button inline-flex items-center justify-center p-2 rounded-md text-gray-400 hover:text-gray-500 hover:bg-gray-100 focus:outline-none focus:ring-2 focus:ring-inset focus:ring-red-500" aria-controls="mobile-menu" aria-expanded="false">
                        <span class="sr-only">Open main menu</span>
                        <i class="fas fa-bars"></i>
                    </button>
                </div>
            </div>
        </div>

        <!-- Mobile menu -->
        <div class="md:hidden hidden" id="mobile-menu">
            <div class="px-2 pt-2 pb-3 space-y-1">
                <a href="?page=home" class="text-gray-700 hover:text-red-500 block px-3 py-2 rounded-md text-base font-medium">Home</a>
                <a href="?page=properties" class="text-gray-700 hover:text-red-500 block px-3 py-2 rounded-md text-base font-medium">Properties</a>
                <?php if (isset($_SESSION['user_id'])): ?>
                    <a href="?page=bookings" class="text-gray-700 hover:text-red-500 block px-3 py-2 rounded-md text-base font-medium">My Bookings</a>
                    <a href="?page=logout" class="bg-red-500 text-white block px-3 py-2 rounded-md text-base font-medium hover:bg-red-600">Logout</a>
                <?php else: ?>
                    <a href="?page=login" class="text-gray-700 hover:text-red-500 block px-3 py-2 rounded-md text-base font-medium">Login</a>
                    <a href="?page=register" class="bg-red-500 text-white block px-3 py-2 rounded-md text-base font-medium hover:bg-red-600">Register</a>
                <?php endif; ?>
            </div>
        </div>
    </nav>

    <!-- Main Content Container -->
    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 py-8">
