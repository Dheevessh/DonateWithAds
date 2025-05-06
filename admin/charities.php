<?php
require_once 'auth_check.php';
require_once '../includes/db.php';

// Get all charities
$charities = get_charities();

// Get vote counts
$vote_counts = [];
$vote_count_data = get_charity_vote_counts();
foreach ($vote_count_data as $charity) {
    $vote_counts[$charity['id']] = $charity['vote_count'];
}

// Process delete action
if (isset($_GET['action']) && $_GET['action'] === 'delete' && isset($_GET['id'])) {
    $charity_id = (int)$_GET['id'];
    
    $conn = connect_db();
    
    // Begin transaction
    $conn->begin_transaction();
    
    try {
        // Delete related votes first
        $stmt = $conn->prepare("DELETE FROM votes WHERE charity_id = ?");
        $stmt->bind_param("i", $charity_id);
        $stmt->execute();
        $stmt->close();
        
        // Delete charity
        $stmt = $conn->prepare("DELETE FROM charities WHERE id = ?");
        $stmt->bind_param("i", $charity_id);
        $stmt->execute();
        $stmt->close();
        
        // Commit transaction
        $conn->commit();
        $conn->close();
        
        // Set success message
        set_flash_message('success', 'Charity deleted successfully');
        
        // Redirect to refresh the page
        redirect(SITE_URL . '/admin/charities.php');
        
    } catch (Exception $e) {
        // Rollback transaction on error
        $conn->rollback();
        $conn->close();
        
        // Set error message
        set_flash_message('error', 'An error occurred: ' . $e->getMessage());
        
        // Redirect
        redirect(SITE_URL . '/admin/charities.php');
    }
}

// Get flash message
$flash = get_flash_message();
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Manage Charities - <?= SITE_NAME ?> Admin</title>
    <link href="https://cdn.jsdelivr.net/npm/tailwindcss@2.2.19/dist/tailwind.min.css" rel="stylesheet">
</head>
<body class="bg-gray-100 min-h-screen">
    <?php include 'nav.php'; ?>
    
    <div class="container mx-auto px-4 py-8">
        <div class="flex justify-between items-center mb-8">
            <h1 class="text-3xl font-bold">Manage Charities</h1>
            <a href="add_charity.php" class="bg-green-600 hover:bg-green-700 text-white font-bold py-2 px-4 rounded">
                Add New Charity
            </a>
        </div>
        
        <?php if ($flash): ?>
        <div class="alert alert-<?= $flash['type'] ?> p-4 mb-6 rounded <?= $flash['type'] === 'success' ? 'bg-green-100 text-green-800' : 'bg-red-100 text-red-800' ?>">
            <?= $flash['message'] ?>
        </div>
        <?php endif; ?>
        
        <div class="bg-white rounded-lg shadow-md overflow-hidden">
            <?php if (count($charities) > 0): ?>
            <table class="min-w-full">
                <thead>
                    <tr class="bg-gray-200">
                        <th class="px-6 py-3 text-left text-gray-700">ID</th>
                        <th class="px-6 py-3 text-left text-gray-700">Name</th>
                        <th class="px-6 py-3 text-left text-gray-700">Description</th>
                        <th class="px-6 py-3 text-left text-gray-700">Image</th>
                        <th class="px-6 py-3 text-left text-gray-700">Votes</th>
                        <th class="px-6 py-3 text-left text-gray-700">Actions</th>
                    </tr>
                </thead>
                <tbody class="divide-y divide-gray-200">
                    <?php foreach($charities as $charity): ?>
                    <tr class="hover:bg-gray-50">
                        <td class="px-6 py-4"><?= $charity['id'] ?></td>
                        <td class="px-6 py-4 font-medium"><?= htmlspecialchars($charity['name']) ?></td>
                        <td class="px-6 py-4">
                            <div class="max-w-xs truncate"><?= strip_tags($charity['description']) ?></div>
                        </td>
                        <td class="px-6 py-4">
                            <img src="<?= htmlspecialchars($charity['image_url']) ?>" alt="<?= htmlspecialchars($charity['name']) ?>" 
                                class="h-10 w-16 object-cover rounded" 
                                onerror="this.src='https://via.placeholder.com/160x100?text=<?= urlencode($charity['name']) ?>'">
                        </td>
                        <td class="px-6 py-4">
                            <span class="bg-blue-100 text-blue-800 px-2 py-1 rounded-full text-sm">
                                <?= isset($vote_counts[$charity['id']]) ? $vote_counts[$charity['id']] : 0 ?>
                            </span>
                        </td>
                        <td class="px-6 py-4">
                            <div class="flex space-x-2">
                                <a href="edit_charity.php?id=<?= $charity['id'] ?>" class="text-blue-600 hover:text-blue-800">
                                    Edit
                                </a>
                                <a href="charities.php?action=delete&id=<?= $charity['id'] ?>" 
                                   class="text-red-600 hover:text-red-800"
                                   onclick="return confirm('Are you sure you want to delete this charity? All related votes will also be deleted.')">
                                    Delete
                                </a>
                            </div>
                        </td>
                    </tr>
                    <?php endforeach; ?>
                </tbody>
            </table>
            <?php else: ?>
            <div class="p-6 text-center text-gray-600">
                No charities found. <a href="add_charity.php" class="text-blue-600 hover:text-blue-800">Add one now</a>.
            </div>
            <?php endif; ?>
        </div>
    </div>
    
    <footer class="bg-gray-800 text-white py-4 mt-8">
        <div class="container mx-auto px-4 text-center">
            <p>&copy; <?= date('Y') ?> <?= SITE_NAME ?> Admin. All rights reserved.</p>
        </div>
    </footer>
</body>
</html> 