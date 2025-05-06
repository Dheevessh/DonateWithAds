<?php
require_once '../includes/config.php';
require_once '../includes/db.php';
require_once '../includes/functions.php';

header('Content-Type: application/json');

// Check if user is logged in
if (!is_user_logged_in()) {
    echo json_encode([
        'success' => false,
        'can_vote' => false,
        'message' => 'User not logged in'
    ]);
    exit;
}

// Check if user can vote
try {
    $conn = connect_db();
    $stmt = $conn->prepare("SELECT ads_watched, last_voted FROM users WHERE id = ?");
    $stmt->bind_param("i", $_SESSION['user_id']);
    $stmt->execute();
    $result = $stmt->get_result();
    
    if ($result->num_rows > 0) {
        $user = $result->fetch_assoc();
        
        // Always require just 1 ad per vote
        $required_ad_watches = 1;
        $can_vote = $user['ads_watched'] >= $required_ad_watches;
        
        echo json_encode([
            'success' => true,
            'can_vote' => $can_vote,
            'ads_watched' => (int)$user['ads_watched'],
            'ads_needed' => (int)$required_ad_watches,
            'is_first_time' => false
        ]);
    } else {
        echo json_encode([
            'success' => false,
            'can_vote' => false,
            'message' => 'User not found'
        ]);
    }
    
    $stmt->close();
    $conn->close();
} catch (Exception $e) {
    echo json_encode([
        'success' => false,
        'can_vote' => false,
        'message' => 'An error occurred: ' . $e->getMessage()
    ]);
}
?> 