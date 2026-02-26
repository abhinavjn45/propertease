<!-- Top Bar: Latest Updates -->
<div class="top-bar" aria-label="Latest announcements">
    <div class="d-flex align-items-center">
        <div class="top-bar-label">
            Latest Updates
        </div>
        <div class="top-bar-marquee flex-grow-1">
            <div class="top-bar-track">
                <?php 
                    load_announcements('topbar', 'active', date('Y-m-d H:i:s'), 'announcement_id', 'DESC');
                ?>
            </div>
        </div>
    </div>
</div>

<script>
    // Duplicate marquee items once to create a seamless loop
    document.addEventListener('DOMContentLoaded', function () {
        var track = document.querySelector('.top-bar-track');
        if (!track) return;
        // Avoid double-duplication if this script runs more than once
        if (track.dataset.duped === 'true') return;
        track.innerHTML = track.innerHTML + track.innerHTML;
        track.dataset.duped = 'true';
    });
</script>
