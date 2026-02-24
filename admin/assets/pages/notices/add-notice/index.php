<div class="d-flex flex-wrap align-items-center justify-content-between gap-3 mb-24">
    <h6 class="fw-semibold mb-0">Add Notice</h6>
    <ul class="d-flex align-items-center gap-2">
        <li class="fw-medium">
            <a href="<?= get_site_option('dashboard_url') ?>" class="d-flex align-items-center gap-1 hover-text-primary">
                <iconify-icon icon="solar:home-smile-angle-outline" class="icon text-lg"></iconify-icon>
                Dashboard
            </a>
        </li>
        <li>/</li>
        <li class="fw-medium">Add New Notice</li>
    </ul>
</div>

<div class="card basic-data-table">
    <div class="card-header d-flex align-items-center justify-content-between">
        <div class="content">
            <h5 class="card-title mb-0">Add New Notice</h5>
            <p class="text-muted mb-0">Fields with <span class="text-danger">*</span> are required.</p>
        </div>
        <a href="<?= get_site_option('dashboard_url') ?>?page=notices-management" class="btn btn-primary d-inline-flex align-items-center gap-2">
            <iconify-icon icon="solar:clipboard-list-outline" class="icon text-lg"></iconify-icon>
            All Notices
        </a>
    </div>
    <div class="card-body">
        <div class="row gy-3">
            <form id="addNoticeForm">
                <?php 
                    echo csrf_input_field(); 
                ?>
                <div class="row">
                    <div class="col-md-3">
                        <div class="">
                            <label for="noticeNumber" class="form-label">Notice Number:<span class="text-danger">*</span></label>
                            <input type="text" id="noticeNumber" name="notice_number" class="form-control" required>
                        </div>
                    </div>
                    <div class="col-md-9">
                        <div class="">
                            <label for="noticeTitle" class="form-label">Notice Title:<span class="text-danger">*</span></label>
                            <input type="text" id="noticeTitle" name="notice_title" class="form-control" required>
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
                            <label for="noticeSingleLine" class="form-label">Notice Single Line:<span class="text-danger">*</span></label>
                            <textarea id="noticeSingleLine" name="notice_single_line" class="form-control" rows="1" required style="resize: none;"></textarea>
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
                            <label for="noticeCategory" class="form-label">Notice Category:<span class="text-danger">*</span></label>
                            <select id="noticeCategory" name="notice_category" class="form-select" required>
                                <?= get_notice_categories_select_box('add-notice') ?>
                            </select>
                        </div>
                    </div>
                    <div class="col-md-3">
                        <div class="">
                            <label for="noticeBadge" class="form-label">Notice Badge:</label>
                            <input type="text" id="noticeBadge" name="notice_badge" class="form-control">
                            <p class="form-text">(Optional)</p>
                        </div>
                    </div>
                    <div class="col-md-9">
                        <div class="">
                            <label for="noticeExcerpt" class="form-label">Notice Excerpt:<span class="text-danger">*</span></label>
                            <textarea id="noticeExcerpt" name="notice_excerpt" class="form-control" rows="2" style="resize: none;"></textarea>
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
                            <label for="noticeContent" class="form-label">Notice Content:<span class="text-danger">*</span></label>
                            <textarea id="noticeContent" name="notice_content" class="form-control tinymce" rows="4" style="resize: none;"></textarea>
                        </div>
                    </div>
                    <div class="col-md-6">
                        <div class="mb-3">
                            <label for="noticeMaterialTitle" class="form-label">Notice Material Title:</label>
                            <input type="text" id="noticeMaterialTitle" name="notice_material_title" class="form-control">
                        </div>
                    </div>
                    <div class="col-md-6">
                        <div class="mb-3">
                            <label for="noticeMaterialFile" class="form-label">Notice Material File:</label>
                            <input type="file" id="noticeMaterialFile" name="notice_material_file" class="form-control mt-2" accept=".pdf,.doc,.docx,.xls,.xlsx">
                        </div>
                    </div>
                </div>
                <div class="mb-3">
                    <button type="reset" class="btn btn-secondary">Reset</button>
                    <button type="submit" class="btn btn-primary" id="submitAddNotice">Save Notice</button>
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
        const noticeTitleInput = document.getElementById('noticeTitle');
        const noticeSingleLineInput = document.getElementById('noticeSingleLine');
        const noticeExcerptInput = document.getElementById('noticeExcerpt');
        const liveCountDisplay = noticeTitleInput.parentElement.querySelector('.live-count');
        const liveCountDisplaySingleLine = noticeSingleLineInput.parentElement.querySelector('.live-count');
        const liveCountDisplayExcerpt = noticeExcerptInput.parentElement.querySelector('.live-count');

        const materialTitleInput = document.getElementById('noticeMaterialTitle');
        const materialFileInput = document.getElementById('noticeMaterialFile');

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

        noticeTitleInput.addEventListener('input', function() {
            const currentLength = noticeTitleInput.value.length;
                if (currentLength > 70) {
                    liveCountDisplay.classList.add('text-danger');
                } else {
                    liveCountDisplay.classList.remove('text-danger');
                }
            liveCountDisplay.textContent = `Character Count: ${currentLength}`;
        });
        
        noticeSingleLineInput.addEventListener('input', function() {
            const currentLength = noticeSingleLineInput.value.length;
                if (currentLength > 50) {
                    liveCountDisplaySingleLine.classList.add('text-danger');
                } else {
                    liveCountDisplaySingleLine.classList.remove('text-danger');
                }
            liveCountDisplaySingleLine.textContent = `Character Count: ${currentLength}`;
        });

        noticeExcerptInput.addEventListener('input', function() {
            const currentLength = noticeExcerptInput.value.length;
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
    // Handle Add Notice form submit
    const addNoticeForm = document.getElementById('addNoticeForm');
    if (addNoticeForm) {
        addNoticeForm.onsubmit = function(e) {
            e.preventDefault();

            const btn = document.getElementById('submitAddNotice');
            btn.disabled = true;
            btn.textContent = 'Saving...';

            const noticeNumber = document.getElementById('noticeNumber').value.trim();
            const noticeTitle = document.getElementById('noticeTitle').value.trim();
            const noticeSingleLine = document.getElementById('noticeSingleLine').value.trim();
            const noticeCategory = document.getElementById('noticeCategory').value.trim();
            const noticeBadge = document.getElementById('noticeBadge').value.trim();
            const noticeExcerpt = document.getElementById('noticeExcerpt').value.trim();
            const noticeContent = tinymce.get('noticeContent').getContent().trim();
            const noticeMaterialTitle = document.getElementById('noticeMaterialTitle').value.trim();
            const noticeMaterialFileInput = document.getElementById('noticeMaterialFile').files[0];
            const csrf_token = document.querySelector('input[name="csrf_token"]').value;

            if (!noticeNumber || !noticeTitle || !noticeSingleLine || !noticeCategory || !noticeExcerpt || !noticeContent || !csrf_token) {
                Swal.fire('Validation Error', 'Please fill all fields.', 'warning');
                btn.disabled = false; btn.textContent = 'Save Notice';
                return;
            }

            const materialAny = noticeMaterialTitle.length > 0 || !!noticeMaterialFileInput;
            const materialBoth = noticeMaterialTitle.length > 0 && !!noticeMaterialFileInput;
            if (materialAny && !materialBoth) {
                Swal.fire('Validation Error', 'Provide both Material Title and Material File or leave both empty.', 'warning');
                btn.disabled = false; btn.textContent = 'Save Notice';
                return;
            }

            const formData = new FormData();
            formData.append('action', 'add_notice');
            formData.append('notice_number', noticeNumber);
            formData.append('notice_title', noticeTitle);
            formData.append('notice_single_line', noticeSingleLine);
            formData.append('notice_category', noticeCategory);
            formData.append('notice_badge', noticeBadge);
            formData.append('notice_excerpt', noticeExcerpt);
            formData.append('notice_content', noticeContent);
            formData.append('notice_material_title', noticeMaterialTitle);
            formData.append('notice_material_file', noticeMaterialFileInput);
            formData.append('csrf_token', csrf_token);

            fetch('assets/includes/functions/ajax-handlers/notices/add_new_notice.php', {
                method: 'POST',
                body: formData
            })
            .then(res => res.json())
            .then(data => {
                if (data.success) {
                    Swal.fire('Success', 'Notice added successfully.', 'success').then(() => {
                        // Refresh the page or redirect
                        window.location.reload();
                    });
                } else {
                    Swal.fire('Error', data.error || 'Failed to add notice.', 'error').then(() => {
                        window.location.reload();
                    });
                }
            })
            .catch (err => {
                Swal.fire('Error', 'An error occurred while saving.', 'error').then(() => {
                    window.location.reload();
                });
            })
            .finally(() => {
                btn.disabled = false; btn.textContent = 'Save Notice';
            });
        }
    }
</script>