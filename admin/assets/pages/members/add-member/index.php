<div class="d-flex flex-wrap align-items-center justify-content-between gap-3 mb-24">
    <h6 class="fw-semibold mb-0">Add Member</h6>
    <ul class="d-flex align-items-center gap-2">
        <li class="fw-medium">
            <a href="<?= get_site_option('dashboard_url') ?>" class="d-flex align-items-center gap-1 hover-text-primary">
                <iconify-icon icon="solar:home-smile-angle-outline" class="icon text-lg"></iconify-icon>
                Dashboard
            </a>
        </li>
        <li>/</li>
        <li class="fw-medium">Add Member</li>
    </ul>
</div>

<div class="card basic-data-table">
    <div class="card-header d-flex align-items-center justify-content-between">
        <div class="content">
            <h5 class="card-title mb-0">Add New Member</h5>
            <p class="text-muted mb-0">Fields with <span class="text-danger">*</span> are required.</p>
        </div>
        <a href="<?= get_site_option('dashboard_url') ?>?page=members-management" class="btn btn-primary d-inline-flex align-items-center gap-2">
            <iconify-icon icon="solar:clipboard-list-outline" class="icon text-lg"></iconify-icon>
            All Members
        </a>
    </div>
    <div class="card-body">
        <div class="row gy-3">
            <form id="addMemberForm" enctype="multipart/form-data">
                <?php 
                    echo csrf_input_field(); 
                ?>
                <div class="row">
                    <div class="col-md-12">
                        <label for="memberFullname" class="form-label">Member Salutation & Full Name:<span class="text-danger">*</span></label>
                        <div class="input-group mb-3">
                            <select class="form-select w-auto flex-grow-0" id="memberSalutation" name="member_salutation" required>
                                <option selected disabled>Select Salutation</option>
                                <option value="MR.">Mr.</option>
                                <option value="MRS.">Mrs.</option>
                                <option value="MISS">Miss</option>
                                <option value="MS.">Ms.</option>
                                <option value="DR.">Dr.</option>
                                <option value="SHRI">Shri</option>
                                <option value="SMT.">Smt.</option>
                                <option value="KR.">Kumar</option>
                                <option value="KM.">Kumari</option>
                            </select>
                            <input type="text" class="form-control flex-grow-1" id="memberFullname" name="member_fullname" required placeholder="Enter Member's Full Name">
                        </div>
                    </div>
                    <div class="col-md-6">
                        <label for="memberBlockFlat" class="form-label">Member Block & Flat Number:<span class="text-danger">*</span></label>
                        <div class="input-group mb-3">
                            <select class="form-select w-auto flex-grow-0" id="memberBlock" name="member_block" required>
                                <option selected disabled>Select Block</option>
                                <option value="A">A</option>
                                <option value="B">B</option>
                                <option value="C">C</option>
                                <option value="D">D</option>
                                <option value="E">E</option>
                                <option value="F">F</option>
                                <option value="G">G</option>
                            </select>
                            <input type="text" class="form-control flex-grow-1" id="memberFlatNumber" name="member_flat_number" required placeholder="Enter Member's Flat Number">
                        </div>
                    </div>
                    <div class="col-md-6">
                        <div class="mb-3">
                            <label for="memberEmail" class="form-label">Member Email:<span class="text-danger">*</span></label>
                            <input type="email" class="form-control" id="memberEmail" name="member_email" required placeholder="Enter Member's Email">
                        </div>
                    </div>
                    <div class="col-md-6">
                        <label for="memberPhoneNumber" class="form-label">Member Phone Number:<span class="text-danger">*</span></label>
                        <div class="input-group mb-3">
                            <select class="form-select w-auto flex-grow-0" id="memberCountryCode" name="member_country_code" required>
                                <?= load_phone_codes() ?>
                            </select>
                            <input type="text" class="form-control flex-grow-1" id="memberPhoneNumber" name="member_phone_number" required placeholder="Enter Member's Phone Number">
                        </div>
                    </div>
                    <div class="col-md-3">
                        <div class="mb-3">
                            <label for="memberType" class="form-label">Member Type:<span class="text-danger">*</span></label>
                            <select id="memberType" name="member_type" class="form-select" required>
                                <option selected disabled>Select Member Type</option>
                                <option value="Owner">Owner</option>
                                <option value="Tenant">Tenant</option>
                            </select>
                        </div>
                    </div>
                    <div class="col-md-3">
                        <div class="mb-3">
                            <label for="memberImage" class="form-label">Member Image:</label>
                            <input type="file" id="memberImage" name="member_image" class="form-control mt-2" accept="image/*">
                        </div>
                    </div>
                </div>
                <div class="mb-3">
                    <button type="reset" class="btn btn-secondary">Reset</button>
                    <button type="submit" class="btn btn-primary" id="submitAddMember">Add Member</button>
                </div>
            </form>
        </div>
    </div>
</div>

<script>
    // Handle Add Member form submit
    const addMemberForm = document.getElementById('addMemberForm');
    if (addMemberForm) {
        addMemberForm.onsubmit = function(e) {
            e.preventDefault();

            const btn = document.getElementById('submitAddMember');
            btn.disabled = true;
            btn.textContent = 'Adding...';

            const memberSalutation = document.getElementById('memberSalutation').value.trim();
            const memberFullname = document.getElementById('memberFullname').value.trim();
            const memberBlock = document.getElementById('memberBlock').value.trim();
            const memberFlatNumber = document.getElementById('memberFlatNumber').value.trim();
            const memberEmail = document.getElementById('memberEmail').value.trim();
            const memberCountryCode = document.getElementById('memberCountryCode').value.trim();
            const memberPhoneNumber = document.getElementById('memberPhoneNumber').value.trim();
            const memberType = document.getElementById('memberType').value.trim();
            const memberImageFileInput = document.getElementById('memberImage').files[0];
            const csrf_token = document.querySelector('input[name="csrf_token"]').value;

            // Validate required fields
            if (!memberSalutation || !memberFullname || !memberBlock || !memberFlatNumber || !memberEmail || !memberCountryCode || !memberPhoneNumber || !memberType || !csrf_token) {
                Swal.fire('Validation Error', 'Please fill all required fields.', 'warning');
                btn.disabled = false; btn.textContent = 'Add Member';
                return;
            }

            // Validate email format
            const emailRegex = /^[^\s@]+@[^\s@]+\.[^\s@]+$/;
            if (!emailRegex.test(memberEmail)) {
                Swal.fire('Validation Error', 'Please enter a valid email address.', 'warning');
                btn.disabled = false; btn.textContent = 'Add Member';
                return;
            }

            // Validate phone number (at least 6 digits)
            if (!/^\d{6,}$/.test(memberPhoneNumber)) {
                Swal.fire('Validation Error', 'Phone number must be at least 6 digits.', 'warning');
                btn.disabled = false; btn.textContent = 'Add Member';
                return;
            }

            // Validate image if provided
            if (memberImageFileInput) {
                const allowedTypes = ['image/jpeg', 'image/png', 'image/webp', 'image/heic', 'image/gif'];
                if (!allowedTypes.includes(memberImageFileInput.type)) {
                    Swal.fire('Validation Error', 'Only image files are allowed (JPG, PNG, WebP, HEIC, GIF).', 'warning');
                    btn.disabled = false; btn.textContent = 'Add Member';
                    return;
                }
                if (memberImageFileInput.size > 5 * 1024 * 1024) { // 5MB limit
                    Swal.fire('Validation Error', 'Image size must be less than 5MB.', 'warning');
                    btn.disabled = false; btn.textContent = 'Add Member';
                    return;
                }
            }

            const formData = new FormData();
            formData.append('action', 'add_member');
            formData.append('member_salutation', memberSalutation);
            formData.append('member_fullname', memberFullname);
            formData.append('member_block', memberBlock);
            formData.append('member_flat_number', memberFlatNumber);
            formData.append('member_email', memberEmail);
            formData.append('member_country_code', memberCountryCode);
            formData.append('member_phone_number', memberPhoneNumber);
            formData.append('member_type', memberType);
            if (memberImageFileInput) {
                formData.append('member_image_file', memberImageFileInput);
            }
            formData.append('csrf_token', csrf_token);

            fetch('assets/includes/functions/ajax-handlers/members/add_new_member.php', {
                method: 'POST',
                body: formData
            })
            .then(res => res.text())
            .then(text => {
                try {
                    const data = JSON.parse(text);
                    if (data.success) {
                        Swal.fire('Success', 'Member added successfully.', 'success').then(() => {
                            // Redirect to members management
                            window.location.href = '<?= get_site_option('dashboard_url') ?>?page=add-member';
                        });
                    } else {
                        Swal.fire('Error', data.error || 'Failed to add member.', 'error');
                        btn.disabled = false; btn.textContent = 'Add Member';
                    }
                } catch (e) {
                    Swal.fire('Error', 'An error occurred while saving.', 'error');
                    btn.disabled = false; btn.textContent = 'Add Member';
                }
            })
            .catch (err => {
                Swal.fire('Error', 'An error occurred while saving.', 'error');
                btn.disabled = false; btn.textContent = 'Add Member';
            });
        }
    }
</script>