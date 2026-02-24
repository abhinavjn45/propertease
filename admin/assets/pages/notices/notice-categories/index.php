<div class="d-flex flex-wrap align-items-center justify-content-between gap-3 mb-24">
    <h6 class="fw-semibold mb-0">Notice Categories</h6>
    <ul class="d-flex align-items-center gap-2">
        <li class="fw-medium">
            <a href="<?= get_site_option('dashboard_url') ?>" class="d-flex align-items-center gap-1 hover-text-primary">
                <iconify-icon icon="solar:home-smile-angle-outline" class="icon text-lg"></iconify-icon>
                Dashboard
            </a>
        </li>
        <li>/</li>
        <li class="fw-medium">Notice Categories</li>
    </ul>
</div>

<style>
    @media (min-width: 768px) {
        .sticky-card {
            position: sticky;
            top: 9rem;
            z-index: 100;
        }
    }
</style>

<div class="row">
    <div class="col-md-4">
        <div class="card basic-data-table sticky-card">
            <div class="card-header d-flex align-items-center justify-content-between">
                <h5 class="card-title mb-0">Add New Notice Category</h5>
            </div>
            <div class="card-body">
                <div class="row gy-3">
                    <form id="addNoticeCategoryForm">
                        <?php 
                            echo csrf_input_field(); 
                        ?>
                        <div class="">
                            <label for="noticeCategoryName" class="form-label">Name</label>
                            <input type="text" id="noticeCategoryName" name="notice_category_name" class="form-control" required>
                            <p class="form-text">The name is how it appears on your site.</p>
                        </div>
                        <div class="">
                            <label for="noticeParentCategory" class="form-label">Parent Category</label>
                            <select id="noticeParentCategory" name="parent_notice_category_id" class="form-select">
                                <?= get_notice_categories_select_box('add-new-category') ?>
                            </select>
                            <p class="form-text">Select a parent category to create a hierarchy. Leave as "None" for a top-level category.</p>
                        </div>
                        <div class="mb-3">
                            <button type="reset" class="btn btn-secondary">Reset</button>
                            <button type="submit" class="btn btn-primary" id="submitAddNoticeCategory">Add New Category</button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
    <div class="col-md-8">
        <div class="card basic-data-table">
            <div class="card-header d-flex align-items-center justify-content-between">
                <h5 class="card-title mb-0">All Notice Categories</h5>
            </div>
            <div class="card-body">
                <table class="table bordered-table mb-0" id="noticeCategoriesDataTable" data-page-length='25'>
                    <thead>
                        <tr>
                            <th scope="col" class="text-center">#</th>
                            <th scope="col">Name</th>
                            <th scope="col">Slug</th>
                            <th scope="col">Status</th>
                            <th scope="col">Action</th>
                        </tr>
                    </thead>
                    <tbody>
                        <?= fetch_notice_categories('notice-categories', null, 'notice_category_id', 'DESC') ?>
                    </tbody>
                </table>
            </div>
        </div>
    </div>
</div>

<script>
    // Store CSRF token for status change requests
    const csrfToken = '<?= get_csrf_token(); ?>';
    
    // Handle status change with SweetAlert confirmation
    function confirmStatusChange(type, field, idValue, statusField, newStatus, updatedTimeField) {
        const typeCapitalized = "Notice Category";
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
    // Handle Add Notice Category form submit
    const addNoticeCategoryForm = document.getElementById('addNoticeCategoryForm');
    if (addNoticeCategoryForm) {
        addNoticeCategoryForm.onsubmit = function(e) {
            e.preventDefault();

            const btn = document.getElementById('submitAddNoticeCategory');
            btn.disabled = true;
            btn.textContent = 'Adding...';

            const noticeCategoryName = document.getElementById('noticeCategoryName').value.trim();
            const noticeParentCategory = document.getElementById('noticeParentCategory').value.trim();
            const csrf_token = document.querySelector('input[name="csrf_token"]').value;

            if (!noticeCategoryName || !csrf_token) {
                Swal.fire('Validation Error', 'Please provide a category name.', 'warning');
                btn.disabled = false; btn.textContent = 'Add New Category';
                return;
            }

            const formData = new FormData();
            formData.append('notice_category_name', noticeCategoryName);
            // If parent category is "NULL" or empty, send null
            if (noticeParentCategory && noticeParentCategory !== 'NULL') {
                formData.append('notice_parent_category_id', noticeParentCategory);
            } else {
                formData.append('notice_parent_category_id', '');
            }
            formData.append('csrf_token', csrf_token);

            fetch('assets/includes/functions/ajax-handlers/notices/add_new_notice_category.php', {
                method: 'POST',
                body: formData
            })
            .then(res => res.json())
            .then(data => {
                if (data.success) {
                    Swal.fire('Success', 'Notice category added successfully.', 'success').then(() => {
                        window.location.reload();
                    });
                } else {
                    Swal.fire('Error', data.error || 'Failed to add notice category.', 'error');
                }
            })
            .catch (err => {
                Swal.fire('Error', 'An error occurred while saving.', 'error');
            })
            .finally(() => {
                btn.disabled = false; btn.textContent = 'Add New Category';
            });
        }
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