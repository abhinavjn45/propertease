<?php 
    $notice_id = isset($_GET['notice_id']) ? trim($_GET['notice_id']) : '';
    if (!empty($notice_id)) {
        $notice = get_notice_details($notice_id);
        if ($notice) {
?>
<div class="d-flex flex-wrap align-items-center justify-content-between gap-3 mb-24">
    <h6 class="fw-semibold mb-0">Edit Notice</h6>
    <ul class="d-flex align-items-center gap-2">
        <li class="fw-medium">
            <a href="<?= get_site_option('dashboard_url') ?>" class="d-flex align-items-center gap-1 hover-text-primary">
                <iconify-icon icon="solar:home-smile-angle-outline" class="icon text-lg"></iconify-icon>
                Dashboard
            </a>
        </li>
        <li>/</li>
        <li class="fw-medium">Edit Notice</li>
    </ul>
</div>

<div class="card basic-data-table">
    <div class="card-header d-flex align-items-center justify-content-between">
        <h5 class="card-title mb-0">Edit Notice</h5>
        <a href="<?= get_site_option('dashboard_url') ?>?page=notices-management" class="btn btn-secondary d-inline-flex align-items-center gap-2">
            <iconify-icon icon="proicons:cancel-circle" class="icon text-lg"></iconify-icon>
            Cancel
        </a>
    </div>
    <div class="card-body">
        <div class="row gy-3">
            <form id="editNoticeForm">
                <?php 
                    echo csrf_input_field(); 
                ?>
                <input type="hidden" id="editNoticeId" value="<?= htmlspecialchars($notice_id) ?>" readonly required>
                <div class="row">
                    <div class="col-md-4">
                        <div class="mb-3">
                            <label for="editNoticeNumber" class="form-label">Number:<span class="text-danger">*</span></label>
                            <input type="text" id="editNoticeNumber" class="form-control" value="<?= htmlspecialchars($notice['notice_number']) ?>" required>
                        </div>
                    </div>
                    <div class="col-md-8">
                        <div class="">
                            <label for="editNoticeTitle" class="form-label">Title:<span class="text-danger">*</span></label>
                            <input type="text" id="editNoticeTitle" class="form-control" value="<?= htmlspecialchars($notice['notice_title']) ?>" required />
                            <div class="row justify-content-between">
                                <div class="col-md-6 text-start">
                                    <p class="form-text">(Recommended Length: 60-70 characters)</p>
                                </div>
                                <div class="col-md-6 text-end">
                                    <p class="form-text live-count"></p>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="col-md-9">
                        <div class="">
                            <label for="editNoticeSingleLine" class="form-label">Single Line:<span class="text-danger">*</span></label>
                            <textarea id="editNoticeSingleLine" class="form-control" rows="1" style="resize: none;" required><?= htmlspecialchars($notice['notice_single_line']) ?></textarea>
                            <div class="row justify-content-between">
                                <div class="col-md-6 text-start">
                                    <p class="form-text">(Recommended Length: 40-50 characters)</p>
                                </div>
                                <div class="col-md-6 text-end">
                                    <p class="form-text live-count"></p>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="col-md-3">
                        <div class="">
                            <label for="editNoticeCategory" class="form-label">Category:<span class="text-danger">*</span></label>
                            <select id="editNoticeCategory" class="form-select" required>
                                <?= get_notice_categories_select_box('edit-notice', $notice['notice_category']); ?>
                            </select>
                        </div>
                    </div>
                    <div class="col-md-3">
                        <div class="">
                            <label for="editNoticeBadge" class="form-label">Badge:</label>
                            <input type="text" id="editNoticeBadge" class="form-control" value="<?= htmlspecialchars($notice['notice_badge']) ?>">
                        </div>
                    </div>
                    <div class="col-md-9">
                        <div class="mb-3">
                            <label for="editNoticeExcerpt" class="form-label">Excerpt:<span class="text-danger">*</span></label>
                            <textarea id="editNoticeExcerpt" class="form-control" rows="2" style="resize: none;" required><?= htmlspecialchars($notice['notice_excerpt']) ?></textarea>
                            <div class="row justify-content-between">
                                <div class="col-md-6 text-start">
                                    <p class="form-text">(Recommended Length: 100-130 characters)</p>
                                </div>
                                <div class="col-md-6 text-end">
                                    <p class="form-text live-count"></p>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="col-md-12">
                        <div class="mb-3">
                            <label for="editNoticeContent" class="form-label">Content:<span class="text-danger">*</span></label>
                            <textarea id="editNoticeContent" class="form-control tinymce" rows="4" style="resize: none;" required><?= htmlspecialchars($notice['notice_content']) ?></textarea>
                        </div>
                    </div>
                    <div class="col-md-6">
                        <div class="mb-3">
                            <label for="editNoticeMaterialTitle" class="form-label">Material Title:</label>
                            <input type="text" id="editNoticeMaterialTitle" name="edit_notice_material_title" class="form-control" value="<?= htmlspecialchars($notice['notice_material_title']) ?>" />
                        </div>
                    </div>
                    <div class="col-md-6">
                        <div class="mb-3">
                            <label for="editNoticeMaterial" class="form-label">Material File:</label>
                            <input type="file" id="editNoticeMaterial" name="edit_notice_material" class="form-control" accept=".pdf,.doc,.docx,.xls,.xlsx" />
                            <?php if (!empty($notice['notice_material'])) { ?>
                                <p class="form-text">
                                    <strong>
                                        <a href="<?= get_site_option('dashboard_url') . "assets/uploads/documents/notices/" . htmlspecialchars($notice['notice_material']) ?>" class="text-primary" target="_blank">
                                            View Current File
                                        </a>
                                    </strong>
                                    Upload a new file only if you wish to replace the current one.
                                </p>
                            <?php } else { ?>
                                <p class="form-text">Upload a new file only if you wish to have one.</p>
                            <?php } ?>
                        </div>
                    </div>
                </div>
                <div class="mb-3">
                    <button type="reset" class="btn btn-secondary">Reset</button>
                    <button type="submit" class="btn btn-primary" id="submitEditNotice">Save Changes</button>
                </div>
            </form>
        </div>
    </div>
</div>

<script>
  tinymce.init({
    selector: 'textarea.tinymce',
    plugins: [
      // Core editing features
      'anchor', 'autolink', 'charmap', 'codesample', 'emoticons', 'link', 'lists', 'media', 'searchreplace', 'table', 'visualblocks', 'wordcount',
      // Your account includes a free trial of TinyMCE premium features
      // Try the most popular premium features until Jan 11, 2026:
      'checklist', 'mediaembed', 'casechange', 'formatpainter', 'pageembed', 'a11ychecker', 'tinymcespellchecker', 'permanentpen', 'powerpaste', 'advtable', 'advcode', 'advtemplate', 'ai', 'uploadcare', 'mentions', 'tinycomments', 'tableofcontents', 'footnotes', 'mergetags', 'autocorrect', 'typography', 'inlinecss', 'markdown','importword', 'exportword', 'exportpdf'
    ],
    toolbar: 'undo redo | blocks fontfamily fontsize | bold italic underline strikethrough | link media table mergetags | addcomment showcomments | spellcheckdialog a11ycheck typography uploadcare | align lineheight | checklist numlist bullist indent outdent | emoticons charmap | removeformat',
    tinycomments_mode: 'embedded',
    tinycomments_author: 'Author name',
    mergetags_list: [
      { value: 'First.Name', title: 'First Name' },
      { value: 'Email', title: 'Email' },
    ],
    ai_request: (request, respondWith) => respondWith.string(() => Promise.reject('See docs to implement AI Assistant')),
    uploadcare_public_key: 'c0bdbc79f0400ceff222',
  });
</script>

<script>
    const editNoticeForm = document.getElementById('editNoticeForm');
    if (editNoticeForm) {
        editNoticeForm.onsubmit = function(e) {
            e.preventDefault();

            const btn = document.getElementById('submitEditNotice');
            btn.disabled = true;
            btn.textContent = 'Saving...';

            const noticeId = document.getElementById('editNoticeId').value.trim();
            const noticeNumber = document.getElementById('editNoticeNumber').value.trim();
            const noticeTitle = document.getElementById('editNoticeTitle').value.trim();
            const noticeSingleLine = document.getElementById('editNoticeSingleLine').value.trim();
            const noticeCategory = document.getElementById('editNoticeCategory').value.trim();
            const noticeBadge = document.getElementById('editNoticeBadge').value.trim();
            const noticeExcerpt = document.getElementById('editNoticeExcerpt').value.trim();
            const noticeContent = tinymce.get('editNoticeContent').getContent();
            const noticeMaterialTitle = document.getElementById('editNoticeMaterialTitle').value.trim();
            const noticeMaterialInput = document.getElementById('editNoticeMaterial');
            const noticeMaterial = noticeMaterialInput && noticeMaterialInput.files.length ? noticeMaterialInput.files[0] : null;
            const csrfToken = document.querySelector('input[name="csrf_token"]').value;

            if (!noticeId || !noticeNumber || !noticeTitle || !noticeSingleLine || !noticeCategory || !noticeExcerpt || !noticeContent || !csrfToken) {
                Swal.fire('Validation Error', 'Please fill all required fields.', 'warning');
                btn.disabled = false; btn.textContent = 'Save Changes';
                return;
            }

            const formData = new FormData();
            formData.append('notice_id', noticeId);
            formData.append('notice_number', noticeNumber);
            formData.append('notice_title', noticeTitle);
            formData.append('notice_single_line', noticeSingleLine);
            formData.append('notice_category', noticeCategory);
            formData.append('notice_badge', noticeBadge);
            formData.append('notice_excerpt', noticeExcerpt);
            formData.append('notice_content', noticeContent);
            formData.append('notice_material_title', noticeMaterialTitle);
            formData.append('csrf_token', csrfToken);
            if (noticeMaterial) {
                formData.append('notice_material', noticeMaterial);
            }

            fetch('assets/includes/functions/ajax-handlers/notices/edit_notice.php', {
                method: 'POST',
                body: formData
            })
            .then(res => res.json())
            .then(data => {
                if (data.success) {
                    Swal.fire('Success', 'Notice updated successfully.', 'success').then(() => {
                        window.location.href = '<?= get_site_option('dashboard_url') ?>?page=notices-management';
                    });
                } else {
                    Swal.fire('Error', data.error || 'Failed to update notice.', 'error');
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