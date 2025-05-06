<?php
require_once '../includes/config.php';
require_once '../includes/functions.php';

// Unset admin session variables
if (isset($_SESSION['admin_id'])) {
    unset($_SESSION['admin_id']);
}

if (isset($_SESSION['admin_username'])) {
    unset($_SESSION['admin_username']);
}

// Set flash message
set_flash_message('success', 'You have been successfully logged out');

// Redirect to login page
redirect(SITE_URL . '/admin/login.php');
?> 