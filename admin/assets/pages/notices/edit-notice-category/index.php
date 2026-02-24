<?php 
    $notice_category_id = isset($_GET['notice_category_id']) ? trim($_GET['notice_category_id']) : '';
    if (!empty($notice_category_id)) {
        $notice_category = get_notice_category_details($notice_category_id);
        if ($notice_category) {
?>
<div class="d-flex flex-wrap align-items-center justify-content-between gap-3 mb-24">
    <h6 class="fw-semibold mb-0">Edit Notice Category</h6>
    <ul class="d-flex align-items-center gap-2">
        <li class="fw-medium">
            <a href="<?= get_site_option('dashboard_url') ?>" class="d-flex align-items-center gap-1 hover-text-primary">
                <iconify-icon icon="solar:home-smile-angle-outline" class="icon text-lg"></iconify-icon>
                Dashboard
            </a>
        </li>
        <li>/</li>
        <li class="fw-medium">Edit Notice Category</li>
    </ul>
</div>

<div class="card basic-data-table">
    <div class="card-header d-flex align-items-center justify-content-between">
        <h5 class="card-title mb-0">Edit Notice Category</h5>
        <a href="<?= get_site_option('dashboard_url') ?>?page=notice-categories" class="btn btn-secondary d-inline-flex align-items-center gap-2">
            <iconify-icon icon="proicons:cancel-circle" class="icon text-lg"></iconify-icon>
            Cancel
        </a>
    </div>
    <div class="card-body">
        <div class="row gy-3">
            <form id="editNoticeCategoryForm">
                <?php 
                    echo csrf_input_field(); 
                ?>
                <input type="hidden" id="editNoticeCategoryId" value="<?= htmlspecialchars($notice_category_id) ?>" readonly required>
                <div class="row">
                    <div class="col-md-6">
                        <div class="mb-3">
                            <label for="editNoticeCategoryName" class="form-label">Notice Category Name:<span class="text-danger">*</span></label>
                            <input type="text" id="editNoticeCategoryName" name="edit_notice_category_name" class="form-control" value="<?= htmlspecialchars($notice_category['notice_category_name']) ?>" required>
                        </div>
                    </div>
                    <div class="col-md-6">
                        <div class="mb-3">
                            <label for="editNoticeParentCategory" class="form-label">Parent Category:</label><br>
                            <select id="editNoticeParentCategory" name="edit_notice_parent_category_id" class="form-select">
                                <?= get_notice_categories_select_box('edit-category', $notice_category['notice_parent_category_id']) ?>
                            </select>
                            <p class="form-text">Select a parent category or leave as "None" for top-level category.</p>
                        </div>
                    </div>
                </div>
                <div class="mb-3">
                    <button type="reset" class="btn btn-secondary">Reset</button>
                    <button type="submit" class="btn btn-primary" id="submitEditNoticeCategory">Save Changes</button>
                </div>
            </form>
        </div>
    </div>
</div>

<script>
    const editNoticeCategoryForm = document.getElementById('editNoticeCategoryForm');
    if (editNoticeCategoryForm) {
        editNoticeCategoryForm.onsubmit = function(e) {
            e.preventDefault();

            const btn = document.getElementById('submitEditNoticeCategory');
            btn.disabled = true;
            btn.textContent = 'Saving...';

            const noticeCategoryId = document.getElementById('editNoticeCategoryId').value.trim();
            const noticeCategoryName = document.getElementById('editNoticeCategoryName').value.trim();
            const parentCategorySelect = document.getElementById('editNoticeParentCategory');
            const parentCategoryId = parentCategorySelect.value.trim();
            const csrfToken = document.querySelector('input[name="csrf_token"]').value;

            if (!noticeCategoryId || !noticeCategoryName || !csrfToken) {
                Swal.fire('Validation Error', 'Please provide a category name.', 'warning');
                btn.disabled = false; btn.textContent = 'Save Changes';
                return;
            }

            const formData = new FormData();
            formData.append('notice_category_id', noticeCategoryId);
            formData.append('notice_category_name', noticeCategoryName);
            // If parent category is "NULL" or empty, send null
            if (parentCategoryId && parentCategoryId !== 'NULL') {
                formData.append('notice_parent_category_id', parentCategoryId);
            } else {
                formData.append('notice_parent_category_id', '');
            }
            formData.append('csrf_token', csrfToken);

            fetch('assets/includes/functions/ajax-handlers/notices/edit_notice_category.php', {
                method: 'POST',
                body: formData
            })
            .then(res => res.json())
            .then(data => {
                if (data.success) {
                    Swal.fire('Success', 'Notice category updated successfully.', 'success').then(() => {
                        window.location.href = '<?= get_site_option('dashboard_url') ?>?page=notice-categories';
                    });
                } else {
                    Swal.fire('Error', data.error || 'Failed to update notice category.', 'error');
                }
            })
            .catch(() => {
                Swal.fire('Error', 'An error occurred while saving.', 'error');
            })
            .finally(() => {
                btn.disabled = false; btn.textContent = 'Save Changes';
            });
        }
    }
</script>
<?php } } ?>