<?php
require_once '../includes/config.php';
require_once '../includes/db.php';
require_once '../includes/functions.php';

// Check if request is POST
if ($_SERVER['REQUEST_METHOD'] !== 'POST') {
    set_flash_message('error', 'Invalid request method');
    redirect(SITE_URL . '/public/vote.php');
}

// Get charity ID
$charity_id = isset($_POST['charity_id']) ? (int)$_POST['charity_id'] : 0;

if ($charity_id <= 0) {
    set_flash_message('error', 'Invalid charity selection');
    redirect(SITE_URL . '/public/vote.php');
}

// Check if user is logged in with email, if not create a temporary session
$user_id = 0;
if (is_user_logged_in()) {
    $user_id = $_SESSION['user_id'];
} else {
    // Create or get anonymous user
    $anon_id = isset($_SESSION['anon_id']) ? $_SESSION['anon_id'] : null;
    
    if (!$anon_id) {
        // Create anonymous user with random ID as email
        $random_id = 'anon_' . uniqid();
        $user_id = record_user($random_id);
        
        // Store in session
        $_SESSION['anon_id'] = $random_id;
        $_SESSION['user_id'] = $user_id;
    } else {
        // Get existing anonymous user
        $conn = connect_db();
        $stmt = $conn->prepare("SELECT id FROM users WHERE email = ?");
        $stmt->bind_param("s", $anon_id);
        $stmt->execute();
        $result = $stmt->get_result();
        
        if ($result->num_rows > 0) {
            $user = $result->fetch_assoc();
            $user_id = $user['id'];
            $_SESSION['user_id'] = $user_id;
        } else {
            // If user was deleted, create new one
            $user_id = record_user($anon_id);
            $_SESSION['user_id'] = $user_id;
        }
        
        $stmt->close();
        $conn->close();
    }
}

// Record the vote
try {
    $success = record_vote($user_id, $charity_id);
    
    if ($success) {
        set_flash_message('success', 'Thank you for your vote!');
        redirect(SITE_URL . '/public/thank_you.php');
    } else {
        set_flash_message('error', 'You need to watch more ads before voting again');
        redirect(SITE_URL . '/public/vote.php');
    }
} catch (Exception $e) {
    set_flash_message('error', 'An error occurred: ' . $e->getMessage());
    redirect(SITE_URL . '/public/vote.php');
}
?> 