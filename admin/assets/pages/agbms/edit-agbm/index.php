<?php 
    $agbm_id = isset($_GET['agbm_id']) ? trim($_GET['agbm_id']) : '';
    if (!empty($agbm_id)) {
        $agbm = get_agbm_details($agbm_id);
        if ($agbm) {
?>
<div class="d-flex flex-wrap align-items-center justify-content-between gap-3 mb-24">
    <h6 class="fw-semibold mb-0">Edit AGBM</h6>
    <ul class="d-flex align-items-center gap-2">
        <li class="fw-medium">
            <a href="<?= get_site_option('dashboard_url') ?>" class="d-flex align-items-center gap-1 hover-text-primary">
                <iconify-icon icon="solar:home-smile-angle-outline" class="icon text-lg"></iconify-icon>
                Dashboard
            </a>
        </li>
        <li>/</li>
        <li class="fw-medium">Edit AGBM</li>
    </ul>
</div>

<div class="card basic-data-table">
    <div class="card-header d-flex align-items-center justify-content-between">
        <h5 class="card-title mb-0">Edit AGBM</h5>
        <a href="<?= get_site_option('dashboard_url') ?>?page=agbms-management" class="btn btn-secondary d-inline-flex align-items-center gap-2">
            <iconify-icon icon="proicons:cancel-circle" class="icon text-lg"></iconify-icon>
            Cancel
        </a>
    </div>
    <div class="card-body">
        <div class="row gy-3">
            <form id="editAgbmForm">
                <?php 
                    echo csrf_input_field(); 
                ?>
                <input type="hidden" id="editAgbmId" value="<?= htmlspecialchars($agbm_id) ?>" readonly required>
                <div class="row">
                    <div class="col-md-4">
                        <div class="mb-3">
                            <label for="editAgbmNumber" class="form-label">Number:<span class="text-danger">*</span></label>
                            <input type="text" id="editAgbmNumber" class="form-control" value="<?= htmlspecialchars($agbm['agbm_number']) ?>" required>
                        </div>
                    </div>
                    <div class="col-md-8">
                        <div class="">
                            <label for="editAgbmTitle" class="form-label">Title:<span class="text-danger">*</span></label>
                            <input type="text" id="editAgbmTitle" class="form-control" value="<?= htmlspecialchars($agbm['agbm_title']) ?>" required />
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
                    <div class="col-md-12">
                        <div class="">
                            <label for="editAgbmSingleLine" class="form-label">Single Line:<span class="text-danger">*</span></label>
                            <textarea id="editAgbmSingleLine" class="form-control" rows="1" style="resize: none;" required><?= htmlspecialchars($agbm['agbm_single_line']) ?></textarea>
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
                    <div class="col-md-12">
                        <div class="mb-3">
                            <label for="editAgbmExcerpt" class="form-label">Excerpt:<span class="text-danger">*</span></label>
                            <textarea id="editAgbmExcerpt" class="form-control" rows="2" style="resize: none;" required><?= htmlspecialchars($agbm['agbm_excerpt']) ?></textarea>
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
                            <label for="editAgbmContent" class="form-label">Content:<span class="text-danger">*</span></label>
                            <textarea id="editAgbmContent" class="form-control tinymce" rows="4" style="resize: none;" required><?= htmlspecialchars($agbm['agbm_content']) ?></textarea>
                        </div>
                    </div>
                    <div class="col-md-12">
                        <div class="mb-3">
                            <label for="editAgbmVideoLink" class="form-label">Video Link:</label>
                            <input type="url" id="editAgbmVideoLink" name="edit_agbm_video_link" class="form-control" value="<?= htmlspecialchars($agbm['agbm_video_link']) ?>" />
                        </div>
                    </div>
                    <div class="col-md-6">
                        <div class="mb-3">
                            <label for="editAgbmMaterialTitle" class="form-label">Material Title:</label>
                            <input type="text" id="editAgbmMaterialTitle" name="edit_agbm_material_title" class="form-control" value="<?= htmlspecialchars($agbm['agbm_material_title']) ?>" />
                        </div>
                    </div>
                    <div class="col-md-6">
                        <div class="mb-3">
                            <label for="editAgbmMaterial" class="form-label">Material File:</label>
                            <input type="file" id="editAgbmMaterial" name="edit_agbm_material" class="form-control" accept=".pdf,.doc,.docx,.xls,.xlsx" />
                            <?php if (!empty($agbm['agbm_material'])) { ?>
                                <p class="form-text">
                                    <strong>
                                        <a href="<?= get_site_option('dashboard_url') . "assets/uploads/documents/agbms/" . htmlspecialchars($agbm['agbm_material']) ?>" class="text-primary" target="_blank">
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
                    <button type="submit" class="btn btn-primary" id="submitEditAgbm">Save Changes</button>
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
    const editAgbmForm = document.getElementById('editAgbmForm');
    if (editAgbmForm) {
        editAgbmForm.onsubmit = function(e) {
            e.preventDefault();

            const btn = document.getElementById('submitEditAgbm');
            btn.disabled = true;
            btn.textContent = 'Saving...';

            const agbmId = document.getElementById('editAgbmId').value.trim();
            const agbmNumber = document.getElementById('editAgbmNumber').value.trim();
            const agbmTitle = document.getElementById('editAgbmTitle').value.trim();
            const agbmSingleLine = document.getElementById('editAgbmSingleLine').value.trim();
            const agbmExcerpt = document.getElementById('editAgbmExcerpt').value.trim();
            const agbmContent = tinymce.get('editAgbmContent').getContent();
            const agbmVideoLink = document.getElementById('editAgbmVideoLink').value.trim();
            const agbmMaterialTitle = document.getElementById('editAgbmMaterialTitle').value.trim();
            const agbmMaterialInput = document.getElementById('editAgbmMaterial');
            const agbmMaterial = agbmMaterialInput && agbmMaterialInput.files.length ? agbmMaterialInput.files[0] : null;
            const csrfToken = document.querySelector('input[name="csrf_token"]').value;

            if (!agbmId || !agbmNumber || !agbmTitle || !agbmSingleLine || !agbmExcerpt || !agbmContent || !csrfToken) {
                Swal.fire('Validation Error', 'Please fill all required fields.', 'warning');
                btn.disabled = false; btn.textContent = 'Save Changes';
                return;
            }

            const formData = new FormData();
            formData.append('agbm_id', agbmId);
            formData.append('agbm_number', agbmNumber);
            formData.append('agbm_title', agbmTitle);
            formData.append('agbm_single_line', agbmSingleLine);
            formData.append('agbm_excerpt', agbmExcerpt);
            formData.append('agbm_content', agbmContent);
            formData.append('agbm_video_link', agbmVideoLink);
            formData.append('agbm_material_title', agbmMaterialTitle);
            formData.append('csrf_token', csrfToken);
            if (agbmMaterial) {
                formData.append('agbm_material', agbmMaterial);
            }

            fetch('assets/includes/functions/ajax-handlers/agbms/edit_agbm.php', {
                method: 'POST',
                body: formData
            })
            .then(res => res.json())
            .then(data => {
                if (data.success) {
                    Swal.fire('Success', 'AGBM updated successfully.', 'success').then(() => {
                        window.location.href = '<?= get_site_option('dashboard_url') ?>?page=agbms-management';
                    });
                } else {
                    Swal.fire('Error', data.error || 'Failed to update AGBM.', 'error');
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