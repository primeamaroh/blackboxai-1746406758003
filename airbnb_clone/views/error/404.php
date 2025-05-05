<!-- 404 Error Page -->
<div class="min-h-[calc(100vh-200px)] flex items-center justify-center bg-gray-50 py-12 px-4 sm:px-6 lg:px-8">
    <div class="max-w-md w-full text-center">
        <!-- Error Icon -->
        <div class="mb-8">
            <i class="fas fa-compass text-red-500 text-7xl"></i>
        </div>

        <!-- Error Message -->
        <h1 class="text-4xl font-bold text-gray-900 mb-4">
            Page Not Found
        </h1>
        <p class="text-lg text-gray-600 mb-8">
            Oops! It seems you've wandered off the beaten path.
        </p>

        <!-- Helpful Links -->
        <div class="space-y-4">
            <a href="?page=home" 
               class="inline-flex items-center px-6 py-3 border border-transparent text-base font-medium rounded-md text-white bg-red-600 hover:bg-red-700 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-red-500">
                <i class="fas fa-home mr-2"></i>
                Return Home
            </a>

            <div class="mt-6 grid grid-cols-2 gap-4">
                <a href="?page=properties" 
                   class="inline-flex items-center justify-center px-4 py-2 border border-gray-300 rounded-md shadow-sm text-sm font-medium text-gray-700 bg-white hover:bg-gray-50">
                    <i class="fas fa-search mr-2"></i>
                    Browse Properties
                </a>
                <a href="?page=contact" 
                   class="inline-flex items-center justify-center px-4 py-2 border border-gray-300 rounded-md shadow-sm text-sm font-medium text-gray-700 bg-white hover:bg-gray-50">
                    <i class="fas fa-envelope mr-2"></i>
                    Contact Support
                </a>
            </div>
        </div>

        <!-- Additional Help -->
        <div class="mt-8 text-sm text-gray-500">
            <p>Need help? Try these popular pages:</p>
            <ul class="mt-2 space-y-1">
                <li>
                    <a href="?page=properties" class="text-red-600 hover:text-red-700">
                        Featured Properties
                    </a>
                </li>
                <li>
                    <a href="?page=login" class="text-red-600 hover:text-red-700">
                        Sign In / Register
                    </a>
                </li>
                <li>
                    <a href="?page=help" class="text-red-600 hover:text-red-700">
                        Help Center
                    </a>
                </li>
            </ul>
        </div>
    </div>
</div>
