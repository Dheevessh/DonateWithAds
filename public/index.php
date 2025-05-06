<?php
require_once '../includes/config.php';
require_once '../includes/db.php';
require_once '../includes/functions.php';

// Get current vote standings
$vote_counts = get_charity_vote_counts();

include '../includes/header.php';
?>

<style>
.charity-description a {
    color: #2563EB;
    text-decoration: none;
}
.charity-description a:hover {
    text-decoration: underline;
}
</style>

<div class="container mx-auto py-8">
    <!-- Hero Section / Mission Statement -->
    <div class="text-center max-w-4xl mx-auto mb-16">
        <h1 class="text-4xl font-bold text-blue-600 mb-4">Donate While Watching</h1>
        <p class="text-xl text-gray-700 mb-8">
            Donate While Watching is a platform where your attention funds change. Watch short video ads and use your earned vote to support a cause you believe in — it's that simple.
        </p>
        
        <div class="flex justify-center mt-8">
            <a href="vote.php" class="bg-blue-600 hover:bg-blue-700 text-white font-bold py-3 px-6 rounded-lg transition duration-300 transform hover:scale-105">
                Vote Now
            </a>
        </div>
    </div>
    
    <!-- How It Works (Visual Flow Section) -->
    <div class="mt-16 mb-16">
        <h2 class="text-2xl font-bold text-center mb-8">How It Works</h2>
        
        <div class="grid grid-cols-1 md:grid-cols-4 gap-4">
            <div class="bg-white p-6 rounded-lg shadow-md">
                <div class="text-blue-600 text-4xl font-bold mb-4 text-center">1</div>
                <h3 class="text-xl font-semibold mb-2 text-center">Watch Ad</h3>
                <p class="text-gray-700">
                    Visit our voting page and watch a short advertisement.
                </p>
            </div>
            
            <div class="bg-white p-6 rounded-lg shadow-md">
                <div class="text-blue-600 text-4xl font-bold mb-4 text-center">2</div>
                <h3 class="text-xl font-semibold mb-2 text-center">Earn Vote</h3>
                <p class="text-gray-700">
                    After watching an ad, you earn the right to cast your vote.
                </p>
            </div>
            
            <div class="bg-white p-6 rounded-lg shadow-md">
                <div class="text-blue-600 text-4xl font-bold mb-4 text-center">3</div>
                <h3 class="text-xl font-semibold mb-2 text-center">Vote for Charity</h3>
                <p class="text-gray-700">
                    Select which charity you'd like to support with your vote.
                </p>
            </div>
            
            <div class="bg-white p-6 rounded-lg shadow-md">
                <div class="text-blue-600 text-4xl font-bold mb-4 text-center">4</div>
                <h3 class="text-xl font-semibold mb-2 text-center">Charity Receives Funding</h3>
                <p class="text-gray-700">
                    At the end of each month, we donate 50% of ad revenue to the most voted charity.
                </p>
            </div>
        </div>
    </div>
    
    <!-- Impact Tracker (Live Stats) -->
    <div class="mt-16 mb-16 bg-blue-50 p-8 rounded-lg shadow-md">
        <h2 class="text-2xl font-bold text-center mb-4">Our Impact</h2>
        <div class="flex justify-center">
            <div class="text-center">
                <div class="text-4xl font-bold text-blue-600">
                    <?php 
                    // Calculate total votes across all charities
                    $total_all_votes = 0;
                    foreach($vote_counts as $charity) {
                        $total_all_votes += $charity['vote_count'];
                    }
                    echo number_format($total_all_votes);
                    ?>
                </div>
                <p class="text-lg text-gray-700 mt-2">Votes cast so far. Your vote matters.</p>
            </div>
        </div>
    </div>
    
    <!-- Top 3 Most-Voted Charities -->
    <?php if (!empty($vote_counts)): ?>
    <div class="mt-16 mb-16">
        <h2 class="text-2xl font-bold text-center mb-8">Top Voted Charities</h2>
        
        <div class="bg-white p-6 rounded-lg shadow-lg max-w-4xl mx-auto">
            <div class="space-y-4">
                <?php 
                // Calculate total votes for percentage
                $total_votes = 0;
                foreach($vote_counts as $charity) {
                    $total_votes += $charity['vote_count'];
                }
                
                // Get top 3 charities
                $top_charities = array_slice($vote_counts, 0, 3);
                ?>
                
                <?php foreach($top_charities as $index => $charity): 
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
                <?php if ($index < count($top_charities) - 1): ?>
                    <hr class="border-gray-200">
                <?php endif; ?>
                <?php endforeach; ?>
            </div>
            
            <div class="mt-6 text-center">
                <a href="vote.php" class="text-blue-600 hover:text-blue-800 font-semibold">
                    Cast your vote now →
                </a>
            </div>
        </div>
    </div>
    <?php endif; ?>
    
    <!-- Testimonials Section -->
    <div class="mt-16 mb-16">
        <h2 class="text-2xl font-bold text-center mb-8">What Our Users Say</h2>
        
        <div class="grid grid-cols-1 md:grid-cols-2 gap-8 max-w-4xl mx-auto">
            <div class="bg-white p-6 rounded-lg shadow-md">
                <div class="text-gray-700 italic mb-4">
                    "It feels great knowing a few seconds of my time can help feed children in need."
                </div>
                <div class="font-semibold">- Sarah K.</div>
            </div>
            
            <div class="bg-white p-6 rounded-lg shadow-md">
                <div class="text-gray-700 italic mb-4">
                    "I vote every day – it's my routine way to do good."
                </div>
                <div class="font-semibold">- Michael P.</div>
            </div>
        </div>
    </div>
    
    <!-- Call to Action Section -->
    <div class="mt-16 mb-16 bg-blue-600 text-white p-10 rounded-lg shadow-md text-center">
        <h2 class="text-3xl font-bold mb-4">Join thousands making a difference — one ad at a time.</h2>
        <p class="text-xl mb-8">Your clicks fund real change. Start donating today without spending a cent.</p>
        <a href="vote.php" class="bg-white text-blue-600 hover:bg-gray-100 font-bold py-3 px-8 rounded-lg transition duration-300 inline-block">
            Get Started Now
        </a>
    </div>
    
    <!-- Original current standings section -->
    <?php if (!empty($vote_counts) && count($vote_counts) > 3): ?>
    <div class="mt-16">
        <h2 class="text-2xl font-bold text-center mb-8">All Charities Standings</h2>
        
        <div class="bg-white p-6 rounded-lg shadow-lg max-w-2xl mx-auto">
            <div class="space-y-4">
                <?php 
                // Display all charities that weren't in top 3
                $remaining_charities = array_slice($vote_counts, 3);
                foreach($remaining_charities as $index => $charity): 
                    // Calculate percentage
                    $percentage = $total_votes > 0 ? round(($charity['vote_count'] / $total_votes) * 100) : 0;
                    // Ensure bar is at least 5% wide for visibility when there are votes
                    $bar_width = $charity['vote_count'] > 0 ? max(5, $percentage) : 0;
                ?>
                <div>
                    <div class="flex items-center justify-between mb-1">
                        <div class="flex items-center">
                            <span class="text-lg font-semibold"><?= ($index + 4) ?>.</span>
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
                <?php if ($index < count($remaining_charities) - 1): ?>
                    <hr class="border-gray-200">
                <?php endif; ?>
                <?php endforeach; ?>
            </div>
        </div>
    </div>
    <?php endif; ?>
</div>

<?php include '../includes/footer.php'; ?> 