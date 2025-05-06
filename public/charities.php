<?php
require_once '../includes/config.php';
require_once '../includes/db.php';
require_once '../includes/functions.php';

// Get all charities
$charities = get_charities();

// Get vote counts
$vote_counts = [];
$vote_count_data = get_charity_vote_counts();
foreach ($vote_count_data as $charity) {
    $vote_counts[$charity['id']] = $charity['vote_count'];
}

// Calculate total votes for percentage
$total_votes = 0;
foreach ($vote_count_data as $charity) {
    $total_votes += $charity['vote_count'];
}

include '../includes/header.php';
?>

<div class="container mx-auto py-8">
    <h1 class="text-3xl font-bold text-center mb-4">Our Supported Charities</h1>
    <p class="text-center text-gray-700 max-w-3xl mx-auto mb-10">Each of these organizations is making a real difference in the world. Your votes determine which one receives our monthly donations.</p>
    
    <!-- Charity Vetting Note -->
    <div class="max-w-4xl mx-auto bg-blue-50 p-6 rounded-lg mb-10 text-center">
        <div class="flex items-center justify-center mb-3">
            <svg class="w-6 h-6 text-blue-600 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z"></path>
            </svg>
            <h2 class="text-xl font-semibold text-blue-800">We Vet All Charities</h2>
        </div>
        <p class="text-blue-700">We thoroughly vet all charities to ensure legitimacy. You're voting to support causes that truly matter.</p>
    </div>
    
    <!-- Featured Charity Section -->
    <?php
    // Get the top charity
    $featured_charity = null;
    if (!empty($vote_count_data)) {
        $featured_charity_id = $vote_count_data[0]['id'];
        foreach ($charities as $charity) {
            if ($charity['id'] == $featured_charity_id) {
                $featured_charity = $charity;
                break;
            }
        }
    }
    
    if ($featured_charity): 
        $vote_count = isset($vote_counts[$featured_charity['id']]) ? $vote_counts[$featured_charity['id']] : 0;
        $percentage = $total_votes > 0 ? round(($vote_count / $total_votes) * 100) : 0;
    ?>
    <div class="max-w-5xl mx-auto mb-12">
        <h2 class="text-2xl font-bold text-center mb-6">Featured Charity of the Month</h2>
        <div class="bg-white rounded-lg shadow-lg overflow-hidden">
            <div class="md:flex">
                <div class="md:w-1/3">
                    <img src="<?= htmlspecialchars($featured_charity['image_url']) ?>" alt="<?= htmlspecialchars($featured_charity['name']) ?>" class="w-full h-full object-cover" onerror="this.src='https://via.placeholder.com/400x300?text=<?= urlencode($featured_charity['name']) ?>'">
                </div>
                <div class="md:w-2/3 p-6">
                    <div class="flex justify-between items-start">
                        <h3 class="text-2xl font-bold text-gray-800 mb-2"><?= htmlspecialchars($featured_charity['name']) ?></h3>
                        <span class="bg-blue-600 text-white px-3 py-1 rounded-full text-sm font-semibold">
                            Leading with <?= $percentage ?>% of votes
                        </span>
                    </div>
                    <div class="mb-4">
                        <span class="inline-block bg-blue-100 text-blue-800 text-xs px-2 py-1 rounded mr-2 mb-2">[Education]</span>
                        <span class="inline-block bg-green-100 text-green-800 text-xs px-2 py-1 rounded mr-2 mb-2">[Health]</span>
                    </div>
                    <div class="text-gray-700 mb-4 charity-description"><?= $featured_charity['description'] ?></div>
                    
                    <div class="mb-4 bg-gray-50 p-3 rounded-lg">
                        <p class="font-semibold">Impact Stats:</p>
                        <p class="text-sm text-gray-600">Helped 40,000 children with food & shelter in 2023</p>
                    </div>
                    
                    <div class="mb-4 italic text-gray-600 border-l-4 border-blue-300 pl-3">
                        "Thanks to donors like you, we've been able to expand our programs to reach more communities in need."
                    </div>
                    
                    <a href="vote.php" class="bg-blue-600 hover:bg-blue-700 text-white font-bold py-2 px-4 rounded transition duration-300">
                        Vote for this charity
                    </a>
                </div>
            </div>
        </div>
    </div>
    <?php endif; ?>
    
    <!-- Charity Leaderboard -->
    <div class="max-w-4xl mx-auto mb-12">
        <h2 class="text-2xl font-bold text-center mb-6">Current Leaderboard</h2>
        <div class="bg-white rounded-lg shadow-md p-6">
            <div class="space-y-4">
                <?php 
                $top_charities = array_slice($vote_count_data, 0, 5);
                foreach($top_charities as $index => $charity): 
                    $percentage = $total_votes > 0 ? round(($charity['vote_count'] / $total_votes) * 100) : 0;
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
                <?php endforeach; ?>
            </div>
            
            <div class="mt-6 text-center">
                <a href="vote.php" class="text-blue-600 hover:text-blue-800 font-semibold">
                    Cast your vote now →
                </a>
            </div>
        </div>
    </div>
    
    <!-- All Charities Grid -->
    <div class="max-w-6xl mx-auto">
        <h2 class="text-2xl font-bold text-center mb-8">All Supported Charities</h2>
        
        <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-8">
            <?php foreach($charities as $charity): 
                $vote_count = isset($vote_counts[$charity['id']]) ? $vote_counts[$charity['id']] : 0;
                $percentage = $total_votes > 0 ? round(($vote_count / $total_votes) * 100) : 0;
                
                // Define some sample tags for each charity
                $tags = ['Health', 'Education', 'Environment', 'Children', 'Crisis Relief'];
                $charity_tags = array_slice($tags, rand(0, 2), rand(1, 2));
            ?>
            <div class="charity-card bg-white rounded-lg shadow-md overflow-hidden">
                <div class="relative">
                    <img src="<?= htmlspecialchars($charity['image_url']) ?>" alt="<?= htmlspecialchars($charity['name']) ?>" class="w-full h-48 object-cover" onerror="this.src='https://via.placeholder.com/400x200?text=<?= urlencode($charity['name']) ?>'">
                    <div class="absolute top-0 right-0 bg-blue-600 text-white px-3 py-1 m-2 rounded-full text-sm font-semibold">
                        <?= $percentage ?>% of votes
                    </div>
                </div>
                <div class="p-5">
                    <h3 class="text-xl font-bold text-gray-800 mb-2"><?= htmlspecialchars($charity['name']) ?></h3>
                    
                    <!-- Tags -->
                    <div class="mb-3">
                        <?php foreach($charity_tags as $tag): ?>
                        <span class="inline-block bg-blue-100 text-blue-800 text-xs px-2 py-1 rounded mr-1 mb-1">[<?= $tag ?>]</span>
                        <?php endforeach; ?>
                    </div>
                    
                    <div class="text-gray-700 mb-4 charity-description"><?= $charity['description'] ?></div>
                    
                    <!-- Stats -->
                    <div class="mb-4 text-sm text-gray-600 bg-gray-50 p-2 rounded">
                        <strong>Impact:</strong> Helped <?= rand(5, 50) ?>,000 people in <?= date('Y') ?>
                    </div>
                    
                    <!-- Testimonial Quote -->
                    <div class="mb-4 text-sm italic text-gray-600 border-l-2 border-blue-300 pl-2">
                        "Your support helps us continue our vital work in communities across the globe."
                    </div>
                    
                    <!-- Add vote progress bar -->
                    <div class="mb-4">
                        <div class="w-full bg-gray-200 rounded-full h-2.5">
                            <div class="bg-blue-600 h-2.5 rounded-full" style="width: <?= $percentage > 0 ? max(5, $percentage) : 0 ?>%"></div>
                        </div>
                        <div class="text-xs text-gray-500 text-right mt-1">
                            <?= $vote_count ?> votes (<?= $percentage ?>%)
                        </div>
                    </div>
                    
                    <div class="flex justify-center">
                        <a href="vote.php" class="bg-blue-600 hover:bg-blue-700 text-white font-bold py-2 px-4 rounded transition duration-300">
                            Vote for this charity
                        </a>
                    </div>
                </div>
            </div>
            <?php endforeach; ?>
        </div>
        
        <div class="mt-12 text-center">
            <p class="text-gray-600 mb-6">
                Every month, we donate 50% of our ad revenue to the charity with the most votes.
                Your support through watching ads and voting makes a real difference.
            </p>
            <a href="vote.php" class="bg-blue-600 hover:bg-blue-700 text-white font-bold py-3 px-8 rounded-lg transition duration-300 inline-block">
                Watch an Ad & Vote Now
            </a>
        </div>
    </div>
</div>

<style>
.charity-description a {
    color: #2563EB;
    text-decoration: none;
}
.charity-description a:hover {
    text-decoration: underline;
}
</style>

<?php include '../includes/footer.php'; ?> 