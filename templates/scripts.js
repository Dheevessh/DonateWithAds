document.addEventListener('DOMContentLoaded', function() {
    // Make vote cards more touch-friendly
    const voteCards = document.querySelectorAll('.vote-card');
    
    voteCards.forEach(card => {
        // Handle touch and click events
        card.addEventListener('click', function() {
            // Select the radio button inside this card
            const radioButton = this.querySelector('input[type="radio"]');
            if (radioButton) {
                radioButton.checked = true;
                
                // Visual feedback - remove active class from all cards
                voteCards.forEach(c => c.classList.remove('active-card'));
                
                // Add active class to the selected card
                this.classList.add('active-card');
            }
        });
        
        // Prevent double-tap zoom on mobile devices
        card.addEventListener('touchend', function(e) {
            e.preventDefault();
        });
    });
    
    // Add responsive handling for ads
    const adBlocks = document.querySelectorAll('.ad-block');
    
    // Make sure ads resize properly on orientation change
    window.addEventListener('resize', function() {
        // You could add specific handling for ads if needed
    });
});
