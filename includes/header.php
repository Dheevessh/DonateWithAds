<?php
require_once 'config.php';
require_once 'functions.php';

// Get flash message if exists
$flash = get_flash_message();
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title><?= SITE_NAME ?></title>
    <link href="https://cdn.jsdelivr.net/npm/tailwindcss@2.2.19/dist/tailwind.min.css" rel="stylesheet">
    <link rel="stylesheet" href="<?= SITE_URL ?>/public/css/styles.css">
    <script async src="https://pagead2.googlesyndication.com/pagead/js/adsbygoogle.js?client=ca-pub-6540350978839257" crossorigin="anonymous"></script>
</head>
<body class="min-h-screen bg-gray-100 flex flex-col">
    <!-- Navigation -->
<nav class="bg-blue-600 text-white shadow-lg h-16"> <!-- Fixed height -->
    <div class="container mx-auto px-4 h-full flex items-center justify-between">
        <a href="<?= SITE_URL ?>" class="flex items-center h-full">
            <img src="<?= SITE_URL ?>/public/images/donatewhilewatchinglogo1.jpg" 
                 alt="<?= SITE_NAME ?> Logo" 
                 class="h-20 mr- 0 object-contain">
            <span class="text-xl font-bold"><?= SITE_NAME ?></span>
        </a>
        <div class="space-x-4">
            <a href="<?= SITE_URL ?>" class="hover:underline">Home</a>
            <a href="<?= SITE_URL ?>/public/about.php" class="hover:underline">About</a>
            <a href="<?= SITE_URL ?>/public/contact.php" class="hover:underline">Contact</a>
            <a href="<?= SITE_URL ?>/public/vote.php" class="hover:underline">Vote Now</a>
            <a href="<?= SITE_URL ?>/public/charities.php" class="hover:underline">Charities</a>
            <?php if (is_admin_logged_in()): ?>
                <a href="<?= SITE_URL ?>/admin" class="hover:underline">Admin</a>
                <a href="<?= SITE_URL ?>/admin/logout.php" class="hover:underline">Logout</a>
            <?php endif; ?>
        </div>
    </div>
</nav>
    
    <!-- Flash Messages -->
    <?php if ($flash): ?>
    <div class="container mx-auto mt-4 px-4">
        <div class="alert alert-<?= $flash['type'] ?> p-4 mb-4 rounded <?= $flash['type'] === 'success' ? 'bg-green-100 text-green-800' : 'bg-red-100 text-red-800' ?>">
            <?= $flash['message'] ?>
        </div>
    </div>
    <?php endif; ?>
    
    <!-- Main Content -->
    <main class="flex-grow container mx-auto px-4 py-6"> 
    