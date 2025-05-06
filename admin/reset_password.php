<?php
require_once '../includes/db.php';

$conn = connect_db();

$username = 'admin'; // change this if needed
$new_password = 'newsecurepassword'; // your new password
$new_hash = password_hash($new_password, PASSWORD_DEFAULT);

$stmt = $conn->prepare("UPDATE admin_users SET password_hash = ? WHERE username = ?");
$stmt->bind_param("ss", $new_hash, $username);

if ($stmt->execute()) {
    echo "Password successfully updated for user '$username'.";
} else {
    echo "Error updating password.";
}

$stmt->close();
$conn->close();
?>
