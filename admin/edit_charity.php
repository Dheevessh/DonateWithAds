<?php
require_once 'auth_check.php';
require_once '../includes/db.php';

// Check if charity ID is provided
if (!isset($_GET['id']) || empty($_GET['id'])) {
    set_flash_message('error', 'Invalid charity ID');
    redirect(SITE_URL . '/admin/charities.php');
}

$charity_id = (int)$_GET['id'];

// Get charity data
$conn = connect_db();
$stmt = $conn->prepare("SELECT * FROM charities WHERE id = ?");
$stmt->bind_param("i", $charity_id);
$stmt->execute();
$result = $stmt->get_result();

if ($result->num_rows === 0) {
    $stmt->close();
    $conn->close();
    
    set_flash_message('error', 'Charity not found');
    redirect(SITE_URL . '/admin/charities.php');
}

$charity = $result->fetch_assoc();
$stmt->close();

// Process form submission
$error = '';
$success = false;

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    // Get form data
    $name = isset($_POST['name']) ? sanitize($_POST['name']) : '';
    $description = isset($_POST['description']) ? $_POST['description'] : '';
    $image_url = isset($_POST['image_url']) ? sanitize($_POST['image_url']) : '';
    
    // Validate form data
    if (empty($name)) {
        $error = 'Charity name is required';
    } elseif (empty($description)) {
        $error = 'Charity description is required';
    } else {
        // Default image if none provided
        if (empty($image_url)) {
            $image_url = 'images/charity-default.jpg';
        }
        
        // Update charity
        $stmt = $conn->prepare("UPDATE charities SET name = ?, description = ?, image_url = ? WHERE id = ?");
        $stmt->bind_param("sssi", $name, $description, $image_url, $charity_id);
        
        if ($stmt->execute()) {
            $success = true;
            
            // Update charity data for display
            $charity['name'] = $name;
            $charity['description'] = $description;
            $charity['image_url'] = $image_url;
            
            // Set success message
            set_flash_message('success', 'Charity updated successfully');
            
            // Redirect to charities list
            redirect(SITE_URL . '/admin/charities.php');
        } else {
            $error = 'Failed to update charity: ' . $stmt->error;
        }
        
        $stmt->close();
    }
}

$conn->close();

// Get flash message
$flash = get_flash_message();
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Edit Charity - <?= SITE_NAME ?> Admin</title>
    <link href="https://cdn.jsdelivr.net/npm/tailwindcss@2.2.19/dist/tailwind.min.css" rel="stylesheet">
</head>
<body class="bg-gray-100 min-h-screen">
    <?php include 'nav.php'; ?>
    
    <div class="container mx-auto px-4 py-8">
        <div class="mb-8">
            <h1 class="text-3xl font-bold">Edit Charity</h1>
            <p class="text-gray-600">Update charity details</p>
        </div>
        
        <?php if ($flash): ?>
        <div class="alert alert-<?= $flash['type'] ?> p-4 mb-6 rounded <?= $flash['type'] === 'success' ? 'bg-green-100 text-green-800' : 'bg-red-100 text-red-800' ?>">
            <?= $flash['message'] ?>
        </div>
        <?php endif; ?>
        
        <?php if ($error): ?>
        <div class="bg-red-100 text-red-800 p-4 mb-6 rounded">
            <?= $error ?>
        </div>
        <?php endif; ?>
        
        <div class="bg-white rounded-lg shadow-md p-6">
            <form method="post" action="">
                <div class="mb-4">
                    <label for="name" class="block text-gray-700 font-medium mb-2">Charity Name *</label>
                    <input type="text" id="name" name="name" required 
                        class="w-full px-3 py-2 border border-gray-300 rounded-md focus:outline-none focus:ring-2 focus:ring-blue-500"
                        value="<?= htmlspecialchars($charity['name']) ?>">
                </div>
                
                <div class="mb-4">
                    <label for="description" class="block text-gray-700 font-medium mb-2">Description *</label>
                    <textarea id="description" name="description" rows="4" required 
                        class="w-full px-3 py-2 border border-gray-300 rounded-md focus:outline-none focus:ring-2 focus:ring-blue-500"><?= $charity['description'] ?></textarea>
                    <p class="text-gray-500 text-sm mt-1">HTML is allowed for formatting and links</p>
                </div>
                
                <div class="mb-6">
                    <label for="image_url" class="block text-gray-700 font-medium mb-2">Image URL</label>
                    <input type="url" id="image_url" name="image_url" 
                        class="w-full px-3 py-2 border border-gray-300 rounded-md focus:outline-none focus:ring-2 focus:ring-blue-500"
                        value="<?= htmlspecialchars($charity['image_url']) ?>">
                    <p class="text-gray-500 text-sm mt-1">Leave empty to use default image</p>
                </div>
                
                <div class="mb-6">
                    <h3 class="text-lg font-semibold mb-2">Current Image Preview</h3>
                    <img src="<?= htmlspecialchars($charity['image_url']) ?>" alt="<?= htmlspecialchars($charity['name']) ?>" 
                        class="max-h-40 object-cover rounded border border-gray-300" 
                        onerror="this.src='https://via.placeholder.com/400x200?text=<?= urlencode($charity['name']) ?>'">
                </div>
                
                <div class="flex justify-between">
                    <a href="charities.php" class="bg-gray-500 hover:bg-gray-600 text-white font-bold py-2 px-4 rounded">
                        Cancel
                    </a>
                    <button type="submit" class="bg-blue-600 hover:bg-blue-700 text-white font-bold py-2 px-4 rounded">
                        Update Charity
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