    </main>
    
    <!-- Footer -->
    <footer class="bg-gray-800 text-white py-6">
        <div class="container mx-auto px-4">
            <div class="flex flex-col md:flex-row justify-between items-center">
                <div class="mb-4 md:mb-0">
                    <h3 class="text-xl font-bold"><?= SITE_NAME ?></h3>
                    <p class="mt-2">Doing Good Has Never Been This Easy.</p>
                </div>
                <div>
                    <p class="mb-2">&copy; <?= date('Y') ?> <?= SITE_NAME ?>. All rights reserved.</p>
                    <div class="text-center text-sm">
                        <a href="<?= SITE_URL ?>/public/privacy.php" class="text-blue-300 hover:text-white hover:underline">Privacy Policy</a>
                    </div>
                </div>
            </div>
        </div>
    </footer>
    
    <script src="<?= SITE_URL ?>/public/js/main.js"></script>
</body>
</html> 