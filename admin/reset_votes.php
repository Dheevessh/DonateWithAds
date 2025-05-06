<?php
require_once 'auth_check.php';
require_once '../includes/db.php';

// Check if user confirmed
if (isset($_POST['confirm']) && $_POST['confirm'] === 'yes') {
    $conn = connect_db();
    
    // Begin transaction
    $conn->begin_transaction();
    
    try {
        // Get the current leader before reset
        $leader_sql = "SELECT c.id, c.name, COUNT(v.id) as vote_count 
                      FROM charities c
                      LEFT JOIN votes v ON c.id = v.charity_id
                      GROUP BY c.id
                      ORDER BY vote_count DESC
                      LIMIT 1";
        $leader_result = $conn->query($leader_sql);
        $leader = $leader_result->fetch_assoc();
        
        // Delete all votes
        $conn->query("DELETE FROM votes");
        
        // Reset user ad watch counts
        $conn->query("UPDATE users SET ads_watched = 0");
        
        // Delete ad watch records
        $conn->query("DELETE FROM ad_watches");
        
        // Commit transaction
        $conn->commit();
        
        $conn->close();
        
        // Set success message
        if ($leader && $leader['vote_count'] > 0) {
            set_flash_message('success', 'All votes have been reset. The winner for this month was: ' . htmlspecialchars($leader['name']) . ' with ' . $leader['vote_count'] . ' votes.');
        } else {
            set_flash_message('success', 'All votes have been reset.');
        }
        
        // Redirect back to dashboard
        redirect(SITE_URL . '/admin/index.php');
        
    } catch (Exception $e) {
        // Rollback transaction on error
        $conn->rollback();
        $conn->close();
        
        // Set error message
        set_flash_message('error', 'An error occurred: ' . $e->getMessage());
        
        // Redirect back to dashboard
        redirect(SITE_URL . '/admin/index.php');
    }
} else {
    // Show confirmation page
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Reset Votes - <?= SITE_NAME ?> Admin</title>
    <link href="https://cdn.jsdelivr.net/npm/tailwindcss@2.2.19/dist/tailwind.min.css" rel="stylesheet">
</head>
<body class="bg-gray-100 min-h-screen">
    <?php include 'nav.php'; ?>
    
    <div class="container mx-auto px-4 py-8">
        <div class="max-w-md mx-auto bg-white rounded-lg shadow-md p-6">
            <h1 class="text-2xl font-bold text-red-600 mb-4">Reset All Votes</h1>
            
            <div class="bg-yellow-100 text-yellow-800 p-4 rounded mb-6">
                <p><strong>Warning:</strong> This action will reset all votes and cannot be undone. This should only be done at the end of each month.</p>
            </div>
            
            <form method="post" action="">
                <input type="hidden" name="confirm" value="yes">
                
                <div class="flex justify-between items-center">
                    <a href="index.php" class="text-gray-600 hover:text-gray-800">
                        Cancel
                    </a>
                    <button type="submit" class="bg-red-600 hover:bg-red-700 text-white font-bold py-2 px-4 rounded">
                        Yes, Reset All Votes
                    </button>
                </div>
            </form>
        </div>
    </div>
    
    <footer class="bg-gray-800 text-white py-4 mt-8">
        <div class="container mx-auto px-4 text-center">
            <p>&copy; <?= date('Y') ?> <?= SITE_NAME ?> Admin. All rights reserved.</p>
        </div>
    </footer>
</body>
</html>
<?php
}
?> 