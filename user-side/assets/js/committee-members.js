// Committee Members Page Script

(function() {
    'use strict';

    var allCards = [];

    /**
     * Filter member cards based on search and wing
     */
    function filterMembers() {
        var searchTerm = document.getElementById('searchInput').value.toLowerCase();
        var wingFilter = document.getElementById('wingFilter').value;
        var visibleCount = 0;

        allCards.forEach(function(card) {
            var name = card.querySelector('.member-name').textContent.toLowerCase();
            var position = card.querySelector('.member-position').textContent.toLowerCase();
            
            // Get flat if it exists
            var flatElement = card.querySelector('.member-flat');
            var flat = flatElement ? flatElement.textContent.toLowerCase() : '';
            
            // Get wing by searching through all detail items
            var wing = '';
            var detailItems = card.querySelectorAll('.member-detail-item');
            detailItems.forEach(function(item) {
                var text = item.textContent;
                if (text.includes('Wing')) {
                    wing = text.replace('Wing', '').trim();
                }
            });

            var matchesSearch = name.includes(searchTerm) ||
                               flat.includes(searchTerm) ||
                               position.includes(searchTerm);
            var matchesWing = !wingFilter || wing === wingFilter;

            if (matchesSearch && matchesWing) {
                card.style.display = '';
                visibleCount++;
            } else {
                card.style.display = 'none';
            }
        });

        // Show/hide no results message
        var grid = document.getElementById('membersGrid');
        var noResults = document.getElementById('noResults');
        
        if (visibleCount === 0) {
            grid.style.display = 'none';
            noResults.style.display = 'block';
        } else {
            grid.style.display = 'grid';
            noResults.style.display = 'none';
        }
    }

    /**
     * Reset all filters
     */
    function resetFilters() {
        document.getElementById('searchInput').value = '';
        document.getElementById('wingFilter').value = '';
        filterMembers();
    }

    /**
     * Initialize when DOM is ready
     */
    function init() {
        // Get all member cards
        allCards = Array.from(document.querySelectorAll('.member-card'));

        // Wire up event listeners
        var searchInput = document.getElementById('searchInput');
        var wingFilter = document.getElementById('wingFilter');
        var resetBtn = document.getElementById('resetBtn');

        if (searchInput) searchInput.addEventListener('input', filterMembers);
        if (wingFilter) wingFilter.addEventListener('change', filterMembers);
        if (resetBtn) resetBtn.addEventListener('click', resetFilters);

        // Initial display
        filterMembers();
    }

    // Run on DOMContentLoaded
    if (document.readyState === 'loading') {
        document.addEventListener('DOMContentLoaded', init);
    } else {
        init();
    }
})();
