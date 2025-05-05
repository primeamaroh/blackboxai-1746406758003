</div> <!-- End of Main Content Container -->

    <!-- Footer -->
    <footer class="bg-gray-800 text-white mt-12">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 py-12">
            <div class="grid grid-cols-1 md:grid-cols-4 gap-8">
                <!-- About Section -->
                <div>
                    <h3 class="text-lg font-semibold mb-4">About</h3>
                    <ul class="space-y-2">
                        <li><a href="#" class="hover:text-red-400">How it works</a></li>
                        <li><a href="#" class="hover:text-red-400">Careers</a></li>
                        <li><a href="#" class="hover:text-red-400">Privacy</a></li>
                        <li><a href="#" class="hover:text-red-400">Terms</a></li>
                    </ul>
                </div>

                <!-- Host Section -->
                <div>
                    <h3 class="text-lg font-semibold mb-4">Host</h3>
                    <ul class="space-y-2">
                        <li><a href="#" class="hover:text-red-400">List your property</a></li>
                        <li><a href="#" class="hover:text-red-400">Host guidelines</a></li>
                        <li><a href="#" class="hover:text-red-400">Community</a></li>
                    </ul>
                </div>

                <!-- Support Section -->
                <div>
                    <h3 class="text-lg font-semibold mb-4">Support</h3>
                    <ul class="space-y-2">
                        <li><a href="#" class="hover:text-red-400">Help Center</a></li>
                        <li><a href="#" class="hover:text-red-400">Contact us</a></li>
                        <li><a href="#" class="hover:text-red-400">Trust & Safety</a></li>
                    </ul>
                </div>

                <!-- Social Links -->
                <div>
                    <h3 class="text-lg font-semibold mb-4">Connect with us</h3>
                    <div class="flex space-x-4">
                        <a href="#" class="hover:text-red-400">
                            <i class="fab fa-facebook-f text-xl"></i>
                        </a>
                        <a href="#" class="hover:text-red-400">
                            <i class="fab fa-twitter text-xl"></i>
                        </a>
                        <a href="#" class="hover:text-red-400">
                            <i class="fab fa-instagram text-xl"></i>
                        </a>
                        <a href="#" class="hover:text-red-400">
                            <i class="fab fa-linkedin-in text-xl"></i>
                        </a>
                    </div>
                </div>
            </div>

            <!-- Copyright -->
            <div class="border-t border-gray-700 mt-8 pt-8 text-center">
                <p>&copy; <?php echo date('Y'); ?> AirbnbClone. All rights reserved.</p>
            </div>
        </div>
    </footer>

    <!-- Mobile Menu JavaScript -->
    <script>
        document.querySelector('.mobile-menu-button').addEventListener('click', function() {
            document.getElementById('mobile-menu').classList.toggle('hidden');
        });
    </script>
</body>
</html>
