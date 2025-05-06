<?php
require_once 'auth_check.php';
require_once '../includes/db.php';

// Get statistics
$conn = connect_db();

// Get total votes
$votes_result = $conn->query("SELECT COUNT(*) as total FROM votes");
$total_votes = $votes_result->fetch_assoc()['total'];

// Get total users
$users_result = $conn->query("SELECT COUNT(*) as total FROM users");
$total_users = $users_result->fetch_assoc()['total'];

// Get total charities
$charities_result = $conn->query("SELECT COUNT(*) as total FROM charities");
$total_charities = $charities_result->fetch_assoc()['total'];

// Get recent votes
$recent_votes_sql = "SELECT v.id, u.email, c.name as charity_name, v.timestamp 
                    FROM votes v
                    JOIN users u ON v.user_id = u.id
                    JOIN charities c ON v.charity_id = c.id
                    ORDER BY v.timestamp DESC
                    LIMIT 10";
$recent_votes_result = $conn->query($recent_votes_sql);
$recent_votes = [];
while ($row = $recent_votes_result->fetch_assoc()) {
    $recent_votes[] = $row;
}

// Get vote counts by charity
$vote_counts = get_charity_vote_counts();

$conn->close();
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Admin Dashboard - <?= SITE_NAME ?></title>
    <link href="https://cdn.jsdelivr.net/npm/tailwindcss@2.2.19/dist/tailwind.min.css" rel="stylesheet">
</head>
<body class="bg-gray-100 min-h-screen">
    <?php include 'nav.php'; ?>
    
    <div class="container mx-auto px-4 py-8">
        <div class="mb-8">
            <h1 class="text-3xl font-bold">Admin Dashboard</h1>
            <p class="text-gray-600">Welcome, <?= htmlspecialchars($_SESSION['admin_username']) ?></p>
        </div>
        
        <!-- Stats -->
        <div class="grid grid-cols-1 md:grid-cols-3 gap-6 mb-8">
            <div class="bg-white rounded-lg shadow-md p-6">
                <h2 class="text-xl font-semibold text-gray-700 mb-2">Total Votes</h2>
                <p class="text-3xl font-bold text-blue-600"><?= $total_votes ?></p>
            </div>
            
            <div class="bg-white rounded-lg shadow-md p-6">
                <h2 class="text-xl font-semibold text-gray-700 mb-2">Total Users</h2>
                <p class="text-3xl font-bold text-blue-600"><?= $total_users ?></p>
            </div>
            
            <div class="bg-white rounded-lg shadow-md p-6">
                <h2 class="text-xl font-semibold text-gray-700 mb-2">Total Charities</h2>
                <p class="text-3xl font-bold text-blue-600"><?= $total_charities ?></p>
            </div>
        </div>
        
        <div class="grid grid-cols-1 lg:grid-cols-2 gap-8">
            <!-- Charity Vote Counts -->
            <div class="bg-white rounded-lg shadow-md p-6">
                <h2 class="text-xl font-semibold text-gray-700 mb-4">Charity Vote Standings</h2>
                
                <?php if (count($vote_counts) > 0): ?>
                <div class="space-y-4">
                    <?php foreach($vote_counts as $index => $charity): ?>
                    <div class="flex items-center justify-between">
                        <div class="flex items-center">
                            <span class="text-lg font-semibold"><?= ($index + 1) ?>.</span>
                            <span class="ml-2"><?= htmlspecialchars($charity['name']) ?></span>
                        </div>
                        <div class="bg-blue-100 text-blue-800 font-semibold px-3 py-1 rounded-full">
                            <?= $charity['vote_count'] ?> votes
                        </div>
                    </div>
                    <?php if ($index < count($vote_counts) - 1): ?>
                    <hr class="border-gray-200">
                    <?php endif; ?>
                    <?php endforeach; ?>
                </div>
                <?php else: ?>
                <p class="text-gray-600">No votes recorded yet.</p>
                <?php endif; ?>
                
                <div class="mt-4">
                    <a href="reset_votes.php" class="bg-red-600 hover:bg-red-700 text-white px-4 py-2 rounded inline-block mt-4" onclick="return confirm('Are you sure you want to reset all votes? This action cannot be undone.')">
                        Reset All Votes
                    </a>
                </div>
            </div>
            
            <!-- Recent Votes -->
            <div class="bg-white rounded-lg shadow-md p-6">
                <h2 class="text-xl font-semibold text-gray-700 mb-4">Recent Votes</h2>
                
                <?php if (count($recent_votes) > 0): ?>
                <div class="overflow-x-auto">
                    <table class="min-w-full">
                        <thead>
                            <tr class="bg-gray-100">
                                <th class="px-4 py-2 text-left">User</th>
                                <th class="px-4 py-2 text-left">Charity</th>
                                <th class="px-4 py-2 text-left">Time</th>
                            </tr>
                        </thead>
                        <tbody>
                            <?php foreach($recent_votes as $vote): ?>
                            <tr class="border-t">
                                <td class="px-4 py-2 text-sm"><?= htmlspecialchars($vote['email']) ?></td>
                                <td class="px-4 py-2 text-sm"><?= htmlspecialchars($vote['charity_name']) ?></td>
                                <td class="px-4 py-2 text-sm"><?= date('M j, Y g:i a', strtotime($vote['timestamp'])) ?></td>
                            </tr>
                            <?php endforeach; ?>
                        </tbody>
                    </table>
                </div>
                
                <div class="mt-4">
                    <a href="votes.php" class="text-blue-600 hover:text-blue-800">
                        View all votes →
                    </a>
                </div>
                <?php else: ?>
                <p class="text-gray-600">No votes recorded yet.</p>
                <?php endif; ?>
            </div>
        </div>
        
        <div class="mt-8">
            <div class="bg-white rounded-lg shadow-md p-6">
                <h2 class="text-xl font-semibold text-gray-700 mb-4">Quick Links</h2>
                <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-4">
                    <a href="charities.php" class="bg-blue-600 hover:bg-blue-700 text-white font-semibold px-4 py-2 rounded text-center">
                        Manage Charities
                    </a>
                    <a href="users.php" class="bg-blue-600 hover:bg-blue-700 text-white font-semibold px-4 py-2 rounded text-center">
                        View Users
                    </a>
                    <a href="votes.php" class="bg-blue-600 hover:bg-blue-700 text-white font-semibold px-4 py-2 rounded text-center">
                        View All Votes
                    </a>
                </div>
            </div>
        </div>
    </div>
    
    <footer class="bg-gray-800 text-white py-4 mt-8">
        <div class="container mx-auto px-4 text-center">
            <p>&copy; <?= date('Y') ?> <?= SITE_NAME ?> Admin. All rights reserved.</p>
        </div>
    </footer>
</body>
</html> 