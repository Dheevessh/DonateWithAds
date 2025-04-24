// Highlight selected vote card 
document.querySelectorAll('.vote-card input').forEach(input => { input.addEventListener('change', function() { document.querySelectorAll('.vote-card').forEach(card => { card.classList.remove('selected'); }); this.closest('.vote-card').classList.add('selected'); }); });

// Vote confirmation 
const form = document.querySelector('form'); if (form) { form.addEventListener('submit', function(e) { const selected = document.querySelector('input[name="charity"]:checked'); if (selected) { const confirmed = confirm(Youre voting for "${selected.value}". Submit your vote?); if (!confirmed) { e.preventDefault(); } } }); }

// Scroll to top 
const scrollBtn = document.createElement('button'); scrollBtn.textContent = '⬆️ Top'; scrollBtn.id = 'scrollToTop'; scrollBtn.style.display = 'none'; document.body.appendChild(scrollBtn);

window.addEventListener('scroll', () => { scrollBtn.style.display = window.scrollY > 300 ? 'block' : 'none'; });

scrollBtn.addEventListener('click', () => { window.scrollTo({ top: 0, behavior: 'smooth' }); });