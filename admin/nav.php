<nav class="bg-blue-700 text-white shadow-lg">
    <div class="container mx-auto px-4 py-3">
        <div class="flex justify-between items-center">
            <a href="index.php" class="flex items-center">
                <img src="<?= SITE_URL ?>/public/images/donatewhilewatching.jpg" alt="<?= SITE_NAME ?> Logo" class="h-10 mr-2">
                <span class="text-xl font-bold"><?= SITE_NAME ?> Admin</span>
            </a>
            <div class="hidden md:flex space-x-4">
                <a href="index.php" class="hover:underline">Dashboard</a>
                <a href="charities.php" class="hover:underline">Charities</a>
                <a href="update_charities_confirm.php" class="hover:underline text-yellow-300">Update Charities</a>
                <a href="users.php" class="hover:underline">Users</a>
                <a href="votes.php" class="hover:underline">Votes</a>
                <a href="<?= SITE_URL ?>" class="hover:underline" target="_blank">View Site</a>
                <a href="logout.php" class="hover:underline">Logout</a>
            </div>
            <div class="md:hidden">
                <button id="mobile-menu-button" class="text-white focus:outline-none">
                    <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 6h16M4 12h16M4 18h16"></path>
                    </svg>
                </button>
            </div>
        </div>
    </div>
    <div id="mobile-menu" class="hidden md:hidden px-4 py-2 bg-blue-800">
        <a href="index.php" class="block py-2">Dashboard</a>
        <a href="charities.php" class="block py-2">Charities</a>
        <a href="update_charities_confirm.php" class="block py-2 text-yellow-300">Update Charities</a>
        <a href="users.php" class="block py-2">Users</a>
        <a href="votes.php" class="block py-2">Votes</a>
        <a href="<?= SITE_URL ?>" class="block py-2" target="_blank">View Site</a>
        <a href="logout.php" class="block py-2">Logout</a>
    </div>
</nav>

<script>
    // Mobile menu toggle
    document.addEventListener('DOMContentLoaded', function() {
        const mobileMenuButton = document.getElementById('mobile-menu-button');
        const mobileMenu = document.getElementById('mobile-menu');
        
        if (mobileMenuButton && mobileMenu) {
            mobileMenuButton.addEventListener('click', function() {
                mobileMenu.classList.toggle('hidden');
            });
        }
    });
</script> 