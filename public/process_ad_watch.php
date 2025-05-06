<?php
require_once '../includes/config.php';
require_once '../includes/db.php';
require_once '../includes/functions.php';

header('Content-Type: application/json');

// Check if user is logged in
if (!is_user_logged_in()) {
    echo json_encode([
        'success' => false,
        'message' => 'User not logged in'
    ]);
    exit;
}

// Record ad watch
try {
    $success = record_ad_watch($_SESSION['user_id']);
    
    // Get updated user information
    $conn = connect_db();
    $stmt = $conn->prepare("SELECT ads_watched, last_voted FROM users WHERE id = ?");
    $stmt->bind_param("i", $_SESSION['user_id']);
    $stmt->execute();
    $result = $stmt->get_result();
    $user = $result->fetch_assoc();
    
    // Always require just 1 ad per vote
    $required_ad_watches = 1;
    $can_vote = $user['ads_watched'] >= $required_ad_watches;
    
    $stmt->close();
    $conn->close();
    
    echo json_encode([
        'success' => $success,
        'message' => $success ? 'Ad watch recorded successfully' : 'Failed to record ad watch',
        'ads_watched' => (int)$user['ads_watched'],
        'ads_needed' => (int)$required_ad_watches,
        'can_vote' => $can_vote,
        'is_first_time' => false
    ]);
} catch (Exception $e) {
    echo json_encode([
        'success' => false,
        'message' => 'An error occurred: ' . $e->getMessage()
    ]);
}
?> 