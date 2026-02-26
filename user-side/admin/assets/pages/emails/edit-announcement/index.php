<?php 
    $announcement_id = isset($_GET['announcement_id']) ? trim($_GET['announcement_id']) : '';
    if (!empty($announcement_id)) {
        $announcement = get_announcement_details($announcement_id);
        if ($announcement) {
            
?>
<div class="d-flex flex-wrap align-items-center justify-content-between gap-3 mb-24">
    <h6 class="fw-semibold mb-0">Edit Announcement</h6>
    <ul class="d-flex align-items-center gap-2">
        <li class="fw-medium">
            <a href="<?= get_site_option('dashboard_url') ?>" class="d-flex align-items-center gap-1 hover-text-primary">
                <iconify-icon icon="solar:home-smile-angle-outline" class="icon text-lg"></iconify-icon>
                Dashboard
            </a>
        </li>
        <li>/</li>
        <li class="fw-medium">Edit Announcement</li>
    </ul>
</div>

<div class="card basic-data-table">
    <div class="card-header d-flex align-items-center justify-content-between">
        <h5 class="card-title mb-0">Edit Announcement</h5>
        <a href="<?= get_site_option('dashboard_url') ?>?page=announcements-management" class="btn btn-secondary d-inline-flex align-items-center gap-2">
            <iconify-icon icon="proicons:cancel-circle" class="icon text-lg"></iconify-icon>
            Cancel
        </a>
    </div>
    <div class="card-body">
        <div class="row gy-3">
            <form id="editAnnouncementForm">
                <?php 
                    echo csrf_input_field(); 
                ?>
                <input type="hidden" id="editAnnouncementId" value="<?= htmlspecialchars($announcement_id) ?>">
                <div class="mb-3">
                    <label for="editAnnouncementContent" class="form-label">Content</label>
                    <textarea id="editAnnouncementContent" name="editAnnouncement_content" class="form-control" rows="4" required placeholder="Enter announcement content..." style="resize: none;"><?= htmlspecialchars($announcement['announcement_content']) ?></textarea>
                </div>
                <div class="mb-3">
                    <label for="editAnnouncementExpiry" class="form-label">Expiry Date</label>
                    <input type="date" id="editAnnouncementExpiry" name="editAnnouncement_expiry_on" class="form-control" required value="<?= date('Y-m-d', strtotime($announcement['announcement_expiry_on'])) ?>" />
                </div>
                <div class="mb-3">
                    <button type="reset" class="btn btn-secondary">Reset</button>
                    <button type="submit" class="btn btn-primary" id="submitEditAnnouncement">Save Announcement</button>
                </div>
            </form>
        </div>
    </div>
</div>

<script>
    // Handle Edit Announcement form submit
    const editAnnouncementForm = document.getElementById('editAnnouncementForm');
    if (editAnnouncementForm) {
        editAnnouncementForm.onsubmit = function(e) {
            e.preventDefault();

            const btn = document.getElementById('submitEditAnnouncement');
            btn.disabled = true;
            btn.textContent = 'Saving...';

            const announcementId = document.getElementById('editAnnouncementId').value;
            const content = document.getElementById('editAnnouncementContent').value.trim();
            const expiry = document.getElementById('editAnnouncementExpiry').value.trim();
            const csrfToken = document.querySelector('input[name="csrf_token"]').value;

            if (!content || !expiry || !announcementId) {
                Swal.fire('Validation Error', 'Please fill all fields.', 'warning');
                btn.disabled = false; btn.textContent = 'Save Announcement';
                return;
            }

            fetch('assets/includes/functions/ajax-handlers/announcements/edit_announcement.php', {
                method: 'POST',
                headers: {
                    'Content-Type': 'application/x-www-form-urlencoded'
                },
                body: new URLSearchParams({
                    action: 'edit_announcement',
                    announcement_id: announcementId,
                    announcement_content: content,
                    announcement_expiry_on: expiry,
                    csrf_token: csrfToken
                }).toString()
            })
            .then(res => res.json())
            .then(data => {
                if (data.success) {
                    Swal.fire('Success', 'Announcement updated successfully.', 'success').then(() => {
                        window.location.href = '<?= get_site_option('dashboard_url') ?>?page=announcements-management';
                    });
                } else {
                    Swal.fire('Error', data.error || 'Failed to update announcement.', 'error');
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
<?php } } ?>