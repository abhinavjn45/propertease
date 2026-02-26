<div class="d-flex flex-wrap align-items-center justify-content-between gap-3 mb-24">
    <h6 class="fw-semibold mb-0">Add AGBM</h6>
    <ul class="d-flex align-items-center gap-2">
        <li class="fw-medium">
            <a href="<?= get_site_option('dashboard_url') ?>" class="d-flex align-items-center gap-1 hover-text-primary">
                <iconify-icon icon="solar:home-smile-angle-outline" class="icon text-lg"></iconify-icon>
                Dashboard
            </a>
        </li>
        <li>/</li>
        <li class="fw-medium">Add New AGBM</li>
    </ul>
</div>

<div class="card basic-data-table">
    <div class="card-header d-flex align-items-center justify-content-between">
        <div class="content">
            <h5 class="card-title mb-0">Add New AGBM</h5>
            <p class="text-muted mb-0">Fields with <span class="text-danger">*</span> are required.</p>
        </div>
        <a href="<?= get_site_option('dashboard_url') ?>?page=agbms-management" class="btn btn-primary d-inline-flex align-items-center gap-2">
            <iconify-icon icon="solar:clipboard-list-outline" class="icon text-lg"></iconify-icon>
            All AGBMs
        </a>
    </div>
    <div class="card-body">
        <div class="row gy-3">
            <form id="addAgbmForm">
                <?php 
                    echo csrf_input_field(); 
                ?>
                <div class="row">
                    <div class="col-md-4">
                        <div class="">
                            <label for="agbmNumber" class="form-label">AGBM Number:<span class="text-danger">*</span></label>
                            <input type="text" id="agbmNumber" name="agbm_number" class="form-control" required>
                        </div>
                    </div>
                    <div class="col-md-8">
                        <div class="">
                            <label for="agbmTitle" class="form-label">AGBM Title:<span class="text-danger">*</span></label>
                            <input type="text" id="agbmTitle" name="agbm_title" class="form-control" required>
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
                            <label for="agbmSingleLine" class="form-label">AGBM Single Line:<span class="text-danger">*</span></label>
                            <textarea id="agbmSingleLine" name="agbm_single_line" class="form-control" rows="1" required style="resize: none;"></textarea>
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
                        <div class="">
                            <label for="agbmExcerpt" class="form-label">AGBM Excerpt:<span class="text-danger">*</span></label>
                            <textarea id="agbmExcerpt" name="agbm_excerpt" class="form-control" rows="2" style="resize: none;"></textarea>
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
                            <label for="agbmContent" class="form-label">AGBM Content:<span class="text-danger">*</span></label>
                            <textarea id="agbmContent" name="agbm_content" class="form-control tinymce" rows="4" style="resize: none;"></textarea>
                        </div>
                    </div>
                    <div class="col-md-12">
                        <div class="mb-3">
                            <label for="agbmVideoLink" class="form-label">AGBM Video Link:</label>
                            <input type="url" id="agbmVideoLink" name="agbm_video_link" class="form-control">
                        </div>
                    </div>
                    <div class="col-md-6">
                        <div class="mb-3">
                            <label for="agbmMaterialTitle" class="form-label">AGBM Material Title:</label>
                            <input type="text" id="agbmMaterialTitle" name="agbm_material_title" class="form-control">
                        </div>
                    </div>
                    <div class="col-md-6">
                        <div class="mb-3">
                            <label for="agbmMaterialFile" class="form-label">AGBM Material File:</label>
                            <input type="file" id="agbmMaterialFile" name="agbm_material_file" class="form-control mt-2" accept=".pdf,.doc,.docx,.xls,.xlsx">
                        </div>
                    </div>
                </div>
                <div class="mb-3">
                    <button type="reset" class="btn btn-secondary">Reset</button>
                    <button type="submit" class="btn btn-primary" id="submitAddAgbm">Save AGBM</button>
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
    document.addEventListener('DOMContentLoaded', function() {
        const agbmTitleInput = document.getElementById('agbmTitle');
        const agbmSingleLineInput = document.getElementById('agbmSingleLine');
        const agbmExcerptInput = document.getElementById('agbmExcerpt');
        const liveCountDisplay = agbmTitleInput.parentElement.querySelector('.live-count');
        const liveCountDisplaySingleLine = agbmSingleLineInput.parentElement.querySelector('.live-count');
        const liveCountDisplayExcerpt = agbmExcerptInput.parentElement.querySelector('.live-count');

        const materialTitleInput = document.getElementById('agbmMaterialTitle');
        const materialFileInput = document.getElementById('agbmMaterialFile');

        function updateMaterialRequired() {
            const hasTitle = materialTitleInput && materialTitleInput.value.trim().length > 0;
            const hasFile = materialFileInput && materialFileInput.files && materialFileInput.files.length > 0;
            const required = hasTitle || hasFile;
            if (materialTitleInput) materialTitleInput.required = required;
            if (materialFileInput) materialFileInput.required = required;
        }

        if (materialTitleInput) materialTitleInput.addEventListener('input', updateMaterialRequired);
        if (materialFileInput) materialFileInput.addEventListener('change', updateMaterialRequired);
        updateMaterialRequired();

        agbmTitleInput.addEventListener('input', function() {
            const currentLength = agbmTitleInput.value.length;
                if (currentLength > 70) {
                    liveCountDisplay.classList.add('text-danger');
                } else {
                    liveCountDisplay.classList.remove('text-danger');
                }
            liveCountDisplay.textContent = `Character Count: ${currentLength}`;
        });
        
        agbmSingleLineInput.addEventListener('input', function() {
            const currentLength = agbmSingleLineInput.value.length;
                if (currentLength > 50) {
                    liveCountDisplaySingleLine.classList.add('text-danger');
                } else {
                    liveCountDisplaySingleLine.classList.remove('text-danger');
                }
            liveCountDisplaySingleLine.textContent = `Character Count: ${currentLength}`;
        });

        agbmExcerptInput.addEventListener('input', function() {
            const currentLength = agbmExcerptInput.value.length;
                if (currentLength > 130) {
                    liveCountDisplayExcerpt.classList.add('text-danger');
                } else {
                    liveCountDisplayExcerpt.classList.remove('text-danger');
                }
            liveCountDisplayExcerpt.textContent = `Character Count: ${currentLength}`;
        });
    });
</script>

<script>
    // Handle Add AGBM form submit
    const addAgbmForm = document.getElementById('addAgbmForm');
    if (addAgbmForm) {
        addAgbmForm.onsubmit = function(e) {
            e.preventDefault();

            const btn = document.getElementById('submitAddAgbm');
            btn.disabled = true;
            btn.textContent = 'Saving...';

            const agbmNumber = document.getElementById('agbmNumber').value.trim();
            const agbmTitle = document.getElementById('agbmTitle').value.trim();
            const agbmSingleLine = document.getElementById('agbmSingleLine').value.trim();
            const agbmExcerpt = document.getElementById('agbmExcerpt').value.trim();
            const agbmContent = tinymce.get('agbmContent').getContent().trim();
            const agbmVideoLink = document.getElementById('agbmVideoLink').value.trim();
            const agbmMaterialTitle = document.getElementById('agbmMaterialTitle').value.trim();
            const agbmMaterialFileInput = document.getElementById('agbmMaterialFile').files[0];
            const csrf_token = document.querySelector('input[name="csrf_token"]').value;

            if (!agbmNumber || !agbmTitle || !agbmSingleLine || !agbmExcerpt || !agbmContent || !csrf_token) {
                Swal.fire('Validation Error', 'Please fill all required fields.', 'warning');
                btn.disabled = false; btn.textContent = 'Save AGBM';
                return;
            }

            const materialAny = agbmMaterialTitle.length > 0 || !!agbmMaterialFileInput;
            const materialBoth = agbmMaterialTitle.length > 0 && !!agbmMaterialFileInput;
            if (materialAny && !materialBoth) {
                Swal.fire('Validation Error', 'Provide both Material Title and Material File or leave both empty.', 'warning');
                btn.disabled = false; btn.textContent = 'Save AGBM';
                return;
            }

            const formData = new FormData();
            formData.append('agbm_number', agbmNumber);
            formData.append('agbm_title', agbmTitle);
            formData.append('agbm_single_line', agbmSingleLine);
            formData.append('agbm_excerpt', agbmExcerpt);
            formData.append('agbm_content', agbmContent);
            formData.append('agbm_video_link', agbmVideoLink);
            formData.append('agbm_material_title', agbmMaterialTitle);
            formData.append('agbm_material_file', agbmMaterialFileInput);
            formData.append('csrf_token', csrf_token);

            fetch('assets/includes/functions/ajax-handlers/agbms/add_new_agbm.php', {
                method: 'POST',
                body: formData
            })
            .then(res => res.json())
            .then(data => {
                if (data.success) {
                    Swal.fire('Success', 'AGBM added successfully.', 'success').then(() => {
                        window.location.href = '<?= get_site_option('dashboard_url') ?>?page=agbms-management';
                    });
                } else {
                    Swal.fire('Error', data.error || 'Failed to add AGBM.', 'error');
                }
            })
            .catch (err => {
                Swal.fire('Error', 'An error occurred while saving.', 'error');
            })
            .finally(() => {
                btn.disabled = false; btn.textContent = 'Save AGBM';
            });
        }
    }
</script>