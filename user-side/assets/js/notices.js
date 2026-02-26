// Notices page interactions
(function initFilters() {
    const filterButtons = document.querySelectorAll('.filter-btn');
    const noticeCards = document.querySelectorAll('.notice-card');

    filterButtons.forEach(btn => {
        btn.addEventListener('click', function () {
            const filter = this.getAttribute('data-filter');

            filterButtons.forEach(b => b.classList.remove('active'));
            this.classList.add('active');

            noticeCards.forEach(card => {
                const category = card.getAttribute('data-category');
                if (filter === 'all' || category === filter) {
                    card.classList.remove('hidden');
                } else {
                    card.classList.add('hidden');
                }
            });
        });
    });
})();

(function initSearch() {
    const searchInput = document.getElementById('searchInput');
    const searchBtn = document.getElementById('searchBtn');
    const noticeCards = document.querySelectorAll('.notice-card');

    function performSearch() {
        const searchTerm = searchInput.value.toLowerCase().trim();

        noticeCards.forEach(card => {
            const title = card.querySelector('.notice-title').textContent.toLowerCase();
            const content = card.querySelector('.notice-content').textContent.toLowerCase();
            const keywords = (card.getAttribute('data-keywords') || '').toLowerCase();

            if (
                searchTerm === '' ||
                title.includes(searchTerm) ||
                content.includes(searchTerm) ||
                keywords.includes(searchTerm)
            ) {
                card.classList.remove('hidden');
            } else {
                card.classList.add('hidden');
            }
        });

        if (searchTerm !== '') {
            document.querySelectorAll('.filter-btn').forEach(btn => btn.classList.remove('active'));
        }
    }

    searchBtn.addEventListener('click', performSearch);
    searchInput.addEventListener('keypress', e => {
        if (e.key === 'Enter') {
            performSearch();
        }
    });
})();

(function initArchive() {
    const archiveToggle = document.getElementById('archiveToggle');
    const archiveContent = document.getElementById('archiveContent');
    const archiveIcon = document.getElementById('archiveIcon');

    if (!archiveToggle || !archiveContent || !archiveIcon) return;

    archiveToggle.addEventListener('click', function () {
        const isExpanded = archiveContent.classList.contains('expanded');

        if (isExpanded) {
            archiveContent.classList.remove('expanded');
            archiveIcon.classList.remove('expanded');
            this.setAttribute('aria-expanded', 'false');
        } else {
            archiveContent.classList.add('expanded');
            archiveIcon.classList.add('expanded');
            this.setAttribute('aria-expanded', 'true');
        }
    });

    archiveToggle.addEventListener('keypress', function (e) {
        if (e.key === 'Enter' || e.key === ' ') {
            e.preventDefault();
            this.click();
        }
    });
})();

