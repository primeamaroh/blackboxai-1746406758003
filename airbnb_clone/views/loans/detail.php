<?php require_once __DIR__ . '/../layouts/header.php'; ?>

<div class="container mx-auto px-4 py-8">
    <!-- Loan Details -->
    <div class="bg-white rounded-lg shadow-lg overflow-hidden">
        <div class="p-6">
            <div class="flex justify-between items-start">
                <div>
                    <h1 class="text-3xl font-bold text-gray-900 mb-2">
                        $<?php echo number_format($loan['loan_amount'], 2); ?>
                    </h1>
                    <div class="flex items-center space-x-2 mb-4">
                        <span class="px-2 py-1 text-xs font-semibold rounded-full <?php echo $loan['has_collateral'] ? 'bg-green-100 text-green-800' : 'bg-yellow-100 text-yellow-800'; ?>">
                            <?php echo $loan['has_collateral'] ? 'Collateral' : 'No Collateral'; ?>
                        </span>
                        <span class="px-2 py-1 text-xs font-semibold rounded-full <?php echo $loan['status'] === 'open' ? 'bg-blue-100 text-blue-800' : 'bg-gray-100 text-gray-800'; ?>">
                            <?php echo ucfirst($loan['status']); ?>
                        </span>
                    </div>
                </div>
                <?php if ($loan['status'] === 'open' && $_SESSION['user_id'] !== $loan['borrower_id']): ?>
                    <button onclick="document.getElementById('fundingModal').classList.remove('hidden')" 
                            class="inline-flex items-center px-4 py-2 border border-transparent text-sm font-medium rounded-md shadow-sm text-white bg-blue-600 hover:bg-blue-700">
                        <i class="fas fa-hand-holding-usd mr-2"></i> Fund This Loan
                    </button>
                <?php endif; ?>
            </div>

            <!-- Progress Bar -->
            <?php if ($loan['funded_amount'] > 0): ?>
                <div class="mb-6">
                    <div class="relative pt-1">
                        <div class="flex mb-2 items-center justify-between">
                            <div>
                                <span class="text-xs font-semibold inline-block text-blue-600">
                                    Funding Progress
                                </span>
                            </div>
                            <div class="text-right">
                                <span class="text-xs font-semibold inline-block text-blue-600">
                                    <?php echo round(($loan['funded_amount'] / $loan['loan_amount']) * 100); ?>%
                                </span>
                            </div>
                        </div>
                        <div class="overflow-hidden h-2 mb-4 text-xs flex rounded bg-blue-200">
                            <div style="width:<?php echo ($loan['funded_amount'] / $loan['loan_amount']) * 100; ?>%" 
                                 class="shadow-none flex flex-col text-center whitespace-nowrap text-white justify-center bg-blue-500">
                            </div>
                        </div>
                        <div class="text-sm text-gray-600">
                            $<?php echo number_format($loan['funded_amount'], 2); ?> of $<?php echo number_format($loan['loan_amount'], 2); ?> funded
                        </div>
                    </div>
                </div>
            <?php endif; ?>

            <!-- Loan Information -->
            <div class="grid grid-cols-1 md:grid-cols-2 gap-6 mb-6">
                <div>
                    <h3 class="text-lg font-semibold text-gray-900 mb-4">Loan Details</h3>
                    <div class="space-y-3">
                        <div class="flex items-center text-sm">
                            <i class="fas fa-user w-6 text-gray-400"></i>
                            <span class="ml-2">Borrower: <?php echo htmlspecialchars($loan['borrower_name']); ?></span>
                        </div>
                        <div class="flex items-center text-sm">
                            <i class="fas fa-chart-line w-6 text-gray-400"></i>
                            <span class="ml-2">Credit Score: <?php echo $loan['credit_score']; ?></span>
                        </div>
                        <div class="flex items-center text-sm">
                            <i class="fas fa-percentage w-6 text-gray-400"></i>
                            <span class="ml-2">Interest Rate: <?php echo $loan['interest_rate']; ?>%</span>
                        </div>
                        <div class="flex items-center text-sm">
                            <i class="fas fa-calendar w-6 text-gray-400"></i>
                            <span class="ml-2">Due Date: <?php echo date('M j, Y', strtotime($loan['due_date'])); ?></span>
                        </div>
                    </div>
                </div>

                <?php if ($loan['has_collateral'] && $loan['property_title']): ?>
                    <div>
                        <h3 class="text-lg font-semibold text-gray-900 mb-4">Collateral Property</h3>
                        <div class="bg-gray-50 rounded-lg overflow-hidden">
                            <img src="<?php echo htmlspecialchars($loan['property_image']); ?>" 
                                 alt="<?php echo htmlspecialchars($loan['property_title']); ?>" 
                                 class="w-full h-48 object-cover">
                            <div class="p-4">
                                <h4 class="font-medium text-gray-900">
                                    <?php echo htmlspecialchars($loan['property_title']); ?>
                                </h4>
                            </div>
                        </div>
                    </div>
                <?php endif; ?>
            </div>

            <!-- Funding History -->
            <?php if (!empty($fundings)): ?>
                <div class="mt-8">
                    <h3 class="text-lg font-semibold text-gray-900 mb-4">Funding History</h3>
                    <div class="bg-gray-50 rounded-lg overflow-hidden">
                        <div class="flow-root">
                            <ul role="list" class="-mb-8">
                                <?php foreach ($fundings as $index => $funding): ?>
                                    <li>
                                        <div class="relative pb-8">
                                            <?php if ($index !== count($fundings) - 1): ?>
                                                <span class="absolute top-4 left-4 -ml-px h-full w-0.5 bg-gray-200" aria-hidden="true"></span>
                                            <?php endif; ?>
                                            <div class="relative flex space-x-3">
                                                <div>
                                                    <span class="h-8 w-8 rounded-full bg-blue-500 flex items-center justify-center ring-8 ring-white">
                                                        <i class="fas fa-dollar-sign text-white"></i>
                                                    </span>
                                                </div>
                                                <div class="min-w-0 flex-1 pt-1.5 flex justify-between space-x-4">
                                                    <div>
                                                        <p class="text-sm text-gray-500">
                                                            Funded by <span class="font-medium text-gray-900"><?php echo htmlspecialchars($funding['lender_name']); ?></span>
                                                        </p>
                                                    </div>
                                                    <div class="text-right text-sm whitespace-nowrap text-gray-500">
                                                        <span class="font-medium text-gray-900">$<?php echo number_format($funding['amount'], 2); ?></span>
                                                        <div class="text-xs"><?php echo date('M j, Y', strtotime($funding['created_at'])); ?></div>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                    </li>
                                <?php endforeach; ?>
                            </ul>
                        </div>
                    </div>
                </div>
            <?php endif; ?>
        </div>
    </div>
</div>

<!-- Funding Modal -->
<div id="fundingModal" class="hidden fixed z-10 inset-0 overflow-y-auto" aria-labelledby="modal-title" role="dialog" aria-modal="true">
    <div class="flex items-end justify-center min-h-screen pt-4 px-4 pb-20 text-center sm:block sm:p-0">
        <div class="fixed inset-0 bg-gray-500 bg-opacity-75 transition-opacity" aria-hidden="true"></div>
        <span class="hidden sm:inline-block sm:align-middle sm:h-screen" aria-hidden="true">&#8203;</span>
        <div class="inline-block align-bottom bg-white rounded-lg text-left overflow-hidden shadow-xl transform transition-all sm:my-8 sm:align-middle sm:max-w-lg sm:w-full">
            <form action="?page=loan/fund&id=<?php echo $loan['id']; ?>" method="POST">
                <div class="bg-white px-4 pt-5 pb-4 sm:p-6 sm:pb-4">
                    <div class="sm:flex sm:items-start">
                        <div class="mx-auto flex-shrink-0 flex items-center justify-center h-12 w-12 rounded-full bg-blue-100 sm:mx-0 sm:h-10 sm:w-10">
                            <i class="fas fa-hand-holding-usd text-blue-600"></i>
                        </div>
                        <div class="mt-3 text-center sm:mt-0 sm:ml-4 sm:text-left">
                            <h3 class="text-lg leading-6 font-medium text-gray-900" id="modal-title">
                                Fund This Loan
                            </h3>
                            <div class="mt-2">
                                <p class="text-sm text-gray-500">
                                    How much would you like to contribute to this loan?
                                </p>
                                <div class="mt-4">
                                    <label for="amount" class="block text-sm font-medium text-gray-700">
                                        Amount ($)
                                    </label>
                                    <div class="mt-1">
                                        <input type="number" name="amount" id="amount" step="0.01" min="1" 
                                               max="<?php echo $loan['loan_amount'] - $loan['funded_amount']; ?>"
                                               class="shadow-sm focus:ring-blue-500 focus:border-blue-500 block w-full sm:text-sm border-gray-300 rounded-md"
                                               required>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="bg-gray-50 px-4 py-3 sm:px-6 sm:flex sm:flex-row-reverse">
                    <button type="submit" class="w-full inline-flex justify-center rounded-md border border-transparent shadow-sm px-4 py-2 bg-blue-600 text-base font-medium text-white hover:bg-blue-700 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-blue-500 sm:ml-3 sm:w-auto sm:text-sm">
                        Fund Now
                    </button>
                    <button type="button" onclick="document.getElementById('fundingModal').classList.add('hidden')"
                            class="mt-3 w-full inline-flex justify-center rounded-md border border-gray-300 shadow-sm px-4 py-2 bg-white text-base font-medium text-gray-700 hover:bg-gray-50 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-blue-500 sm:mt-0 sm:ml-3 sm:w-auto sm:text-sm">
                        Cancel
                    </button>
                </div>
            </form>
        </div>
    </div>
</div>

<?php require_once __DIR__ . '/../layouts/footer.php'; ?>
