<?php require_once __DIR__ . '/../layouts/header.php'; ?>

<div class="container mx-auto px-4 py-8">
    <div class="max-w-3xl mx-auto">
        <div class="bg-white rounded-lg shadow-lg overflow-hidden">
            <div class="p-6">
                <h1 class="text-2xl font-bold text-gray-900 mb-6">Create Loan Request</h1>

                <form action="?page=loan/create" method="POST" class="space-y-6">
                    <!-- Loan Amount -->
                    <div>
                        <label for="loan_amount" class="block text-sm font-medium text-gray-700">
                            Loan Amount ($)
                        </label>
                        <div class="mt-1">
                            <input type="number" name="loan_amount" id="loan_amount" step="0.01" min="1"
                                   class="shadow-sm focus:ring-blue-500 focus:border-blue-500 block w-full sm:text-sm border-gray-300 rounded-md"
                                   value="<?php echo isset($_SESSION['old_input']['loan_amount']) ? htmlspecialchars($_SESSION['old_input']['loan_amount']) : ''; ?>"
                                   required>
                        </div>
                    </div>

                    <!-- Interest Rate -->
                    <div>
                        <label for="interest_rate" class="block text-sm font-medium text-gray-700">
                            Interest Rate (% per annum)
                        </label>
                        <div class="mt-1">
                            <input type="number" name="interest_rate" id="interest_rate" step="0.01" min="0"
                                   class="shadow-sm focus:ring-blue-500 focus:border-blue-500 block w-full sm:text-sm border-gray-300 rounded-md"
                                   value="<?php echo isset($_SESSION['old_input']['interest_rate']) ? htmlspecialchars($_SESSION['old_input']['interest_rate']) : ''; ?>"
                                   required>
                        </div>
                    </div>

                    <!-- Due Date -->
                    <div>
                        <label for="due_date" class="block text-sm font-medium text-gray-700">
                            Due Date
                        </label>
                        <div class="mt-1">
                            <input type="date" name="due_date" id="due_date"
                                   class="shadow-sm focus:ring-blue-500 focus:border-blue-500 block w-full sm:text-sm border-gray-300 rounded-md"
                                   value="<?php echo isset($_SESSION['old_input']['due_date']) ? htmlspecialchars($_SESSION['old_input']['due_date']) : ''; ?>"
                                   min="<?php echo date('Y-m-d', strtotime('+1 day')); ?>"
                                   required>
                        </div>
                    </div>

                    <!-- Collateral Toggle -->
                    <div class="space-y-4">
                        <div class="flex items-center">
                            <input type="checkbox" name="has_collateral" id="has_collateral"
                                   class="h-4 w-4 text-blue-600 focus:ring-blue-500 border-gray-300 rounded"
                                   <?php echo isset($_SESSION['old_input']['has_collateral']) ? 'checked' : ''; ?>
                                   onchange="document.getElementById('collateralSection').classList.toggle('hidden')">
                            <label for="has_collateral" class="ml-2 block text-sm text-gray-900">
                                Secure loan with collateral
                            </label>
                        </div>

                        <!-- Collateral Property Selection -->
                        <div id="collateralSection" class="<?php echo isset($_SESSION['old_input']['has_collateral']) ? '' : 'hidden'; ?> p-4 bg-gray-50 rounded-lg">
                            <h3 class="text-lg font-medium text-gray-900 mb-4">Select Property for Collateral</h3>
                            
                            <?php if (empty($properties)): ?>
                                <p class="text-sm text-gray-500">
                                    You don't have any properties to use as collateral. 
                                    <a href="?page=property/create" class="text-blue-600 hover:text-blue-500">Add a property first</a>.
                                </p>
                            <?php else: ?>
                                <div class="grid grid-cols-1 gap-4">
                                    <?php foreach ($properties as $property): ?>
                                        <label class="relative flex items-start p-4 cursor-pointer border rounded-lg hover:bg-gray-50">
                                            <div class="min-w-0 flex-1 text-sm">
                                                <div class="flex items-center">
                                                    <input type="radio" name="property_id" value="<?php echo $property['id']; ?>"
                                                           class="h-4 w-4 text-blue-600 focus:ring-blue-500 border-gray-300"
                                                           <?php echo isset($_SESSION['old_input']['property_id']) && $_SESSION['old_input']['property_id'] == $property['id'] ? 'checked' : ''; ?>>
                                                    <div class="ml-3">
                                                        <span class="font-medium text-gray-900"><?php echo htmlspecialchars($property['title']); ?></span>
                                                        <p class="text-gray-500"><?php echo htmlspecialchars($property['location']); ?></p>
                                                    </div>
                                                </div>
                                            </div>
                                            <div class="ml-3 flex-shrink-0">
                                                <img src="<?php echo htmlspecialchars($property['image_url']); ?>" 
                                                     alt="<?php echo htmlspecialchars($property['title']); ?>"
                                                     class="h-16 w-16 object-cover rounded">
                                            </div>
                                        </label>
                                    <?php endforeach; ?>
                                </div>
                            <?php endif; ?>
                        </div>
                    </div>

                    <!-- Error Messages -->
                    <?php if (isset($_SESSION['errors']) && !empty($_SESSION['errors'])): ?>
                        <div class="rounded-md bg-red-50 p-4">
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
                                                <li><?php echo htmlspecialchars($error); ?></li>
                                            <?php endforeach; ?>
                                        </ul>
                                    </div>
                                </div>
                            </div>
                        </div>
                    <?php endif; ?>

                    <!-- Submit Button -->
                    <div class="pt-4">
                        <button type="submit"
                                class="w-full flex justify-center py-2 px-4 border border-transparent rounded-md shadow-sm text-sm font-medium text-white bg-blue-600 hover:bg-blue-700 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-blue-500">
                            Create Loan Request
                        </button>
                    </div>
                </form>
            </div>
        </div>
    </div>
</div>

<?php
// Clear session data
unset($_SESSION['errors']);
unset($_SESSION['old_input']);
?>

<?php require_once __DIR__ . '/../layouts/footer.php'; ?>
