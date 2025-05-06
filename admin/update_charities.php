<?php
require_once 'auth_check.php';
require_once '../includes/db.php';

// Set page title
$page_title = "Update Charities";
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title><?= $page_title ?> - <?= SITE_NAME ?> Admin</title>
    <link href="https://cdn.jsdelivr.net/npm/tailwindcss@2.2.19/dist/tailwind.min.css" rel="stylesheet">
    <style>
        pre {
            background-color: #f5f5f5;
            padding: 1rem;
            border-radius: 0.5rem;
            font-family: monospace;
            white-space: pre-wrap;
            word-break: break-all;
        }
    </style>
</head>
<body class="bg-gray-100 min-h-screen">
    <?php include 'nav.php'; ?>
    
    <div class="container mx-auto px-4 py-8">
        <div class="mb-8">
            <h1 class="text-3xl font-bold"><?= $page_title ?></h1>
            <p class="text-gray-600">Replacing existing charities with new charity list</p>
        </div>
        
        <div class="bg-white rounded-lg shadow-md p-6 mb-6">
            <h2 class="text-xl font-semibold mb-4">Update Process Results</h2>
            
            <pre class="mb-6"><?php
// Capture output
ob_start();

try {
    // Connect to database
    $conn = connect_db();
    
    // Read the SQL file
    $sql_file = file_get_contents('../sql/update_charities.sql');
    
    // Split the SQL commands
    $queries = explode(';', $sql_file);
    
    // Execute each query
    foreach($queries as $query) {
        $query = trim($query);
        
        // Skip empty queries
        if(empty($query)) {
            continue;
        }
        
        echo "Executing: " . substr($query, 0, 50) . "...\n";
        
        if($conn->query($query)) {
            echo "Success!\n";
        } else {
            echo "Error: " . $conn->error . "\n";
        }
    }
    
    // Close connection
    $conn->close();
    
    echo "\nCharity update completed successfully!";
    
} catch (Exception $e) {
    echo "Error: " . $e->getMessage() . "\n";
}

// Get output
echo ob_get_clean();
?></pre>
            
            <div class="flex justify-center">
                <a href="charities.php" class="bg-blue-600 hover:bg-blue-700 text-white font-bold py-2 px-4 rounded">
                    View Updated Charities
                </a>
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