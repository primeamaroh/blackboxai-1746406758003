<?php require_once __DIR__ . '/../layouts/header.php'; ?>

<div class="container mx-auto px-4 py-8">
    <div class="mb-8">
        <h1 class="text-3xl font-bold text-gray-900">Properties For Sale</h1>
        <p class="mt-2 text-gray-600">Browse properties from defaulted loans available for purchase</p>
    </div>

    <!-- Properties Grid -->
    <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-6">
        <?php if (empty($loans)): ?>
            <div class="col-span-3 text-center py-12">
                <i class="fas fa-home text-4xl text-gray-400 mb-4"></i>
                <p class="text-gray-500">No properties currently available for sale</p>
            </div>
        <?php else: ?>
            <?php foreach ($loans as $loan): ?>
                <div class="bg-white rounded-lg shadow-md overflow-hidden border border-gray-200 hover:shadow-lg transition-shadow duration-300">
                    <?php if ($loan['property_image']): ?>
                        <img src="<?php echo htmlspecialchars($loan['property_image']); ?>" 
                             alt="<?php echo htmlspecialchars($loan['property_title']); ?>"
                             class="w-full h-48 object-cover">
                    <?php endif; ?>
                    
                    <div class="p-6">
                        <div class="flex items-center justify-between mb-4">
                            <h3 class="text-lg font-semibold text-gray-900">
                                <?php echo htmlspecialchars($loan['property_title']); ?>
                            </h3>
                            <span class="px-2 py-1 text-xs font-semibold rounded-full bg-red-100 text-red-800">
                                For Sale
                            </span>
                        </div>

                        <div class="space-y-3 mb-6">
                            <div class="flex items-center text-sm text-gray-600">
                                <i class="fas fa-map-marker-alt w-5 text-gray-400"></i>
                                <span><?php echo htmlspecialchars($loan['location'] ?? 'Location not specified'); ?></span>
                            </div>
                            <div class="flex items-center text-sm text-gray-600">
                                <i class="fas fa-money-bill-wave w-5 text-gray-400"></i>
                                <span>Original Loan: $<?php echo number_format($loan['loan_amount'], 2); ?></span>
                            </div>
                            <div class="flex items-center text-sm text-gray-600">
                                <i class="fas fa-calendar w-5 text-gray-400"></i>
                                <span>Due Date: <?php echo date('M j, Y', strtotime($loan['due_date'])); ?></span>
                            </div>
                            <div class="flex items-center text-sm text-gray-600">
                                <i class="fas fa-gavel w-5 text-gray-400"></i>
                                <span>Status: Defaulted</span>
                            </div>
                        </div>

                        <div class="border-t border-gray-200 pt-4">
                            <div class="mb-4">
                                <div class="text-sm font-medium text-gray-500">Current Sale Price</div>
                                <div class="text-2xl font-bold text-gray-900">
                                    $<?php echo number_format($loan['loan_amount'] * 0.9, 2); ?>
                                </div>
                                <div class="text-xs text-gray-500">
                                    10% discount from original loan amount
                                </div>
                            </div>

                            <a href="?page=loan&id=<?php echo $loan['id']; ?>" 
                               class="block w-full text-center px-4 py-2 border border-transparent text-sm font-medium rounded-md text-white bg-red-600 hover:bg-red-700 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-red-500">
                                View Property Details
                            </a>
                        </div>
                    </div>
                </div>
            <?php endforeach; ?>
        <?php endif; ?>
    </div>
</div>

<?php require_once __DIR__ . '/../layouts/footer.php'; ?>
