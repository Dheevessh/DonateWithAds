<?php
// Database Configuration
define('DB_HOST', 'localhost');
define('DB_USER', 'u419390408_user'); // Update these with your actual database credentials
define('DB_PASS', 'D$12345d');
define('DB_NAME', 'u419390408_User');

// Site Configuration
define('SITE_NAME', 'DonateWhileWatching');
define('SITE_URL', 'https://donatewhilewatching.com'); // Update with your actual site URL
define('AD_WATCH_INTERVAL', 10); // Minutes between allowed votes
define('VOTES_PER_USER', 3); // Number of ads to watch before allowing a vote
define('FIRST_TIME_VOTES', 1); // First-time users only need to watch this many ads

// Session Configuration
session_start();

// Error Reporting (disable in production)
ini_set('display_errors', 1);
error_reporting(E_ALL);
?> 