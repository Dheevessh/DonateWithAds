<?php
require_once '../includes/config.php';
require_once '../includes/functions.php';

// Check if admin is logged in
if (!is_admin_logged_in()) {
    // Set flash message
    set_flash_message('error', 'Please login to access the admin area');
    
    // Redirect to login page
    redirect(SITE_URL . '/admin/login.php');
}
?> 