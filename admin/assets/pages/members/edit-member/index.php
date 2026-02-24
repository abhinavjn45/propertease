<?php 
    $member_id = isset($_GET['member_id']) ? trim($_GET['member_id']) : '';
    if (!empty($member_id)) {
        $member = get_member_details($member_id, null, null);
        if ($member) {
?>
<div class="d-flex flex-wrap align-items-center justify-content-between gap-3 mb-24">
    <h6 class="fw-semibold mb-0">Edit Member</h6>
    <ul class="d-flex align-items-center gap-2">
        <li class="fw-medium">
            <a href="<?= get_site_option('dashboard_url') ?>" class="d-flex align-items-center gap-1 hover-text-primary">
                <iconify-icon icon="solar:home-smile-angle-outline" class="icon text-lg"></iconify-icon>
                Dashboard
            </a>
        </li>
        <li>/</li>
        <li class="fw-medium">Edit Member</li>
    </ul>
</div>

<div class="card basic-data-table">
    <div class="card-header d-flex align-items-center justify-content-between">
        <h5 class="card-title mb-0">Edit Member</h5>
        <a href="<?= get_site_option('dashboard_url') ?>?page=members-management" class="btn btn-secondary d-inline-flex align-items-center gap-2">
            <iconify-icon icon="proicons:cancel-circle" class="icon text-lg"></iconify-icon>
            Cancel
        </a>
    </div>
    <div class="card-body">
        <div class="row gy-3">
            <form id="editMemberForm" enctype="multipart/form-data">
                <?php 
                    echo csrf_input_field(); 
                ?>
                <input type="hidden" id="editMemberId" value="<?= htmlspecialchars($member_id) ?>" readonly required>
                <div class="row">
                    <div class="col-md-3">
                        <div class="mb-3">
                            <label for="editMemberUniqueId" class="form-label">Unique ID:<span class="text-danger">*</span></label>
                            <input type="text" id="editMemberUniqueId" class="form-control" value="<?= htmlspecialchars($member['member_unique_id']) ?>" required readonly>
                            <p class="form-text">Unique ID cannot be changed.</p>
                        </div>
                    </div>
                    <div class="col-md-9">
                        <label for="editMemberFullname" class="form-label">Member Salutation & Full Name:<span class="text-danger">*</span></label>
                        <div class="input-group mb-3">
                            <select class="form-select w-auto flex-grow-0" id="editMemberSalutation" name="edit_member_salutation" required>
                                <option <?= (empty($member['member_salutation'])) ? 'selected' : '' ?> disabled>Select Salutation</option>
                                <option value="MR." <?= ($member['member_salutation'] == 'MR.') ? 'selected' : '' ?>>Mr.</option>
                                <option value="MRS." <?= ($member['member_salutation'] == 'MRS.') ? 'selected' : '' ?>>Mrs.</option>
                                <option value="MISS" <?= ($member['member_salutation'] == 'MISS') ? 'selected' : '' ?>>Miss</option>
                                <option value="MS." <?= ($member['member_salutation'] == 'MS.') ? 'selected' : '' ?>>Ms.</option>
                                <option value="DR." <?= ($member['member_salutation'] == 'DR.') ? 'selected' : '' ?>>Dr.</option>
                                <option value="SHRI" <?= ($member['member_salutation'] == 'SHRI') ? 'selected' : '' ?>>Shri</option>
                                <option value="SMT." <?= ($member['member_salutation'] == 'SMT.') ? 'selected' : '' ?>>Smt.</option>
                                <option value="KR." <?= ($member['member_salutation'] == 'KR.') ? 'selected' : '' ?>>Kumar</option>
                                <option value="KM." <?= ($member['member_salutation'] == 'KM.') ? 'selected' : '' ?>>Kumari</option>
                            </select>
                            <input type="text" class="form-control flex-grow-1" id="editMemberFullname" name="edit_member_fullname" value="<?= ucwords(strtolower(htmlspecialchars($member['member_fullname']))) ?>" required placeholder="Enter Member's Full Name">
                        </div>
                    </div>
                    <div class="col-md-6">
                        <label for="editMemberBlockFlat" class="form-label">Member Block & Flat Number:<span class="text-danger">*</span></label>
                        <div class="input-group mb-3">
                            <select class="form-select w-auto flex-grow-0" id="editMemberBlock" name="edit_member_block" required>
                                <option <?= (empty($member['member_block'])) ? 'selected' : '' ?> disabled>Select Block</option>
                                <option value="A" <?= ($member['member_block'] == 'A') ? 'selected' : '' ?>>A</option>
                                <option value="B" <?= ($member['member_block'] == 'B') ? 'selected' : '' ?>>B</option>
                                <option value="C" <?= ($member['member_block'] == 'C') ? 'selected' : '' ?>>C</option>
                                <option value="D" <?= ($member['member_block'] == 'D') ? 'selected' : '' ?>>D</option>
                                <option value="E" <?= ($member['member_block'] == 'E') ? 'selected' : '' ?>>E</option>
                                <option value="F" <?= ($member['member_block'] == 'F') ? 'selected' : '' ?>>F</option>
                                <option value="G" <?= ($member['member_block'] == 'G') ? 'selected' : '' ?>>G</option>
                            </select>
                            <input type="text" class="form-control flex-grow-1" id="editMemberFlatNumber" name="edit_member_flat_number" value="<?= htmlspecialchars($member['member_flat_number']) ?>" required placeholder="Enter Member's Flat Number">
                        </div>
                    </div>
                    <div class="col-md-6">
                        <div class="">
                            <label for="editMemberEmail" class="form-label">Email:<span class="text-danger">*</span></label>
                            <input type="email" id="editMemberEmail" name="edit_member_email" class="form-control" value="<?= strtolower(htmlspecialchars($member['member_email'])) ?>" required placeholder="Enter Member's Email Address">
                        </div>
                    </div>
                    <div class="col-md-6">
                        <label for="editMemberPhoneNumber" class="form-label">Member Phone Number:<span class="text-danger">*</span></label>
                        <div class="input-group mb-3">
                            <select class="form-select w-auto flex-grow-0" id="editMemberCountryCode" name="edit_member_country_code" required>
                                <?= load_phone_codes(explode(' ', $member['member_phone_number'])[0]) ?>
                            </select>
                            <input type="text" class="form-control flex-grow-1" id="editMemberPhoneNumber" name="edit_member_phone_number" required placeholder="Enter Member's Phone Number" value="<?= htmlspecialchars(substr($member['member_phone_number'], strpos($member['member_phone_number'], ' ') + 1)) ?>">
                        </div>
                    </div>
                    <div class="col-md-3">
                        <div class="mb-3">
                            <label for="editMemberType" class="form-label">Member Type:<span class="text-danger">*</span></label>
                            <select id="editMemberType" name="edit_member_type" class="form-select" required>
                                <option <?= ($member['member_type'] == '') ? 'selected' : '' ?> disabled>Select Member Type</option>
                                <option value="Owner" <?= ($member['member_type'] == 'Owner') ? 'selected' : '' ?>>Owner</option>
                                <option value="Tenant" <?= ($member['member_type'] == 'Tenant') ? 'selected' : '' ?>>Tenant</option>
                            </select>
                        </div>
                    </div>
                    <div class="col-md-3">
                        <div class="mb-3">
                            <label for="editMemberImage" class="form-label">Member Image:</label>
                            <input type="file" id="editMemberImage" name="edit_member_image" class="form-control mt-2" accept="image/*">
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

            const memberId = document.getElementById('editMemberId').value.trim();
            const memberUniqueId = document.getElementById('editMemberUniqueId').value.trim();
            const memberSalutation = document.getElementById('editMemberSalutation').value.trim();
            const memberFullname = document.getElementById('editMemberFullname').value.trim();
            const memberBlock = document.getElementById('editMemberBlock').value.trim();
            const memberFlatNumber = document.getElementById('editMemberFlatNumber').value.trim();
            const memberEmail = document.getElementById('editMemberEmail').value.trim();
            const memberCountryCode = document.getElementById('editMemberCountryCode').value.trim();
            const memberPhoneNumber = document.getElementById('editMemberPhoneNumber').value.trim();
            const memberType = document.getElementById('editMemberType').value.trim();
            const memberImageInput = document.getElementById('editMemberImage');
            const memberImage = memberImageInput && memberImageInput.files.length ? memberImageInput.files[0] : null;
            const csrfToken = document.querySelector('input[name="csrf_token"]').value;

            if (!memberId || !memberUniqueId || !memberSalutation || !memberFullname || !memberBlock || !memberFlatNumber || !memberEmail || !memberCountryCode || !memberPhoneNumber || !memberType || !csrfToken) {
                Swal.fire('Validation Error', 'Please fill all required fields.', 'warning');
                btn.disabled = false; btn.textContent = 'Save Changes';
                return;
            }

            const formData = new FormData();
            formData.append('member_id', memberId);
            formData.append('member_unique_id', memberUniqueId);
            formData.append('member_salutation', memberSalutation);
            formData.append('member_fullname', memberFullname);
            formData.append('member_block', memberBlock);
            formData.append('member_flat_number', memberFlatNumber);
            formData.append('member_email', memberEmail);
            formData.append('member_country_code', memberCountryCode);
            formData.append('member_phone_number', memberPhoneNumber);
            formData.append('member_type', memberType);
            formData.append('csrf_token', csrfToken);
            if (memberImage) {
                formData.append('member_image', memberImage);
            }

            fetch('assets/includes/functions/ajax-handlers/members/edit_member.php', {
                method: 'POST',
                body: formData
            })
            .then(res => res.json())
            .then(data => {
                if (data.success) {
                    Swal.fire('Success', 'Member updated successfully.', 'success').then(() => {
                        window.location.href = '<?= get_site_option('dashboard_url') ?>?page=members-management';
                    });
                } else {
                    Swal.fire('Error', data.error || 'Failed to update member.', 'error');
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