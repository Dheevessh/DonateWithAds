<?php
require_once 'config.php';

// Create a database connection
function connect_db() {
    $conn = new mysqli(DB_HOST, DB_USER, DB_PASS, DB_NAME);
    
    if ($conn->connect_error) {
        die("Connection failed: " . $conn->connect_error);
    }
    
    return $conn;
}

// Get all charities
function get_charities() {
    $conn = connect_db();
    $sql = "SELECT * FROM charities ORDER BY name ASC";
    $result = $conn->query($sql);
    
    $charities = array();
    if ($result->num_rows > 0) {
        while($row = $result->fetch_assoc()) {
            $charities[] = $row;
        }
    }
    
    $conn->close();
    return $charities;
}

// Get charity vote counts
function get_charity_vote_counts() {
    $conn = connect_db();
    $sql = "SELECT c.id, c.name, COUNT(v.id) as vote_count 
            FROM charities c
            LEFT JOIN votes v ON c.id = v.charity_id
            GROUP BY c.id
            ORDER BY vote_count DESC";
    
    $result = $conn->query($sql);
    
    $vote_counts = array();
    if ($result->num_rows > 0) {
        while($row = $result->fetch_assoc()) {
            $vote_counts[] = $row;
        }
    }
    
    $conn->close();
    return $vote_counts;
}

// Record a user by email
function record_user($email) {
    $conn = connect_db();
    
    // Check if user exists
    $stmt = $conn->prepare("SELECT id FROM users WHERE email = ?");
    $stmt->bind_param("s", $email);
    $stmt->execute();
    $result = $stmt->get_result();
    
    if ($result->num_rows > 0) {
        $user = $result->fetch_assoc();
        $user_id = $user['id'];
    } else {
        // Create new user
        $stmt = $conn->prepare("INSERT INTO users (email) VALUES (?)");
        $stmt->bind_param("s", $email);
        $stmt->execute();
        $user_id = $conn->insert_id;
    }
    
    $stmt->close();
    $conn->close();
    
    return $user_id;
}

// Record an ad watch
function record_ad_watch($user_id) {
    $conn = connect_db();
    
    // Insert ad watch record
    $stmt = $conn->prepare("INSERT INTO ad_watches (user_id) VALUES (?)");
    $stmt->bind_param("i", $user_id);
    $stmt->execute();
    
    // Update user's ads_watched count
    $stmt = $conn->prepare("UPDATE users SET ads_watched = ads_watched + 1 WHERE id = ?");
    $stmt->bind_param("i", $user_id);
    $stmt->execute();
    
    $stmt->close();
    $conn->close();
    
    return true;
}

// Record a vote
function record_vote($user_id, $charity_id) {
    $conn = connect_db();
    
    // Check if user has watched enough ads
    $stmt = $conn->prepare("SELECT ads_watched, last_voted FROM users WHERE id = ?");
    $stmt->bind_param("i", $user_id);
    $stmt->execute();
    $result = $stmt->get_result();
    $user = $result->fetch_assoc();
    
    // Always require just 1 ad per vote
    $required_ad_watches = 1;
    
    if ($user['ads_watched'] < $required_ad_watches) {
        $stmt->close();
        $conn->close();
        return false;
    }
    
    // Insert vote
    $stmt = $conn->prepare("INSERT INTO votes (user_id, charity_id, ad_watched) VALUES (?, ?, TRUE)");
    $stmt->bind_param("ii", $user_id, $charity_id);
    $stmt->execute();
    
    // Update user's last voted time and reset ads_watched
    $stmt = $conn->prepare("UPDATE users SET last_voted = NOW(), ads_watched = 0 WHERE id = ?");
    $stmt->bind_param("i", $user_id);
    $stmt->execute();
    
    $stmt->close();
    $conn->close();
    
    return true;
}

// Check if a user can vote
function can_user_vote($user_id) {
    $conn = connect_db();
    
    $stmt = $conn->prepare("SELECT ads_watched, last_voted FROM users WHERE id = ?");
    $stmt->bind_param("i", $user_id);
    $stmt->execute();
    $result = $stmt->get_result();
    
    if ($result->num_rows > 0) {
        $user = $result->fetch_assoc();
        
        // Always require just 1 ad per vote
        $required_ad_watches = 1;
        
        // Check if user has watched enough ads
        if ($user['ads_watched'] >= $required_ad_watches) {
            $stmt->close();
            $conn->close();
            return true;
        }
    }
    
    $stmt->close();
    $conn->close();
    return false;
}
?> 