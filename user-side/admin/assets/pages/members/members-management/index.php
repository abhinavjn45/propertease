<div class="d-flex flex-wrap align-items-center justify-content-between gap-3 mb-24">
    <h6 class="fw-semibold mb-0">All Members</h6>
    <ul class="d-flex align-items-center gap-2">
        <li class="fw-medium">
            <a href="<?= get_site_option('dashboard_url') ?>" class="d-flex align-items-center gap-1 hover-text-primary">
                <iconify-icon icon="solar:home-smile-angle-outline" class="icon text-lg"></iconify-icon>
                Dashboard
            </a>
        </li>
        <li>/</li>
        <li class="fw-medium">Members Management</li>
    </ul>
</div>

<div class="card basic-data-table">
    <div class="card-header d-flex align-items-center justify-content-between">
        <h5 class="card-title mb-0">All Members</h5>
        <a href="<?= get_site_option('dashboard_url') ?>?page=add-member" class="btn btn-primary d-inline-flex align-items-center gap-2">
            <iconify-icon icon="mage:megaphone-b" class="icon text-lg"></iconify-icon>
            Add New Member
        </a>
    </div>
    <div class="card-body">
        <div class="table-responsive">
            <table class="table bordered-table mb-0" id="membersDataTable" data-page-length='25'>
                <thead>
                    <tr>
                        <th scope="col" class="text-center">#</th>
                        <th scope="col">Number</th>
                        <th scope="col">Flat</th>
                        <th scope="col">Fullname</th>
                        <th scope="col">Email</th>
                        <th scope="col">Phone Number</th>
                        <th scope="col">Status</th>
                        <th scope="col">Action</th>
                    </tr>
                </thead>
                <tbody>
                    <?= fetch_members('members-management') ?>
                </tbody>
            </table>
        </div>
    </div>
</div>

<script>
    // Store CSRF token for status change requests
    const csrfToken = '<?= get_csrf_token(); ?>';
    
    // Handle status change with SweetAlert confirmation
    function confirmStatusChange(type, field, idValue, statusField, newStatus, updatedTimeField) {
        const typeCapitalized = type.charAt(0).toUpperCase() + type.slice(1, -1);
        const announcementId = idValue;
        let statusMessage = '';
        if (newStatus === 'active') {
            statusMessage = 'This will make the ' + typeCapitalized + ' <strong>visible</strong> on the Website.';
        } else if (newStatus === 'inactive') {
            statusMessage = 'This will make the ' + typeCapitalized + ' <strong>hidden</strong> from the Website.';
        } else if (newStatus === 'deleted') {
            statusMessage = 'This will <strong>delete</strong> the ' + typeCapitalized + ' and it will no longer appear in listings or on the Website.';
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

<script>
    function resendPassword(email) {
        Swal.fire({
            title: 'Resend Password Email?',
            text: 'An email with the password will be sent to ' + email,
            icon: 'question',
            showCancelButton: true,
            confirmButtonColor: '#3085d6',
            cancelButtonColor: '#d33',
            confirmButtonText: 'Yes, send it!'
        }).then((result) => {
            if (result.isConfirmed) {
                // Send AJAX request to resend password email
                fetch('assets/includes/functions/ajax-handlers/members/resend_password_email.php', {
                    method: 'POST',
                    headers: {
                        'Content-Type': 'application/x-www-form-urlencoded',
                    },
                    body: 'email=' + encodeURIComponent(email) + '&csrf_token=' + encodeURIComponent(csrfToken)
                })
                .then(response => response.json())
                .then(data => {
                    if (data.success) {
                        Swal.fire('Success!', 'Password email sent successfully.', 'success');
                    } else {
                        Swal.fire('Error!', data.message || 'Failed to send password email.', 'error');
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

<script>
    tinymce.init({
        selector: '.tinymce-editor',
        plugins: 'advlist autolink lists link image charmap print preview hr anchor searchreplace wordcount visualblocks visualchars code fullscreen insertdatetime media nonbreaking save table contextmenu directionality emoticons template paste textpattern',
        toolbar: 'insertfile undo redo | styleselect | bold italic | alignleft aligncenter alignright alignjustify | bullist numlist outdent indent | link image | print preview media fullpage | forecolor backcolor emoticons',
        height: 400,
        readonly: true
    });
</script>