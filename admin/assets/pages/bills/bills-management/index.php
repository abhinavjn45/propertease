<div class="d-flex flex-wrap align-items-center justify-content-between gap-3 mb-24">
    <h6 class="fw-semibold mb-0">All Bills</h6>
    <ul class="d-flex align-items-center gap-2">
        <li class="fw-medium">
            <a href="<?= get_site_option('dashboard_url') ?>" class="d-flex align-items-center gap-1 hover-text-primary">
                <iconify-icon icon="solar:home-smile-angle-outline" class="icon text-lg"></iconify-icon>
                Dashboard
            </a>
        </li>
        <li>/</li>
        <li class="fw-medium">Bills Management</li>
    </ul>
</div>

<div class="card basic-data-table">
    <div class="card-header d-flex align-items-center justify-content-between">
        <h5 class="card-title mb-0">All Bills</h5>
        <a href="<?= get_site_option('dashboard_url') ?>?page=add-bill" class="btn btn-primary d-inline-flex align-items-center gap-2">
            <iconify-icon icon="solar:clipboard-list-outline" class="icon text-lg"></iconify-icon>
            Add New Bill
        </a>
    </div>
    <div class="card-body">
        <table class="table bordered-table mb-0" id="billsDataTable" data-page-length='25'>
            <thead>
                <tr>
                    <th scope="col" class="text-center">#</th>
                    <th scope="col">Member</th>
                    <th scope="col">View</th>
                    <th scope="col">Month</th>
                    <th scope="col">Status</th>
                    <th scope="col">Action</th>
                </tr>
            </thead>
            <tbody>
                <?= load_bills('bills-management') ?>
            </tbody>
        </table>
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
        if (newStatus === 'paid') {
            statusMessage = 'This will refer as the ' + typeCapitalized + ' <strong>is Paid</strong> by the Resident.';
        } else if (newStatus === 'pending') {
            statusMessage = 'This will refer as the ' + typeCapitalized + ' <strong>is Pending</strong> to be paid from the Resident.';
        } else if (newStatus === 'cancelled') {
            statusMessage = 'This will refer as the ' + typeCapitalized + ' <strong>is Cancelled</strong> and will not be collected from the Resident.';
        } else if (newStatus === 'deleted') {
            statusMessage = 'This will <strong>delete</strong> the ' + typeCapitalized + ' and it will no longer appear in listing.';
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