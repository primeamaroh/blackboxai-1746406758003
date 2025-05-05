<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>P2P Lending Platform</title>
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
                    <a href="?page=home" class="text-blue-600 text-xl font-bold">
                        <i class="fas fa-handshake"></i> LendConnect
                    </a>
                </div>

                <!-- Navigation Links -->
                <div class="hidden md:flex items-center space-x-4">
                    <a href="?page=home" class="text-gray-700 hover:text-blue-600 px-3 py-2 rounded-md text-sm font-medium">Home</a>
                    
                    <!-- Loan Links -->
                    <div class="relative" x-data="{ open: false }" @mouseenter="open = true" @mouseleave="open = false">
                        <button class="text-gray-700 hover:text-blue-600 px-3 py-2 rounded-md text-sm font-medium inline-flex items-center">
                            <span>Loans</span>
                            <i class="fas fa-chevron-down ml-1 text-xs"></i>
                        </button>
                        <div x-show="open" class="absolute z-10 -ml-4 mt-2 w-48 rounded-md shadow-lg bg-white ring-1 ring-black ring-opacity-5">
                            <div class="py-1">
                                <a href="?page=loans" class="block px-4 py-2 text-sm text-gray-700 hover:bg-gray-100">Browse Loans</a>
                                <a href="?page=loans&type=no_collateral" class="block px-4 py-2 text-sm text-gray-700 hover:bg-gray-100">No Collateral Loans</a>
                                <a href="?page=loans&type=collateral" class="block px-4 py-2 text-sm text-gray-700 hover:bg-gray-100">Collateral Loans</a>
                                <a href="?page=for-sale" class="block px-4 py-2 text-sm text-gray-700 hover:bg-gray-100">Properties For Sale</a>
                            </div>
                        </div>
                    </div>

                    <?php if (isset($_SESSION['user_id'])): ?>
                        <a href="?page=loan/create" class="text-gray-700 hover:text-blue-600 px-3 py-2 rounded-md text-sm font-medium">Request Loan</a>
                        <a href="?page=my-loans" class="text-gray-700 hover:text-blue-600 px-3 py-2 rounded-md text-sm font-medium">My Loans</a>
                        <a href="?page=properties" class="text-gray-700 hover:text-blue-600 px-3 py-2 rounded-md text-sm font-medium">My Properties</a>
                        <a href="?page=logout" class="bg-blue-600 text-white px-4 py-2 rounded-md text-sm font-medium hover:bg-blue-700">Logout</a>
                    <?php else: ?>
                        <a href="?page=login" class="text-gray-700 hover:text-blue-600 px-3 py-2 rounded-md text-sm font-medium">Login</a>
                        <a href="?page=register" class="bg-blue-600 text-white px-4 py-2 rounded-md text-sm font-medium hover:bg-blue-700">Register</a>
                    <?php endif; ?>
                </div>

                <!-- Mobile menu button -->
                <div class="md:hidden flex items-center">
                    <button type="button" class="mobile-menu-button inline-flex items-center justify-center p-2 rounded-md text-gray-400 hover:text-gray-500 hover:bg-gray-100 focus:outline-none focus:ring-2 focus:ring-inset focus:ring-blue-500" aria-controls="mobile-menu" aria-expanded="false">
                        <span class="sr-only">Open main menu</span>
                        <i class="fas fa-bars"></i>
                    </button>
                </div>
            </div>
        </div>

        <!-- Mobile menu -->
        <div class="md:hidden hidden" id="mobile-menu">
            <div class="px-2 pt-2 pb-3 space-y-1">
                <a href="?page=home" class="text-gray-700 hover:text-blue-600 block px-3 py-2 rounded-md text-base font-medium">Home</a>
                <a href="?page=loans" class="text-gray-700 hover:text-blue-600 block px-3 py-2 rounded-md text-base font-medium">Browse Loans</a>
                <a href="?page=loans&type=no_collateral" class="text-gray-700 hover:text-blue-600 block px-3 py-2 rounded-md text-base font-medium pl-6">No Collateral Loans</a>
                <a href="?page=loans&type=collateral" class="text-gray-700 hover:text-blue-600 block px-3 py-2 rounded-md text-base font-medium pl-6">Collateral Loans</a>
                <a href="?page=for-sale" class="text-gray-700 hover:text-blue-600 block px-3 py-2 rounded-md text-base font-medium">Properties For Sale</a>
                
                <?php if (isset($_SESSION['user_id'])): ?>
                    <a href="?page=loan/create" class="text-gray-700 hover:text-blue-600 block px-3 py-2 rounded-md text-base font-medium">Request Loan</a>
                    <a href="?page=my-loans" class="text-gray-700 hover:text-blue-600 block px-3 py-2 rounded-md text-base font-medium">My Loans</a>
                    <a href="?page=properties" class="text-gray-700 hover:text-blue-600 block px-3 py-2 rounded-md text-base font-medium">My Properties</a>
                    <a href="?page=logout" class="bg-blue-600 text-white block px-3 py-2 rounded-md text-base font-medium hover:bg-blue-700">Logout</a>
                <?php else: ?>
                    <a href="?page=login" class="text-gray-700 hover:text-blue-600 block px-3 py-2 rounded-md text-base font-medium">Login</a>
                    <a href="?page=register" class="bg-blue-600 text-white block px-3 py-2 rounded-md text-base font-medium hover:bg-blue-700">Register</a>
                <?php endif; ?>
            </div>
        </div>
    </nav>

    <!-- Flash Messages -->
    <?php if (isset($_SESSION['success'])): ?>
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 mt-4">
            <div class="bg-green-50 border-l-4 border-green-400 p-4">
                <div class="flex">
                    <div class="flex-shrink-0">
                        <i class="fas fa-check-circle text-green-400"></i>
                    </div>
                    <div class="ml-3">
                        <p class="text-sm text-green-700">
                            <?php echo $_SESSION['success']; ?>
                        </p>
                    </div>
                </div>
            </div>
        </div>
        <?php unset($_SESSION['success']); ?>
    <?php endif; ?>

    <?php if (isset($_SESSION['errors']) && !empty($_SESSION['errors'])): ?>
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 mt-4">
            <div class="bg-red-50 border-l-4 border-red-400 p-4">
                <div class="flex">
                    <div class="flex-shrink-0">
                        <i class="fas fa-exclamation-circle text-red-400"></i>
                    </div>
                    <div class="ml-3">
                        <h3 class="text-sm font-medium text-red-800">
                            There were errors with your submission
                        </h3>
                        <div class="mt-2 text-sm text-red-700">
                            <ul class="list-disc pl-5 space-y-1">
                                <?php foreach ($_SESSION['errors'] as $error): ?>
                                    <li><?php echo $error; ?></li>
                                <?php endforeach; ?>
                            </ul>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <?php unset($_SESSION['errors']); ?>
    <?php endif; ?>

    <!-- Main Content Container -->
    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 py-8">
