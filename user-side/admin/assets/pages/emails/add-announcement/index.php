<div class="d-flex flex-wrap align-items-center justify-content-between gap-3 mb-24">
    <h6 class="fw-semibold mb-0">Add Announcements</h6>
    <ul class="d-flex align-items-center gap-2">
        <li class="fw-medium">
            <a href="<?= get_site_option('dashboard_url') ?>" class="d-flex align-items-center gap-1 hover-text-primary">
                <iconify-icon icon="solar:home-smile-angle-outline" class="icon text-lg"></iconify-icon>
                Dashboard
            </a>
        </li>
        <li>/</li>
        <li class="fw-medium">Add New Announcement</li>
    </ul>
</div>

<div class="card basic-data-table">
    <div class="card-header d-flex align-items-center justify-content-between">
        <h5 class="card-title mb-0">Add New Announcement</h5>
        <a href="<?= get_site_option('dashboard_url') ?>?page=announcements-management" class="btn btn-primary d-inline-flex align-items-center gap-2">
            <iconify-icon icon="solar:clipboard-list-outline" class="icon text-lg"></iconify-icon>
            All Announcements
        </a>
    </div>
    <div class="card-body">
        <div class="row gy-3">
            <form id="addAnnouncementForm">
                <?php 
                    echo csrf_input_field(); 
                ?>
                <div class="mb-3">
                    <label for="announcementContent" class="form-label">Content</label>
                    <textarea id="announcementContent" name="announcement_content" class="form-control" rows="4" required placeholder="Enter announcement content..." style="resize: none;"></textarea>
                </div>
                <div class="mb-3">
                    <label for="announcementExpiry" class="form-label">Expiry Date</label>
                    <input type="date" id="announcementExpiry" name="announcement_expiry_on" class="form-control" required />
                </div>
                <div class="mb-3">
                    <button type="reset" class="btn btn-secondary">Reset</button>
                    <button type="submit" class="btn btn-primary" id="submitAddAnnouncement">Save Announcement</button>
                </div>
            </form>
        </div>
    </div>
</div>

<script>
    // Handle Add Announcement form submit
    const addAnnouncementForm = document.getElementById('addAnnouncementForm');
    if (addAnnouncementForm) {
        addAnnouncementForm.onsubmit = function(e) {
            e.preventDefault();

            const btn = document.getElementById('submitAddAnnouncement');
            btn.disabled = true;
            btn.textContent = 'Saving...';

            const content = document.getElementById('announcementContent').value.trim();
            const expiry = document.getElementById('announcementExpiry').value.trim();
            const csrfToken = document.querySelector('input[name="csrf_token"]').value;

            if (!content || !expiry) {
                Swal.fire('Validation Error', 'Please fill all fields.', 'warning');
                btn.disabled = false; btn.textContent = 'Save Announcement';
                return;
            }

            fetch('assets/includes/functions/ajax-handlers/announcements/add_new_announcement.php', {
                method: 'POST',
                headers: {
                    'Content-Type': 'application/x-www-form-urlencoded'
                },
                body: new URLSearchParams({
                    action: 'add_announcement',
                    announcement_content: content,
                    announcement_expiry_on: expiry,
                    csrf_token: csrfToken
                }).toString()
            })
            .then(res => res.json())
            .then(data => {
                if (data.success) {
                    Swal.fire('Success', 'Announcement added successfully.', 'success').then(() => {
                        // Close modal and reload to show new entry
                        const modalEl = document.getElementById('addAnnouncementModal');
                        if (modalEl) {
                            const modal = bootstrap.Modal.getInstance(modalEl) || new bootstrap.Modal(modalEl);
                            modal.hide();
                        }
                        location.reload();
                    });
                } else {
                    Swal.fire('Error', data.error || 'Failed to add announcement.', 'error');
                }
            })
            .catch (err => {
                Swal.fire('Error', 'An error occurred while saving.', 'error');
            })
            .finally(() => {
                btn.disabled = false; btn.textContent = 'Save Announcement';
            });
        }
    }
</script>