<?php require_once __DIR__ . '/../layouts/header.php'; ?>

<div class="container mx-auto px-4 py-8">
    <div class="mb-8">
        <h1 class="text-3xl font-bold text-gray-900">Loan Requests</h1>
        <p class="mt-2 text-gray-600">Browse available loan requests or create your own</p>
    </div>

    <!-- Filter Tabs -->
    <div class="mb-8 border-b border-gray-200">
        <nav class="-mb-px flex space-x-8" aria-label="Tabs">
            <a href="?page=loans" class="<?php echo !isset($_GET['type']) ? 'border-blue-500 text-blue-600' : 'border-transparent text-gray-500 hover:text-gray-700 hover:border-gray-300'; ?> whitespace-nowrap py-4 px-1 border-b-2 font-medium text-sm">
                All Loans
            </a>
            <a href="?page=loans&type=no_collateral" class="<?php echo isset($_GET['type']) && $_GET['type'] === 'no_collateral' ? 'border-blue-500 text-blue-600' : 'border-transparent text-gray-500 hover:text-gray-700 hover:border-gray-300'; ?> whitespace-nowrap py-4 px-1 border-b-2 font-medium text-sm">
                No Collateral
            </a>
            <a href="?page=loans&type=collateral" class="<?php echo isset($_GET['type']) && $_GET['type'] === 'collateral' ? 'border-blue-500 text-blue-600' : 'border-transparent text-gray-500 hover:text-gray-700 hover:border-gray-300'; ?> whitespace-nowrap py-4 px-1 border-b-2 font-medium text-sm">
                With Collateral
            </a>
            <a href="?page=loans&type=for_sale" class="<?php echo isset($_GET['type']) && $_GET['type'] === 'for_sale' ? 'border-blue-500 text-blue-600' : 'border-transparent text-gray-500 hover:text-gray-700 hover:border-gray-300'; ?> whitespace-nowrap py-4 px-1 border-b-2 font-medium text-sm">
                For Sale
            </a>
        </nav>
    </div>

    <!-- Create Loan Button -->
    <div class="mb-8">
        <a href="?page=loan/create" class="inline-flex items-center px-4 py-2 border border-transparent text-sm font-medium rounded-md shadow-sm text-white bg-blue-600 hover:bg-blue-700 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-blue-500">
            <i class="fas fa-plus mr-2"></i> Create Loan Request
        </a>
    </div>

    <!-- Loans Grid -->
    <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-6">
        <?php if (empty($loans)): ?>
            <div class="col-span-3 text-center py-12">
                <i class="fas fa-search text-4xl text-gray-400 mb-4"></i>
                <p class="text-gray-500">No loan requests found</p>
            </div>
        <?php else: ?>
            <?php foreach ($loans as $loan): ?>
                <div class="bg-white rounded-lg shadow-md overflow-hidden border border-gray-200 hover:shadow-lg transition-shadow duration-300">
                    <?php if ($loan['has_collateral'] && $loan['property_image']): ?>
                        <img src="<?php echo htmlspecialchars($loan['property_image']); ?>" alt="Property" class="w-full h-48 object-cover">
                    <?php else: ?>
                        <div class="w-full h-48 bg-gray-200 flex items-center justify-center">
                            <i class="fas fa-money-bill-wave text-4xl text-gray-400"></i>
                        </div>
                    <?php endif; ?>
                    
                    <div class="p-6">
                        <div class="flex items-center mb-2">
                            <span class="px-2 py-1 text-xs font-semibold rounded-full <?php echo $loan['has_collateral'] ? 'bg-green-100 text-green-800' : 'bg-yellow-100 text-yellow-800'; ?>">
                                <?php echo $loan['has_collateral'] ? 'Collateral' : 'No Collateral'; ?>
                            </span>
                            <span class="ml-2 px-2 py-1 text-xs font-semibold rounded-full <?php echo $loan['status'] === 'open' ? 'bg-blue-100 text-blue-800' : 'bg-gray-100 text-gray-800'; ?>">
                                <?php echo ucfirst($loan['status']); ?>
                            </span>
                        </div>

                        <h3 class="text-lg font-semibold text-gray-900 mb-2">
                            $<?php echo number_format($loan['loan_amount'], 2); ?>
                        </h3>

                        <div class="mb-4">
                            <div class="flex items-center text-sm text-gray-600 mb-1">
                                <i class="fas fa-user mr-2"></i>
                                <?php echo htmlspecialchars($loan['borrower_name']); ?>
                            </div>
                            <div class="flex items-center text-sm text-gray-600 mb-1">
                                <i class="fas fa-chart-line mr-2"></i>
                                Credit Score: <?php echo $loan['credit_score']; ?>
                            </div>
                            <div class="flex items-center text-sm text-gray-600">
                                <i class="fas fa-percentage mr-2"></i>
                                Interest Rate: <?php echo $loan['interest_rate']; ?>%
                            </div>
                        </div>

                        <?php if ($loan['funded_amount'] > 0): ?>
                            <div class="mb-4">
                                <div class="relative pt-1">
                                    <div class="flex mb-2 items-center justify-between">
                                        <div class="text-xs font-semibold text-gray-600">
                                            Funded: $<?php echo number_format($loan['funded_amount'], 2); ?>
                                        </div>
                                        <div class="text-xs font-semibold text-gray-600">
                                            <?php echo round(($loan['funded_amount'] / $loan['loan_amount']) * 100); ?>%
                                        </div>
                                    </div>
                                    <div class="overflow-hidden h-2 text-xs flex rounded bg-gray-200">
                                        <div style="width:<?php echo ($loan['funded_amount'] / $loan['loan_amount']) * 100; ?>%" 
                                             class="shadow-none flex flex-col text-center whitespace-nowrap text-white justify-center bg-blue-500">
                                        </div>
                                    </div>
                                </div>
                            </div>
                        <?php endif; ?>

                        <a href="?page=loan&id=<?php echo $loan['id']; ?>" 
                           class="block w-full text-center px-4 py-2 border border-transparent text-sm font-medium rounded-md text-white bg-blue-600 hover:bg-blue-700 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-blue-500">
                            View Details
                        </a>
                    </div>
                </div>
            <?php endforeach; ?>
        <?php endif; ?>
    </div>
</div>

<?php require_once __DIR__ . '/../layouts/footer.php'; ?>
