<!-- Search Section -->
<div class="bg-white shadow-sm border-b">
    <div class="max-w-7xl mx-auto py-6 px-4 sm:px-6 lg:px-8">
        <form action="?page=properties" method="GET" class="grid grid-cols-1 md:grid-cols-4 gap-4">
            <input type="hidden" name="page" value="properties">
            
            <!-- Location Search -->
            <div class="col-span-2">
                <label for="location" class="block text-sm font-medium text-gray-700">Location</label>
                <div class="mt-1 relative rounded-md shadow-sm">
                    <div class="absolute inset-y-0 left-0 pl-3 flex items-center pointer-events-none">
                        <i class="fas fa-search text-gray-400"></i>
                    </div>
                    <input type="text" name="location" id="location"
                           class="focus:ring-red-500 focus:border-red-500 block w-full pl-10 sm:text-sm border-gray-300 rounded-md"
                           placeholder="Where are you going?"
                           value="<?php echo htmlspecialchars($searchParams['location'] ?? ''); ?>">
                </div>
            </div>

            <!-- Price Range -->
            <div>
                <label for="min_price" class="block text-sm font-medium text-gray-700">Min Price</label>
                <div class="mt-1">
                    <input type="number" name="min_price" id="min_price"
                           class="focus:ring-red-500 focus:border-red-500 block w-full sm:text-sm border-gray-300 rounded-md"
                           placeholder="Min $"
                           value="<?php echo htmlspecialchars($searchParams['min_price'] ?? ''); ?>">
                </div>
            </div>

            <div>
                <label for="max_price" class="block text-sm font-medium text-gray-700">Max Price</label>
                <div class="mt-1">
                    <input type="number" name="max_price" id="max_price"
                           class="focus:ring-red-500 focus:border-red-500 block w-full sm:text-sm border-gray-300 rounded-md"
                           placeholder="Max $"
                           value="<?php echo htmlspecialchars($searchParams['max_price'] ?? ''); ?>">
                </div>
            </div>

            <!-- Search Button -->
            <div class="col-span-full md:col-span-4 flex justify-end">
                <button type="submit"
                        class="inline-flex items-center px-4 py-2 border border-transparent text-sm font-medium rounded-md text-white bg-red-600 hover:bg-red-700 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-red-500">
                    <i class="fas fa-search mr-2"></i>
                    Search
                </button>
            </div>
        </form>
    </div>
</div>

<!-- Sample Properties -->
<div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 py-8">
    <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 xl:grid-cols-4 gap-6">
        <!-- Property 1 -->
        <div class="bg-white rounded-lg shadow-md overflow-hidden hover:shadow-lg transition-shadow duration-300">
            <div class="relative pb-[56.25%]">
                <img src="https://images.pexels.com/photos/1396122/pexels-photo-1396122.jpeg" 
                     alt="Luxury Beach Villa"
                     class="absolute h-full w-full object-cover">
                <div class="absolute top-4 right-4">
                    <button class="text-white hover:text-red-500 focus:outline-none">
                        <i class="far fa-heart text-xl"></i>
                    </button>
                </div>
            </div>

            <div class="p-4">
                <div class="flex justify-between items-start">
                    <div>
                        <h3 class="text-lg font-medium text-gray-900">
                            Luxury Beach Villa
                        </h3>
                        <p class="mt-1 text-sm text-gray-500">
                            <i class="fas fa-map-marker-alt"></i>
                            Malibu, California
                        </p>
                    </div>
                    <div class="flex items-center">
                        <i class="fas fa-star text-yellow-400"></i>
                        <span class="ml-1 text-sm text-gray-600">4.9</span>
                    </div>
                </div>

                <div class="mt-4 flex justify-between items-end">
                    <div>
                        <span class="text-lg font-semibold text-gray-900">$599</span>
                        <span class="text-sm text-gray-500">/ night</span>
                    </div>
                    <a href="?page=property&id=1"
                       class="inline-flex items-center px-3 py-2 border border-transparent text-sm leading-4 font-medium rounded-md text-white bg-red-600 hover:bg-red-700 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-red-500">
                        View Details
                    </a>
                </div>
            </div>
        </div>

        <!-- Property 2 -->
        <div class="bg-white rounded-lg shadow-md overflow-hidden hover:shadow-lg transition-shadow duration-300">
            <div class="relative pb-[56.25%]">
                <img src="https://images.pexels.com/photos/1571460/pexels-photo-1571460.jpeg" 
                     alt="Modern City Apartment"
                     class="absolute h-full w-full object-cover">
                <div class="absolute top-4 right-4">
                    <button class="text-white hover:text-red-500 focus:outline-none">
                        <i class="far fa-heart text-xl"></i>
                    </button>
                </div>
            </div>

            <div class="p-4">
                <div class="flex justify-between items-start">
                    <div>
                        <h3 class="text-lg font-medium text-gray-900">
                            Modern City Apartment
                        </h3>
                        <p class="mt-1 text-sm text-gray-500">
                            <i class="fas fa-map-marker-alt"></i>
                            New York City
                        </p>
                    </div>
                    <div class="flex items-center">
                        <i class="fas fa-star text-yellow-400"></i>
                        <span class="ml-1 text-sm text-gray-600">4.8</span>
                    </div>
                </div>

                <div class="mt-4 flex justify-between items-end">
                    <div>
                        <span class="text-lg font-semibold text-gray-900">$299</span>
                        <span class="text-sm text-gray-500">/ night</span>
                    </div>
                    <a href="?page=property&id=2"
                       class="inline-flex items-center px-3 py-2 border border-transparent text-sm leading-4 font-medium rounded-md text-white bg-red-600 hover:bg-red-700 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-red-500">
                        View Details
                    </a>
                </div>
            </div>
        </div>

        <!-- Property 3 -->
        <div class="bg-white rounded-lg shadow-md overflow-hidden hover:shadow-lg transition-shadow duration-300">
            <div class="relative pb-[56.25%]">
                <img src="https://images.pexels.com/photos/803975/pexels-photo-803975.jpeg" 
                     alt="Mountain Cabin Retreat"
                     class="absolute h-full w-full object-cover">
                <div class="absolute top-4 right-4">
                    <button class="text-white hover:text-red-500 focus:outline-none">
                        <i class="far fa-heart text-xl"></i>
                    </button>
                </div>
            </div>

            <div class="p-4">
                <div class="flex justify-between items-start">
                    <div>
                        <h3 class="text-lg font-medium text-gray-900">
                            Mountain Cabin Retreat
                        </h3>
                        <p class="mt-1 text-sm text-gray-500">
                            <i class="fas fa-map-marker-alt"></i>
                            Aspen, Colorado
                        </p>
                    </div>
                    <div class="flex items-center">
                        <i class="fas fa-star text-yellow-400"></i>
                        <span class="ml-1 text-sm text-gray-600">4.7</span>
                    </div>
                </div>

                <div class="mt-4 flex justify-between items-end">
                    <div>
                        <span class="text-lg font-semibold text-gray-900">$399</span>
                        <span class="text-sm text-gray-500">/ night</span>
                    </div>
                    <a href="?page=property&id=3"
                       class="inline-flex items-center px-3 py-2 border border-transparent text-sm leading-4 font-medium rounded-md text-white bg-red-600 hover:bg-red-700 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-red-500">
                        View Details
                    </a>
                </div>
            </div>
        </div>
    </div>
</div>
