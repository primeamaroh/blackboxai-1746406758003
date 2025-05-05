<!-- Bookings List Page -->
<div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 py-8">
    <!-- Page Header -->
    <div class="mb-8">
        <h1 class="text-3xl font-bold text-gray-900">Your Trips</h1>
        <p class="mt-2 text-gray-600">Manage and view your bookings</p>
    </div>

    <!-- Success Message -->
    <?php if (isset($_SESSION['success'])): ?>
        <div class="mb-8 bg-green-100 border border-green-400 text-green-700 px-4 py-3 rounded relative" role="alert">
            <span class="block sm:inline"><?php echo $_SESSION['success']; ?></span>
            <button class="absolute top-0 bottom-0 right-0 px-4 py-3" onclick="this.parentElement.style.display='none'">
                <i class="fas fa-times"></i>
            </button>
        </div>
        <?php unset($_SESSION['success']); ?>
    <?php endif; ?>

    <!-- Error Messages -->
    <?php if (isset($_SESSION['errors'])): ?>
        <div class="mb-8 bg-red-100 border border-red-400 text-red-700 px-4 py-3 rounded relative" role="alert">
            <?php foreach ($_SESSION['errors'] as $error): ?>
                <p class="text-sm"><?php echo htmlspecialchars($error); ?></p>
            <?php endforeach; ?>
            <button class="absolute top-0 bottom-0 right-0 px-4 py-3" onclick="this.parentElement.style.display='none'">
                <i class="fas fa-times"></i>
            </button>
        </div>
        <?php unset($_SESSION['errors']); ?>
    <?php endif; ?>

    <!-- Tabs -->
    <div class="border-b border-gray-200 mb-8">
        <nav class="-mb-px flex space-x-8">
            <a href="#upcoming" class="border-red-500 text-red-600 whitespace-nowrap py-4 px-1 border-b-2 font-medium text-sm">
                Upcoming
            </a>
            <a href="#past" class="border-transparent text-gray-500 hover:text-gray-700 hover:border-gray-300 whitespace-nowrap py-4 px-1 border-b-2 font-medium text-sm">
                Past
            </a>
        </nav>
    </div>

    <!-- Upcoming Bookings -->
    <div id="upcoming" class="space-y-6">
        <h2 class="text-xl font-semibold text-gray-900">Upcoming Trips</h2>
        
        <?php if (empty($upcoming)): ?>
            <div class="text-center py-12 bg-gray-50 rounded-lg">
                <i class="fas fa-suitcase text-gray-400 text-5xl mb-4"></i>
                <h3 class="text-lg font-medium text-gray-900">No upcoming trips</h3>
                <p class="mt-1 text-sm text-gray-500">Time to start planning your next adventure!</p>
                <a href="?page=properties" class="mt-4 inline-flex items-center px-4 py-2 border border-transparent text-sm font-medium rounded-md text-white bg-red-600 hover:bg-red-700">
                    Explore Properties
                </a>
            </div>
        <?php else: ?>
            <div class="grid grid-cols-1 gap-6">
                <?php foreach ($upcoming as $booking): ?>
                    <div class="bg-white shadow rounded-lg overflow-hidden">
                        <div class="md:flex">
                            <!-- Property Image -->
                            <div class="md:flex-shrink-0">
                                <img class="h-48 w-full object-cover md:w-48" 
                                     src="<?php echo htmlspecialchars($booking['image_url']); ?>" 
                                     alt="<?php echo htmlspecialchars($booking['title']); ?>">
                            </div>
                            
                            <!-- Booking Details -->
                            <div class="p-6 w-full">
                                <div class="flex justify-between items-start">
                                    <div>
                                        <h3 class="text-xl font-semibold text-gray-900">
                                            <?php echo htmlspecialchars($booking['title']); ?>
                                        </h3>
                                        <p class="mt-1 text-sm text-gray-500">
                                            <i class="fas fa-map-marker-alt"></i>
                                            <?php echo htmlspecialchars($booking['location']); ?>
                                        </p>
                                    </div>
                                    <div class="text-right">
                                        <p class="text-sm font-semibold text-gray-900">
                                            Total: $<?php echo number_format($booking['total_price'], 2); ?>
                                        </p>
                                    </div>
                                </div>

                                <div class="mt-4 flex items-center justify-between">
                                    <div class="flex items-center space-x-4">
                                        <div>
                                            <p class="text-sm font-medium text-gray-900">Check-in</p>
                                            <p class="text-sm text-gray-500">
                                                <?php echo date('M j, Y', strtotime($booking['check_in'])); ?>
                                            </p>
                                        </div>
                                        <i class="fas fa-arrow-right text-gray-400"></i>
                                        <div>
                                            <p class="text-sm font-medium text-gray-900">Check-out</p>
                                            <p class="text-sm text-gray-500">
                                                <?php echo date('M j, Y', strtotime($booking['check_out'])); ?>
                                            </p>
                                        </div>
                                    </div>

                                    <div class="flex space-x-3">
                                        <a href="?page=property&id=<?php echo $booking['property_id']; ?>" 
                                           class="inline-flex items-center px-3 py-2 border border-gray-300 shadow-sm text-sm leading-4 font-medium rounded-md text-gray-700 bg-white hover:bg-gray-50 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-red-500">
                                            View Property
                                        </a>
                                        <form action="?page=booking/cancel" method="POST" class="inline">
                                            <input type="hidden" name="booking_id" value="<?php echo $booking['id']; ?>">
                                            <button type="submit" onclick="return confirm('Are you sure you want to cancel this booking?')"
                                                    class="inline-flex items-center px-3 py-2 border border-transparent text-sm leading-4 font-medium rounded-md text-white bg-red-600 hover:bg-red-700 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-red-500">
                                                Cancel
                                            </button>
                                        </form>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                <?php endforeach; ?>
            </div>
        <?php endif; ?>
    </div>

    <!-- Past Bookings -->
    <div id="past" class="hidden space-y-6 mt-8">
        <h2 class="text-xl font-semibold text-gray-900">Past Trips</h2>
        
        <?php if (empty($past)): ?>
            <div class="text-center py-12 bg-gray-50 rounded-lg">
                <i class="fas fa-history text-gray-400 text-5xl mb-4"></i>
                <h3 class="text-lg font-medium text-gray-900">No past trips</h3>
                <p class="mt-1 text-sm text-gray-500">Your completed trips will appear here</p>
            </div>
        <?php else: ?>
            <div class="grid grid-cols-1 gap-6">
                <?php foreach ($past as $booking): ?>
                    <div class="bg-white shadow rounded-lg overflow-hidden opacity-75">
                        <div class="md:flex">
                            <!-- Property Image -->
                            <div class="md:flex-shrink-0">
                                <img class="h-48 w-full object-cover md:w-48" 
                                     src="<?php echo htmlspecialchars($booking['image_url']); ?>" 
                                     alt="<?php echo htmlspecialchars($booking['title']); ?>">
                            </div>
                            
                            <!-- Booking Details -->
                            <div class="p-6 w-full">
                                <div class="flex justify-between items-start">
                                    <div>
                                        <h3 class="text-xl font-semibold text-gray-900">
                                            <?php echo htmlspecialchars($booking['title']); ?>
                                        </h3>
                                        <p class="mt-1 text-sm text-gray-500">
                                            <i class="fas fa-map-marker-alt"></i>
                                            <?php echo htmlspecialchars($booking['location']); ?>
                                        </p>
                                    </div>
                                    <div class="text-right">
                                        <p class="text-sm font-semibold text-gray-900">
                                            Total: $<?php echo number_format($booking['total_price'], 2); ?>
                                        </p>
                                    </div>
                                </div>

                                <div class="mt-4 flex items-center justify-between">
                                    <div class="flex items-center space-x-4">
                                        <div>
                                            <p class="text-sm font-medium text-gray-900">Check-in</p>
                                            <p class="text-sm text-gray-500">
                                                <?php echo date('M j, Y', strtotime($booking['check_in'])); ?>
                                            </p>
                                        </div>
                                        <i class="fas fa-arrow-right text-gray-400"></i>
                                        <div>
                                            <p class="text-sm font-medium text-gray-900">Check-out</p>
                                            <p class="text-sm text-gray-500">
                                                <?php echo date('M j, Y', strtotime($booking['check_out'])); ?>
                                            </p>
                                        </div>
                                    </div>

                                    <div>
                                        <a href="?page=property&id=<?php echo $booking['property_id']; ?>" 
                                           class="inline-flex items-center px-3 py-2 border border-gray-300 shadow-sm text-sm leading-4 font-medium rounded-md text-gray-700 bg-white hover:bg-gray-50 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-red-500">
                                            Book Again
                                        </a>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                <?php endforeach; ?>
            </div>
        <?php endif; ?>
    </div>
</div>

<!-- Tab Switching Script -->
<script>
document.addEventListener('DOMContentLoaded', function() {
    const tabs = document.querySelectorAll('nav a');
    const contents = document.querySelectorAll('#upcoming, #past');

    tabs.forEach(tab => {
        tab.addEventListener('click', (e) => {
            e.preventDefault();
            
            // Update tab styles
            tabs.forEach(t => {
                t.classList.remove('border-red-500', 'text-red-600');
                t.classList.add('border-transparent', 'text-gray-500');
            });
            tab.classList.remove('border-transparent', 'text-gray-500');
            tab.classList.add('border-red-500', 'text-red-600');

            // Show/hide content
            const targetId = tab.getAttribute('href').substring(1);
            contents.forEach(content => {
                content.classList.add('hidden');
                if (content.id === targetId) {
                    content.classList.remove('hidden');
                }
            });
        });
    });
});
</script>
