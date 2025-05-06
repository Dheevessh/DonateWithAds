<?php
require_once '../includes/config.php';
require_once '../includes/db.php';
require_once '../includes/functions.php';

header('Content-Type: application/json');

// Check if request is POST
if ($_SERVER['REQUEST_METHOD'] !== 'POST') {
    echo json_encode([
        'success' => false,
        'message' => 'Invalid request method'
    ]);
    exit;
}

// Get and validate email
$email = isset($_POST['email']) ? sanitize($_POST['email']) : '';

if (!is_valid_email($email)) {
    echo json_encode([
        'success' => false,
        'message' => 'Invalid email address'
    ]);
    exit;
}

try {
    // Record user
    $user_id = record_user($email);
    
    // Set user session
    set_user_session($user_id, $email);
    
    echo json_encode([
        'success' => true,
        'message' => 'Email recorded successfully'
    ]);
} catch (Exception $e) {
    echo json_encode([
        'success' => false,
        'message' => 'An error occurred: ' . $e->getMessage()
    ]);
}
?> 