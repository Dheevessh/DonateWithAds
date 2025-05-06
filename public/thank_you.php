<?php
require_once '../includes/config.php';
require_once '../includes/db.php';
require_once '../includes/functions.php';

// Get vote standings
$vote_counts = get_charity_vote_counts();

// Calculate total votes for percentage
$total_votes = 0;
foreach ($vote_counts as $charity) {
    $total_votes += $charity['vote_count'];
}

include '../includes/header.php';
?>

<div class="container mx-auto py-12 text-center">
    <div class="max-w-2xl mx-auto">
        <div class="bg-green-100 text-green-800 p-6 rounded-lg mb-8">
            <h1 class="text-3xl font-bold mb-4">Thank You for Your Vote!</h1>
            <p class="text-xl">
                Your support helps charities make a difference. 50% of all ad revenue will go to the most-voted charity at the end of the month.
            </p>
        </div>
        
        <div class="bg-white p-6 rounded-lg shadow-lg mb-8">
            <h2 class="text-2xl font-bold mb-4">Current Standings</h2>
            
            <div class="space-y-4">
                <?php foreach($vote_counts as $index => $charity): 
                    // Calculate percentage
                    $percentage = $total_votes > 0 ? round(($charity['vote_count'] / $total_votes) * 100) : 0;
                    // Ensure bar is at least 5% wide for visibility when there are votes
                    $bar_width = $charity['vote_count'] > 0 ? max(5, $percentage) : 0;
                ?>
                <div>
                    <div class="flex items-center justify-between mb-1">
                        <div class="flex items-center">
                            <span class="text-lg font-semibold"><?= ($index + 1) ?>.</span>
                            <span class="ml-2 text-lg"><?= htmlspecialchars($charity['name']) ?></span>
                        </div>
                        <div class="text-blue-800 font-semibold">
                            <?= $percentage ?>%
                            <span class="text-xs text-gray-500">(<?= $charity['vote_count'] ?> votes)</span>
                        </div>
                    </div>
                    <div class="w-full bg-gray-200 rounded-full h-2.5">
                        <div class="bg-blue-600 h-2.5 rounded-full" style="width: <?= $bar_width ?>%"></div>
                    </div>
                </div>
                <?php if ($index < count($vote_counts) - 1): ?>
                    <hr class="border-gray-200">
                <?php endif; ?>
                <?php endforeach; ?>
            </div>
        </div>
        
        <div class="flex flex-col sm:flex-row justify-center space-y-4 sm:space-y-0 sm:space-x-4">
            <a href="<?= SITE_URL ?>/public/vote.php" class="bg-blue-600 hover:bg-blue-700 text-white font-bold py-3 px-6 rounded-lg transition duration-300">
                Watch More Ads & Vote Again
            </a>
            <a href="<?= SITE_URL ?>" class="bg-gray-600 hover:bg-gray-700 text-white font-bold py-3 px-6 rounded-lg transition duration-300">
                Return to Home
            </a>
        </div>
        
        <div class="mt-12">
            <h3 class="text-xl font-semibold mb-4">Share With Friends</h3>
            <div class="flex justify-center space-x-4">
                <a href="https://twitter.com/intent/tweet?text=I just voted for a charity on DonateWhileWatching. Watch ads and help charities! <?= urlencode(SITE_URL) ?>" target="_blank" class="bg-blue-400 hover:bg-blue-500 text-white p-3 rounded-full">
                    <svg class="w-6 h-6" fill="currentColor" viewBox="0 0 24 24" aria-hidden="true">
                        <path d="M8.29 20.251c7.547 0 11.675-6.253 11.675-11.675 0-.178 0-.355-.012-.53A8.348 8.348 0 0022 5.92a8.19 8.19 0 01-2.357.646 4.118 4.118 0 001.804-2.27 8.224 8.224 0 01-2.605.996 4.107 4.107 0 00-6.993 3.743 11.65 11.65 0 01-8.457-4.287 4.106 4.106 0 001.27 5.477A4.072 4.072 0 012.8 9.713v.052a4.105 4.105 0 003.292 4.022 4.095 4.095 0 01-1.853.07 4.108 4.108 0 003.834 2.85A8.233 8.233 0 012 18.407a11.616 11.616 0 006.29 1.84"></path>
                    </svg>
                </a>
                <a href="https://www.facebook.com/sharer/sharer.php?u=<?= urlencode(SITE_URL) ?>" target="_blank" class="bg-blue-600 hover:bg-blue-700 text-white p-3 rounded-full">
                    <svg class="w-6 h-6" fill="currentColor" viewBox="0 0 24 24" aria-hidden="true">
                        <path fill-rule="evenodd" d="M22 12c0-5.523-4.477-10-10-10S2 6.477 2 12c0 4.991 3.657 9.128 8.438 9.878v-6.987h-2.54V12h2.54V9.797c0-2.506 1.492-3.89 3.777-3.89 1.094 0 2.238.195 2.238.195v2.46h-1.26c-1.243 0-1.63.771-1.63 1.562V12h2.773l-.443 2.89h-2.33v6.988C18.343 21.128 22 16.991 22 12z" clip-rule="evenodd"></path>
                    </svg>
                </a>
                <a href="mailto:?subject=Help charities while watching ads&body=Check out DonateWhileWatching - a website where you can support charities by watching ads: <?= SITE_URL ?>" class="bg-red-500 hover:bg-red-600 text-white p-3 rounded-full">
                    <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 8l7.89 5.26a2 2 0 002.22 0L21 8M5 19h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v10a2 2 0 002 2z"></path>
                    </svg>
                </a>
            </div>
        </div>
    </div>
</div>

<?php include '../includes/footer.php'; ?>

<style>
.charity-description a {
    color: #2563EB;
    text-decoration: none;
}
.charity-description a:hover {
    text-decoration: underline;
}
</style> 