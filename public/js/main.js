// Main JavaScript for DonateWhileWatching

document.addEventListener('DOMContentLoaded', function() {
    // Ad watching functionality
    const adContainer = document.getElementById('ad-container');
    const voteBtn = document.getElementById('vote-btn');
    const emailModal = document.getElementById('email-modal');
    const progressBar = document.getElementById('ad-progress-bar');
    const skipEmailBtn = document.getElementById('skip-email-btn');
    const adsCountDisplay = document.getElementById('ads-count');
    const progressCircle = document.getElementById('progress-circle');
    const progressPercentage = document.getElementById('progress-percentage');
    
    let adWatched = false;
    let emailCollected = false;
    let emailSkipped = false;
    let adDuration = 10; // in seconds (for testing, would typically be 30-60s)
    let currentProgress = 0;
    
    // Check if user already provided email
    if (localStorage.getItem('userEmail')) {
        emailCollected = true;
    }
    
    // Check if user skipped email
    if (localStorage.getItem('emailSkipped')) {
        emailSkipped = true;
    }
    
    // Simulate ad playback
    function startAdPlayback() {
        if (adContainer && progressBar) {
            const interval = setInterval(() => {
                currentProgress += 1;
                const percentage = (currentProgress / adDuration) * 100;
                progressBar.style.width = `${percentage}%`;
                
                // When ad is complete
                if (currentProgress >= adDuration) {
                    clearInterval(interval);
                    adWatched = true;
                    
                    // Record ad watch via AJAX
                    fetch('process_ad_watch.php', {
                        method: 'POST',
                        credentials: 'same-origin'
                    })
                    .then(response => response.json())
                    .then(data => {
                        if (data.success) {
                            console.log('Ad watch recorded:', data);
                            // Update ads count display
                            updateAdsProgress(data.ads_watched, data.ads_needed, data.can_vote);
                        }
                    })
                    .catch(error => {
                        console.error('Error recording ad watch:', error);
                    });
                    
                    // Check if we need to show email modal
                    if (!emailCollected && !emailSkipped) {
                        showEmailModal();
                    } else {
                        enableVoteButton();
                    }
                }
            }, 1000);
        }
    }
    
    // Update ads progress display
    function updateAdsProgress(adsWatched, adsNeeded, canVote) {
        if (adsCountDisplay) {
            adsCountDisplay.textContent = adsWatched;
        }
        
        if (progressCircle && progressPercentage) {
            const percentage = Math.round((adsWatched / adsNeeded) * 100);
            const circumference = 2 * Math.PI * 45;
            const offset = circumference - (circumference * (adsWatched / adsNeeded));
            
            progressCircle.style.strokeDashoffset = offset;
            progressPercentage.textContent = percentage + '%';
        }
        
        if (canVote) {
            enableVoteButton();
        }
    }
    
    // Show email collection modal
    function showEmailModal() {
        if (emailModal) {
            emailModal.style.display = 'block';
        }
    }
    
    // Close email modal
    function closeEmailModal() {
        if (emailModal) {
            emailModal.style.display = 'none';
        }
    }
    
    // Enable vote button
    function enableVoteButton() {
        if (voteBtn && adWatched) {
            fetch('check_can_vote.php', {
                method: 'GET',
                credentials: 'same-origin'
            })
            .then(response => response.json())
            .then(data => {
                if (data.can_vote) {
                    voteBtn.disabled = false;
                    voteBtn.classList.remove('opacity-50', 'cursor-not-allowed', 'bg-gray-400');
                    voteBtn.classList.add('bg-blue-600', 'hover:bg-blue-700');
                }
            })
            .catch(error => {
                console.error('Error checking vote eligibility:', error);
            });
        }
    }
    
    // Skip email collection
    if (skipEmailBtn) {
        skipEmailBtn.addEventListener('click', function() {
            localStorage.setItem('emailSkipped', 'true');
            emailSkipped = true;
            closeEmailModal();
            enableVoteButton();
        });
    }
    
    // Initialize modal close buttons
    const closeButtons = document.querySelectorAll('.close-modal');
    if (closeButtons) {
        closeButtons.forEach(button => {
            button.addEventListener('click', function() {
                closeEmailModal();
                enableVoteButton(); // Allow voting even if email modal is closed
            });
        });
    }
    
    // Initialize email form submission
    const emailForm = document.getElementById('email-form');
    if (emailForm) {
        emailForm.addEventListener('submit', function(e) {
            e.preventDefault();
            const emailInput = document.getElementById('email');
            if (emailInput && emailInput.value) {
                const email = emailInput.value.trim();
                
                // Validate email
                if (!validateEmail(email)) {
                    alert('Please enter a valid email address');
                    return;
                }
                
                // Save email and submit via AJAX
                fetch('process_email.php', {
                    method: 'POST',
                    headers: {
                        'Content-Type': 'application/x-www-form-urlencoded',
                    },
                    body: `email=${encodeURIComponent(email)}`
                })
                .then(response => response.json())
                .then(data => {
                    if (data.success) {
                        localStorage.setItem('userEmail', email);
                        emailCollected = true;
                        closeEmailModal();
                        enableVoteButton();
                    } else {
                        alert(data.message || 'There was an error processing your email');
                    }
                })
                .catch(error => {
                    console.error('Error:', error);
                    alert('There was an error processing your request');
                });
            } else {
                // If email is empty, just close the modal and enable voting
                closeEmailModal();
                enableVoteButton();
            }
        });
    }
    
    // Email validation
    function validateEmail(email) {
        const re = /^(([^<>()\[\]\\.,;:\s@"]+(\.[^<>()\[\]\\.,;:\s@"]+)*)|(".+"))@((\[[0-9]{1,3}\.[0-9]{1,3}\.[0-9]{1,3}\.[0-9]{1,3}])|(([a-zA-Z\-0-9]+\.)+[a-zA-Z]{2,}))$/;
        return re.test(String(email).toLowerCase());
    }
    
    // Charity voting
    const charityForm = document.getElementById('charity-form');
    if (charityForm) {
        charityForm.addEventListener('submit', function(e) {
            if (!adWatched) {
                e.preventDefault();
                alert('Please watch the ad before voting');
            }
        });
    }
    
    // Start ad playback if on the voting page
    if (adContainer) {
        startAdPlayback();
    }
    
    // Highlight selected charity
    const charityOptions = document.querySelectorAll('.charity-option');
    if (charityOptions) {
        charityOptions.forEach(option => {
            option.addEventListener('change', function() {
                // Remove highlight from all cards
                document.querySelectorAll('.charity-card').forEach(card => {
                    card.classList.remove('ring-2', 'ring-blue-500');
                });
                
                // Add highlight to selected card
                if (this.checked) {
                    const card = this.closest('.charity-card');
                    if (card) {
                        card.classList.add('ring-2', 'ring-blue-500');
                    }
                }
            });
        });
    }
    
    // Check if user can already vote on page load
    if (voteBtn) {
        enableVoteButton();
    }
}); 