<?php
require_once 'auth_check.php';
require_once '../includes/db.php';

// Get flash message
$flash = get_flash_message();
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Update Charities - <?= SITE_NAME ?> Admin</title>
    <link href="https://cdn.jsdelivr.net/npm/tailwindcss@2.2.19/dist/tailwind.min.css" rel="stylesheet">
</head>
<body class="bg-gray-100 min-h-screen">
    <?php include 'nav.php'; ?>
    
    <div class="container mx-auto px-4 py-8">
        <div class="mb-8">
            <h1 class="text-3xl font-bold">Update Charities</h1>
            <p class="text-gray-600">Replace existing charities with the new charity list</p>
        </div>
        
        <?php if ($flash): ?>
        <div class="alert alert-<?= $flash['type'] ?> p-4 mb-6 rounded <?= $flash['type'] === 'success' ? 'bg-green-100 text-green-800' : 'bg-red-100 text-red-800' ?>">
            <?= $flash['message'] ?>
        </div>
        <?php endif; ?>
        
        <div class="bg-white rounded-lg shadow-md p-6 mb-6">
            <h2 class="text-xl font-semibold mb-4">Warning: This Will Update All Charities</h2>
            <p class="text-red-600 mb-4">
                This action will remove all existing charities and replace them with the new charity list.
                Any existing votes for the current charities will remain in the database but won't be associated with the new charities.
            </p>
            
            <h3 class="text-lg font-semibold mb-2">New Charity List:</h3>
            <ul class="list-disc ml-6 mb-6">
                <li class="mb-2">National Cancer Society Malaysia (NCSM)</li>
                <li class="mb-2">PAWS Animal Welfare Society</li>
                <li class="mb-2">Charity Right Malaysia</li>
                <li class="mb-2">Islamic Relief Malaysia – Palestine Appeal</li>
                <li class="mb-2">Cinta Gaza Malaysia (CGM)</li>
            </ul>
            
            <p class="mb-6">
                Please make sure you have backed up your database before proceeding if you want to preserve votes for the old charities.
            </p>
            
            <div class="flex space-x-4">
                <a href="charities.php" class="bg-gray-500 hover:bg-gray-600 text-white font-bold py-2 px-4 rounded">
                    Cancel
                </a>
                <a href="update_charities.php" class="bg-red-600 hover:bg-red-700 text-white font-bold py-2 px-4 rounded" onclick="return confirm('Are you sure you want to update all charities? This action cannot be undone.')">
                    Yes, Update Charities
                </a>
            </div>
        </div>
    </div>
    
    <footer class="bg-gray-800 text-white py-4 mt-8">
        <div class="container mx-auto px-4 text-center">
            <p>&copy; <?= date('Y') ?> <?= SITE_NAME ?> Admin. All rights reserved.</p>
        </div>
    </footer>
</body>
</html> 