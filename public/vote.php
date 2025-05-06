<?php
require_once '../includes/config.php';
require_once '../includes/db.php';
require_once '../includes/functions.php';

// Get all charities
$charities = get_charities();

// Check if user is logged in
$user_can_vote = false;
if (is_user_logged_in()) {
    // Check if user can vote
    $user_can_vote = can_user_vote($_SESSION['user_id']);
}

// Get vote counts for stats
$vote_counts = get_charity_vote_counts();
$total_votes = 0;
foreach ($vote_counts as $charity) {
    $total_votes += $charity['vote_count'];
}

include '../includes/header.php';
?>

<div class="container mx-auto py-8">
    <h1 class="text-3xl font-bold text-center mb-8">Vote for a Charity</h1>
    
    <div class="max-w-4xl mx-auto">
        <!-- Mission Message -->
        <div class="bg-blue-50 p-6 rounded-lg mb-8 text-center">
            <h2 class="text-xl font-semibold text-blue-800 mb-2">Watch a short message to earn your vote and support a cause you care about.</h2>
            <p class="text-blue-700">Your attention directly funds charitable donations. It's that simple.</p>
        </div>
    
        <!-- Top Interstitial Ad -->
        <div class="mb-10 ad-container-top">
            <div class="bg-gray-100 p-2 text-center text-xs text-gray-500 mb-1">Advertisement</div>
            <ins class="adsbygoogle"
                style="display:block; text-align:center;"
                data-ad-client="ca-pub-6540350978839257"
                data-ad-slot="YOUR_SLOT_ID_1"
                data-ad-format="auto"
                data-full-width-responsive="true"></ins>
            <script>(adsbygoogle = window.adsbygoogle || []).push({});</script>
        </div>
        
        <!-- "Why Your Vote Matters" Content Block -->
        <div class="bg-white p-6 rounded-lg shadow-md mb-8">
            <h2 class="text-xl font-semibold text-blue-700 mb-4">Why Your Vote Matters</h2>
            <p class="text-gray-700 mb-4">Every ad you view sends real funds to real charities. You're part of a bigger mission.</p>
            
            <!-- Dynamic Statistics Card -->
            <div class="bg-blue-50 p-4 rounded-lg mb-4">
                <h3 class="font-semibold text-blue-800 mb-2">Your Impact</h3>
                <p class="text-blue-700">This month: <span class="font-bold"><?= number_format($total_votes) ?></span> ads watched = <span class="font-bold">$<?= number_format($total_votes * 0.08, 2) ?></span> raised for charity.</p>
            </div>
            
            <div class="flex justify-center">
                <a href="charities.php" class="text-blue-600 hover:text-blue-800 font-semibold">
                    Learn more about our featured charities →
                </a>
            </div>
        </div>
    
        <!-- Primary Ad Section -->
        <div class="mb-10">
            <h2 class="text-xl font-semibold mb-4">Step 1: Watch the Ad</h2>
            
            <div id="ad-container" class="ad-container mb-4">
                <div class="ad-placeholder">
                    <ins class="adsbygoogle"
                        style="display:block"
                        data-ad-client="ca-pub-6540350978839257"
                        data-ad-slot="YOUR_SLOT_ID_2"
                        data-ad-format="auto"
                        data-full-width-responsive="true"></ins>
                    <script>(adsbygoogle = window.adsbygoogle || []).push({});</script>
                </div>
                <div class="p-4">
                    <p class="text-center text-gray-700 mb-2">Please watch the entire advertisement</p>
                    <div class="ad-progress-container">
                        <div id="ad-progress-bar" class="ad-progress-bar"></div>
                    </div>
                </div>
            </div>
            
            <!-- Fallback message (shown if ad doesn't load) -->
            <div id="ad-fallback" class="bg-gray-50 p-6 rounded-lg mb-6" style="display: none;">
                <h3 class="font-semibold text-lg text-gray-800 mb-2">Preparing your impact journey… Hang tight!</h3>
                <p class="text-gray-700 mb-4">Meanwhile, meet our Featured Charities of the Month:</p>
                <div class="grid grid-cols-1 md:grid-cols-3 gap-4">
                    <?php foreach(array_slice($charities, 0, 3) as $charity): ?>
                    <div class="bg-white p-3 rounded shadow-sm">
                        <div class="font-semibold"><?= htmlspecialchars($charity['name']) ?></div>
                        <div class="text-xs text-gray-600 truncate"><?= substr(strip_tags($charity['description']), 0, 60) ?>...</div>
                    </div>
                    <?php endforeach; ?>
                </div>
            </div>

            <?php 
            // Always set ads_needed to 1
            $ads_needed = 1;
            $ads_watched = 0;
            
            if (is_user_logged_in()) {
                $conn = connect_db();
                $stmt = $conn->prepare("SELECT ads_watched, last_voted FROM users WHERE id = ?");
                $stmt->bind_param("i", $_SESSION['user_id']);
                $stmt->execute();
                $result = $stmt->get_result();
                
                if ($result->num_rows > 0) {
                    $user = $result->fetch_assoc();
                    $ads_watched = $user['ads_watched'];
                }
                
                $stmt->close();
                $conn->close();
            }
            ?>

            <div class="bg-blue-50 p-4 rounded-md mb-6">
                <div class="flex justify-between items-center">
                    <div>
                        <p class="text-blue-800 font-semibold">Ads Watched: <span id="ads-count"><?= $ads_watched ?></span></p>
                        <p class="text-sm text-blue-600">
                            Watch one ad to earn one vote. Each ad you watch lets you support your favorite charity!
                        </p>
                    </div>
                    <div class="w-24 h-24 relative">
                        <svg class="w-full h-full" viewBox="0 0 100 100">
                            <circle cx="50" cy="50" r="45" fill="none" stroke="#e2e8f0" stroke-width="6"></circle>
                            <circle id="progress-circle" cx="50" cy="50" r="45" fill="none" stroke="#3b82f6" stroke-width="6" stroke-dasharray="283" stroke-dashoffset="<?= $ads_watched > 0 ? 0 : 283 ?>" transform="rotate(-90 50 50)"></circle>
                        </svg>
                        <div class="absolute top-0 left-0 w-full h-full flex items-center justify-center">
                            <span class="text-lg font-bold" id="progress-percentage"><?= $ads_watched > 0 ? 100 : 0 ?>%</span>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <!-- Secondary Ad Placement - Banner -->
        <div class="mb-8 ad-banner-container">
            <div class="bg-gray-100 p-2 text-center text-xs text-gray-500 mb-1">Advertisement</div>
            <ins class="adsbygoogle"
                style="display:block; text-align:center;"
                data-ad-client="ca-pub-6540350978839257"
                data-ad-slot="YOUR_SLOT_ID_3"
                data-ad-format="auto"
                data-full-width-responsive="true"></ins>
            <script>(adsbygoogle = window.adsbygoogle || []).push({});</script>
        </div>
        
        <!-- Sidebar Content -->
        <div class="grid grid-cols-1 lg:grid-cols-3 gap-8 mb-8">
            <div class="lg:col-span-2">
                <h2 class="text-xl font-semibold mb-4">Step 2: Select a Charity to Support</h2>
                
                <form id="charity-form" action="process_vote.php" method="post">
                    <div class="grid grid-cols-1 md:grid-cols-2 gap-6 charity-list">
                        <?php foreach($charities as $index => $charity): ?>
                        <div class="charity-card bg-white rounded-lg shadow-md overflow-hidden">
                            <div class="relative">
                                <img src="<?= htmlspecialchars($charity['image_url']) ?>" alt="<?= htmlspecialchars($charity['name']) ?>" class="w-full h-40 object-cover" onerror="this.src='https://via.placeholder.com/300x150?text=<?= urlencode($charity['name']) ?>'">
                                <div class="absolute bottom-0 left-0 right-0 bg-gradient-to-t from-black to-transparent p-3">
                                    <h3 class="text-white font-bold text-lg"><?= htmlspecialchars($charity['name']) ?></h3>
                                </div>
                            </div>
                            <div class="p-4">
                                <div class="text-gray-700 text-sm mb-4 charity-description"><?= $charity['description'] ?></div>
                                <div>
                                    <label class="flex items-center space-x-3">
                                        <input type="radio" name="charity_id" value="<?= $charity['id'] ?>" class="form-radio charity-option" required>
                                        <span class="text-gray-800">Select this charity</span>
                                    </label>
                                </div>
                            </div>
                        </div>
                        
                        <?php if (($index + 1) % 3 === 0 && $index < count($charities) - 1): ?>
                        <div class="col-span-full md:col-span-1 mb-4 ad-sidebar-container">
                            <div class="bg-gray-100 p-2 text-center text-xs text-gray-500 mb-1">Advertisement</div>
                            <ins class="adsbygoogle"
                                style="display:block; text-align:center;"
                                data-ad-client="ca-pub-6540350978839257"
                                data-ad-slot="YOUR_SLOT_ID_5"
                                data-ad-format="auto"
                                data-full-width-responsive="true"></ins>
                            <script>(adsbygoogle = window.adsbygoogle || []).push({});</script>
                        </div>
                        <?php endif; ?>
                        <?php endforeach; ?>
                    </div>

                    <div class="mt-8 text-center">
                        <button id="vote-btn" type="submit" class="vote-btn bg-gray-400 text-white font-bold py-3 px-8 rounded-lg opacity-50 cursor-not-allowed" disabled>
                            Submit Your Vote
                        </button>
                        <p class="mt-2 text-sm text-gray-600">Watch the entire ad to enable voting</p>
                    </div>
                </form>
            </div>
            
            <!-- Right sidebar with featured content -->
            <div class="lg:col-span-1">
                <div class="bg-white rounded-lg shadow-md p-4 mb-6">
                    <h3 class="text-lg font-semibold mb-3 text-blue-700">Featured Charities</h3>
                    <div class="space-y-3">
                        <?php foreach(array_slice($charities, 0, 3) as $charity): ?>
                        <div class="border-b pb-2">
                            <div class="font-medium"><?= htmlspecialchars($charity['name']) ?></div>
                            <div class="text-xs text-gray-600"><?= substr(strip_tags($charity['description']), 0, 80) ?>...</div>
                        </div>
                        <?php endforeach; ?>
                    </div>
                </div>
                
                <div class="bg-white rounded-lg shadow-md p-4 mb-6">
                    <h3 class="text-lg font-semibold mb-3 text-blue-700">Leaderboard</h3>
                    <div class="space-y-2">
                        <?php foreach(array_slice($vote_counts, 0, 5) as $index => $charity): ?>
                        <div class="flex justify-between items-center">
                            <span><?= ($index + 1) ?>. <?= htmlspecialchars($charity['name']) ?></span>
                            <span class="text-blue-600 font-semibold"><?= $charity['vote_count'] ?> votes</span>
                        </div>
                        <?php endforeach; ?>
                    </div>
                </div>
                
                <div class="bg-white rounded-lg shadow-md p-4">
                    <h3 class="text-lg font-semibold mb-3 text-blue-700">User Testimonials</h3>
                    <div class="italic text-gray-700 text-sm mb-3">
                        "I vote every day during my lunch break. It's such an easy way to contribute." - Mark D.
                    </div>
                    <div class="italic text-gray-700 text-sm">
                        "This platform makes giving back accessible to everyone." - Julie T.
                    </div>
                </div>
                
                <!-- Floating Side Ad -->
                <div class="hidden lg:block mt-6 ad-floating-container">
                    <div class="bg-gray-100 p-2 text-center text-xs text-gray-500 mb-1">Ad</div>
                    <ins class="adsbygoogle"
                        style="display:inline-block;width:250px;height:500px"
                        data-ad-client="ca-pub-6540350978839257"
                        data-ad-slot="YOUR_SLOT_ID_4"></ins>
                    <script>(adsbygoogle = window.adsbygoogle || []).push({});</script>
                </div>
            </div>
        </div>

        <!-- Bottom Banner Ad -->
        <div class="my-8 ad-banner-container">
            <div class="bg-gray-100 p-2 text-center text-xs text-gray-500 mb-1">Advertisement</div>
            <ins class="adsbygoogle"
                style="display:block; text-align:center;"
                data-ad-client="ca-pub-6540350978839257"
                data-ad-slot="YOUR_SLOT_ID_6"
                data-ad-format="auto"
                data-full-width-responsive="true"></ins>
            <script>(adsbygoogle = window.adsbygoogle || []).push({});</script>
        </div>
    </div>
</div>

<!-- Email Collection Modal -->
<div id="email-modal" class="modal">
    <div class="modal-content">
        <span class="close-modal">&times;</span>
        <h2 class="text-xl font-bold mb-4">Please Enter Your Email</h2>
        <p class="mb-4 text-gray-700">
            Entering your email helps us track votes and prevents duplication.
            We'll never share your email with third parties.
        </p>
        
        <form id="email-form">
            <div class="mb-4">
                <label for="email" class="block text-gray-700 font-medium mb-2">Email Address</label>
                <input type="email" id="email" name="email" 
                    class="w-full px-3 py-2 border border-gray-300 rounded-md focus:outline-none focus:ring-2 focus:ring-blue-500">
            </div>
            
            <div class="flex justify-between items-center">
                <button type="button" id="skip-email-btn" class="text-gray-600 hover:text-gray-800">
                    Continue without email
                </button>
                <button type="submit" class="bg-blue-600 hover:bg-blue-700 text-white font-bold py-2 px-6 rounded-md">
                    Submit
                </button>
            </div>
        </form>
    </div>
</div>

<script>
// Add script to show fallback if ads don't load
window.addEventListener('load', function() {
    setTimeout(function() {
        var adContainer = document.querySelector('.ad-placeholder');
        if (adContainer && adContainer.offsetHeight < 10) { // Check if ads are not loading
            document.getElementById('ad-fallback').style.display = 'block';
        }
    }, 3000); // Check after 3 seconds
});
</script>

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
