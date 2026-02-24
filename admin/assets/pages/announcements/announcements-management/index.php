<div class="d-flex flex-wrap align-items-center justify-content-between gap-3 mb-24">
    <h6 class="fw-semibold mb-0">All Announcements</h6>
    <ul class="d-flex align-items-center gap-2">
        <li class="fw-medium">
            <a href="<?= get_site_option('dashboard_url') ?>" class="d-flex align-items-center gap-1 hover-text-primary">
                <iconify-icon icon="solar:home-smile-angle-outline" class="icon text-lg"></iconify-icon>
                Dashboard
            </a>
        </li>
        <li>/</li>
        <li class="fw-medium">Announcements Management</li>
    </ul>
</div>

<div class="card basic-data-table">
    <div class="card-header d-flex align-items-center justify-content-between">
        <h5 class="card-title mb-0">All Announcements</h5>
        <a href="javascript:void(0)" class="btn btn-primary d-inline-flex align-items-center gap-2" data-bs-toggle="modal" data-bs-target="#addAnnouncementModal">
            <iconify-icon icon="mage:megaphone-b" class="icon text-lg"></iconify-icon>
            Add New Announcement
        </a>
    </div>
    <div class="card-body">
        <table class="table bordered-table mb-0" id="announcementsDataTable" data-page-length='25'>
            <thead>
                <tr>
                    <th scope="col" class="text-center">#</th>
                    <th scope="col">Content</th>
                    <th scope="col">Expiry</th>
                    <th scope="col">Status</th>
                    <th scope="col">Action</th>
                </tr>
            </thead>
            <tbody>
                <?= load_announcements('announcements-management') ?>
            </tbody>
        </table>
    </div>
</div>

<!-- Add Announcement Modal -->
<div class="modal fade" id="addAnnouncementModal" tabindex="-1" aria-labelledby="addAnnouncementModalLabel" aria-hidden="true">
    <div class="modal-dialog modal-lg modal-dialog-centered">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="addAnnouncementModalLabel">Add New Announcement</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <form id="addAnnouncementForm">
                <div class="modal-body">
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
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-outline-secondary" data-bs-dismiss="modal">Cancel</button>
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

            const formData = new FormData(addAnnouncementForm);

            fetch('assets/includes/functions/ajax-handlers/announcements/add_new_announcement.php', {
                method: 'POST',
                body: formData
            })
            .then(res => res.json())
            .then(data => {
                console.log('Response data:', data);
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
                console.error('Fetch error:', err);
                Swal.fire('Error', 'An error occurred while saving.', 'error');
            })
            .finally(() => {
                btn.disabled = false; btn.textContent = 'Save Announcement';
            });
        }
    }
</script>

<script>
    // Store CSRF token for status change requests
    const csrfToken = '<?= get_csrf_token(); ?>';
    
    // Handle status change with SweetAlert confirmation
    function confirmStatusChange(type, field, idValue, statusField, newStatus, updatedTimeField) {
        const typeCapitalized = type.charAt(0).toUpperCase() + type.slice(1, -1);
        const announcementId = idValue;
        let statusMessage = '';
        if (newStatus === 'active') {
            statusMessage = 'This will make the ' + typeCapitalized + ' <strong>visible</strong> on the topbar.';
        } else if (newStatus === 'inactive') {
            statusMessage = 'This will make the ' + typeCapitalized + ' <strong>hidden</strong> from the topbar.';
        } else if (newStatus === 'deleted') {
            statusMessage = 'This will <strong>delete</strong> the ' + typeCapitalized + ' and it will no longer appear in listings or the topbar.';
        }

        Swal.fire({
            title: 'Are You Sure?',
            customClass: { title: 'swal-title-sm' },
            html: 'Do you want to change the status to <strong>' + newStatus.charAt(0).toUpperCase() + newStatus.slice(1) + '</strong>?<br>' + statusMessage,
            icon: 'warning',
            showCancelButton: true,
            confirmButtonColor: '#3085d6',
            cancelButtonColor: '#d33',
            confirmButtonText: 'Yes, change it!'
        }).then((result) => {
            if (result.isConfirmed) {
                // Send AJAX request to change status
                fetch('assets/includes/functions/ajax-handlers/change_status.php', {
                    method: 'POST',
                    headers: {
                        'Content-Type': 'application/x-www-form-urlencoded',
                    },
                    body: 'type=' + type + '&' + 'field=' + field + '&' + 'idValue=' + idValue + '&' + 'statusField=' + statusField + '&' + 'newStatus=' + newStatus + '&' + 'updatedTimeField=' + updatedTimeField + '&' + 'csrf_token=' + encodeURIComponent(csrfToken)
                })
                .then(response => response.json())
                .then(data => {
                    if (data.success) {
                        Swal.fire({
                            title: 'Success!',
                            text: 'Status updated successfully.',
                            icon: 'success'
                        }).then(() => {
                            location.reload();
                        });
                    } else {
                        Swal.fire('Error!', 'Failed to update status.', 'error');
                    }
                })
                .catch(error => {
                    console.error('Error:', error);
                    Swal.fire('Error!', 'An error occurred.', 'error');
                });
            }
        });
    }
</script>