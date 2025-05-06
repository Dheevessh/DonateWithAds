<?php
require_once 'db.php';

// Validate email
function is_valid_email($email) {
    return filter_var($email, FILTER_VALIDATE_EMAIL);
}

// Security function to prevent XSS
function sanitize($data) {
    $data = trim($data);
    $data = stripslashes($data);
    $data = htmlspecialchars($data);
    return $data;
}

// Set a flash message
function set_flash_message($type, $message) {
    $_SESSION['flash_type'] = $type;
    $_SESSION['flash_message'] = $message;
}

// Get the flash message and clear it
function get_flash_message() {
    if (isset($_SESSION['flash_message'])) {
        $type = $_SESSION['flash_type'];
        $message = $_SESSION['flash_message'];
        
        unset($_SESSION['flash_type']);
        unset($_SESSION['flash_message']);
        
        return ['type' => $type, 'message' => $message];
    }
    return null;
}

/**
 * Check if a user is logged in
 * @return bool True if user is logged in, false otherwise
 */
function is_user_logged_in() {
    return isset($_SESSION['user_id']) && !empty($_SESSION['user_id']);
}

// Set user login session
function set_user_session($user_id, $email) {
    $_SESSION['user_id'] = $user_id;
    $_SESSION['user_email'] = $email;
}

// Check admin login
function is_admin_logged_in() {
    return isset($_SESSION['admin_id']);
}

// Set admin login session
function set_admin_session($admin_id, $username) {
    $_SESSION['admin_id'] = $admin_id;
    $_SESSION['admin_username'] = $username;
}

// Redirect to a URL
function redirect($url) {
    header("Location: $url");
    exit;
}

// Get time remaining until user can vote again
function get_time_until_next_vote($user_id) {
    $conn = connect_db();
    
    $stmt = $conn->prepare("SELECT ads_watched, last_voted FROM users WHERE id = ?");
    $stmt->bind_param("i", $user_id);
    $stmt->execute();
    $result = $stmt->get_result();
    
    if ($result->num_rows > 0) {
        $user = $result->fetch_assoc();
        
        // If user has already watched enough ads
        if ($user['ads_watched'] >= 1) {
            return 0;
        }
        
        // If user has voted recently, calculate time until next vote
        if (!empty($user['last_voted'])) {
            $last_voted = new DateTime($user['last_voted']);
            $next_vote_time = $last_voted->add(new DateInterval('PT' . AD_WATCH_INTERVAL . 'M'));
            $now = new DateTime();
            
            if ($next_vote_time > $now) {
                $interval = $now->diff($next_vote_time);
                return $interval->format('%i');
            }
        }
    }
    
    $stmt->close();
    $conn->close();
    
    return 0;
}
?> 