<!-- Property Details Page -->
<div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 py-8">
    <!-- Property Title Section -->
    <div class="mb-6">
        <h1 class="text-3xl font-bold text-gray-900">
            <?php echo htmlspecialchars($property['title']); ?>
        </h1>
        <div class="mt-2 flex items-center justify-between">
            <div class="flex items-center space-x-4">
                <div class="flex items-center">
                    <i class="fas fa-star text-yellow-400"></i>
                    <span class="ml-1 text-sm text-gray-600">4.9 (128 reviews)</span>
                </div>
                <div class="flex items-center">
                    <i class="fas fa-map-marker-alt text-gray-400"></i>
                    <span class="ml-1 text-sm text-gray-600">
                        <?php echo htmlspecialchars($property['location']); ?>
                    </span>
                </div>
            </div>
            <div class="flex items-center space-x-4">
                <button class="flex items-center text-gray-600 hover:text-gray-900">
                    <i class="far fa-heart mr-2"></i>
                    Save
                </button>
                <button class="flex items-center text-gray-600 hover:text-gray-900">
                    <i class="fas fa-share mr-2"></i>
                    Share
                </button>
            </div>
        </div>
    </div>

    <!-- Image Gallery -->
    <div class="grid grid-cols-4 gap-4 mb-8">
        <div class="col-span-2 row-span-2">
            <img src="<?php echo htmlspecialchars($property['image_url']); ?>" 
                 alt="<?php echo htmlspecialchars($property['title']); ?>"
                 class="w-full h-full object-cover rounded-lg">
        </div>
        <?php foreach (($property['additional_images'] ?? []) as $index => $image): ?>
            <?php if ($index < 4): ?>
                <div>
                    <img src="<?php echo htmlspecialchars($image); ?>" 
                         alt="Additional property image"
                         class="w-full h-48 object-cover rounded-lg">
                </div>
            <?php endif; ?>
        <?php endforeach; ?>
    </div>

    <!-- Main Content Grid -->
    <div class="grid grid-cols-1 lg:grid-cols-3 gap-8">
        <!-- Left Column - Property Info -->
        <div class="lg:col-span-2">
            <!-- Host Info -->
            <div class="flex items-center justify-between pb-6 border-b">
                <div>
                    <h2 class="text-2xl font-semibold text-gray-900">
                        Hosted by <?php echo htmlspecialchars($property['host_name']); ?>
                    </h2>
                    <p class="text-gray-500">Superhost · 5 years hosting</p>
                </div>
                <div class="flex-shrink-0">
                    <i class="fas fa-user-circle text-gray-400 text-5xl"></i>
                </div>
            </div>

            <!-- Property Description -->
            <div class="py-6 border-b">
                <h3 class="text-xl font-semibold text-gray-900 mb-4">About this place</h3>
                <p class="text-gray-600 whitespace-pre-line">
                    <?php echo htmlspecialchars($property['description']); ?>
                </p>
            </div>

            <!-- Amenities -->
            <div class="py-6 border-b">
                <h3 class="text-xl font-semibold text-gray-900 mb-4">What this place offers</h3>
                <div class="grid grid-cols-2 gap-4">
                    <div class="flex items-center">
                        <i class="fas fa-wifi text-gray-400 w-6"></i>
                        <span class="ml-3">Wifi</span>
                    </div>
                    <div class="flex items-center">
                        <i class="fas fa-parking text-gray-400 w-6"></i>
                        <span class="ml-3">Free parking</span>
                    </div>
                    <div class="flex items-center">
                        <i class="fas fa-swimming-pool text-gray-400 w-6"></i>
                        <span class="ml-3">Pool</span>
                    </div>
                    <div class="flex items-center">
                        <i class="fas fa-tv text-gray-400 w-6"></i>
                        <span class="ml-3">TV</span>
                    </div>
                    <div class="flex items-center">
                        <i class="fas fa-snowflake text-gray-400 w-6"></i>
                        <span class="ml-3">Air conditioning</span>
                    </div>
                    <div class="flex items-center">
                        <i class="fas fa-utensils text-gray-400 w-6"></i>
                        <span class="ml-3">Kitchen</span>
                    </div>
                </div>
            </div>

            <!-- Location -->
            <div class="py-6">
                <h3 class="text-xl font-semibold text-gray-900 mb-4">Where you'll be</h3>
                <div class="bg-gray-200 rounded-lg h-64 flex items-center justify-center">
                    <span class="text-gray-500">Map placeholder</span>
                </div>
                <p class="mt-4 text-gray-600">
                    <?php echo htmlspecialchars($property['location']); ?>
                </p>
            </div>
        </div>

        <!-- Right Column - Booking Card -->
        <div class="lg:col-span-1">
            <div class="sticky top-8">
                <div class="bg-white rounded-xl shadow-lg p-6 border">
                    <div class="flex justify-between items-start mb-6">
                        <div>
                            <span class="text-2xl font-semibold text-gray-900">
                                $<?php echo number_format($property['price'], 2); ?>
                            </span>
                            <span class="text-gray-600">/ night</span>
                        </div>
                        <div class="flex items-center">
                            <i class="fas fa-star text-yellow-400"></i>
                            <span class="ml-1 text-sm text-gray-600">4.9 · 128 reviews</span>
                        </div>
                    </div>

                    <!-- Booking Form -->
                    <form action="?page=book" method="POST" class="space-y-4">
                        <input type="hidden" name="property_id" value="<?php echo $property['id']; ?>">
                        
                        <!-- Dates -->
                        <div class="grid grid-cols-2 gap-4">
                            <div>
                                <label for="check_in" class="block text-sm font-medium text-gray-700">Check-in</label>
                                <input type="date" id="check_in" name="check_in" required
                                       class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-red-500 focus:ring-red-500">
                            </div>
                            <div>
                                <label for="check_out" class="block text-sm font-medium text-gray-700">Check-out</label>
                                <input type="date" id="check_out" name="check_out" required
                                       class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-red-500 focus:ring-red-500">
                            </div>
                        </div>

                        <!-- Guests -->
                        <div>
                            <label for="guests" class="block text-sm font-medium text-gray-700">Guests</label>
                            <select id="guests" name="guests" required
                                    class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-red-500 focus:ring-red-500">
                                <?php for ($i = 1; $i <= 6; $i++): ?>
                                    <option value="<?php echo $i; ?>"><?php echo $i; ?> guest<?php echo $i > 1 ? 's' : ''; ?></option>
                                <?php endfor; ?>
                            </select>
                        </div>

                        <!-- Price Breakdown -->
                        <div class="space-y-2 py-4 border-t border-b">
                            <div class="flex justify-between">
                                <span class="text-gray-600">$<?php echo $property['price']; ?> × 5 nights</span>
                                <span>$<?php echo number_format($property['price'] * 5, 2); ?></span>
                            </div>
                            <div class="flex justify-between">
                                <span class="text-gray-600">Cleaning fee</span>
                                <span>$50.00</span>
                            </div>
                            <div class="flex justify-between">
                                <span class="text-gray-600">Service fee</span>
                                <span>$75.00</span>
                            </div>
                        </div>

                        <!-- Total -->
                        <div class="flex justify-between font-semibold">
                            <span>Total</span>
                            <span>$<?php echo number_format(($property['price'] * 5) + 125, 2); ?></span>
                        </div>

                        <!-- Submit Button -->
                        <?php if (isset($_SESSION['user_id'])): ?>
                            <button type="submit"
                                    class="w-full bg-red-600 text-white px-4 py-2 rounded-lg hover:bg-red-700 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-red-500">
                                Reserve
                            </button>
                        <?php else: ?>
                            <a href="?page=login"
                               class="block w-full text-center bg-red-600 text-white px-4 py-2 rounded-lg hover:bg-red-700">
                                Login to Reserve
                            </a>
                        <?php endif; ?>
                    </form>
                </div>
            </div>
        </div>
    </div>
</div>
