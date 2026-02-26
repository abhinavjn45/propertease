<div class="d-flex flex-wrap align-items-center justify-content-between gap-3 mb-24">
    <h6 class="fw-semibold mb-0">Add Bill</h6>
    <ul class="d-flex align-items-center gap-2">
        <li class="fw-medium">
            <a href="<?= get_site_option('dashboard_url') ?>" class="d-flex align-items-center gap-1 hover-text-primary">
                <iconify-icon icon="solar:home-smile-angle-outline" class="icon text-lg"></iconify-icon>
                Dashboard
            </a>
        </li>
        <li>/</li>
        <li class="fw-medium">Add New Bill</li>
    </ul>
</div>

<div class="card basic-data-table">
    <div class="card-header d-flex align-items-center justify-content-between">
        <h5 class="card-title mb-0">Add New Bill</h5>
        <a href="<?= get_site_option('dashboard_url') ?>?page=bills-management" class="btn btn-primary d-inline-flex align-items-center gap-2">
            <iconify-icon icon="solar:clipboard-list-outline" class="icon text-lg"></iconify-icon>
            All Bills
        </a>
    </div>
    <div class="card-body">
        <div class="row gy-3">
            <form id="addBillForm">
                <?php 
                    echo csrf_input_field(); 
                ?>
                <div class="row">
                    <div class="col-md-12">
                        <div class="mb-3">
                            <label for="billMember" class="form-label">Bill For Member:</label>
                            <select id="billMember" name="bill_member_id" class="form-select billMemberSelectBox" required style="width: 100%;">
                                <option value="" disabled selected>Select a Member for Uploading Bill</option>
                                <?= get_all_members_select_box() ?>
                            </select>
                        </div>
                    </div>
                    <div class="col-md-6">
                        <div class="mb-3">
                            <label for="billFile" class="form-label">Bill File:</label>
                            <input type="file" id="billFile" name="bill_file" class="form-control" accept=".pdf,.doc,.docx,.xls,.xlsx" required>
                        </div>
                    </div>
                    <div class="col-md-3">
                        <div class="mb-3">
                            <label for="billForMonth" class="form-label">Bill For Month:</label>
                            <input type="month" id="billForMonth" name="bill_for_month" class="form-control" required>
                        </div>
                    </div>
                    <div class="col-md-3">
                        <div class="mb-3">
                            <label for="billDueDate" class="form-label">Bill Due Date:</label>
                            <input type="date" id="billDueDate" name="bill_due_date" class="form-control" required>
                        </div>
                    </div>
                </div>
                <div class="mb-3">
                    <button type="reset" class="btn btn-secondary">Reset</button>
                    <button type="submit" class="btn btn-primary" id="submitAddBill">Save Bill</button>
                </div>
            </form>
        </div>
    </div>
</div>

<script>
    // Handle Add Bill form submit
    const addBillForm = document.getElementById('addBillForm');
    if (addBillForm) {
        addBillForm.onsubmit = function(e) {
            e.preventDefault();

            const btn = document.getElementById('submitAddBill');
            btn.disabled = true;
            btn.textContent = 'Saving...';

            const memberId = document.getElementById('billMember').value;
            const billFile = document.getElementById('billFile').files[0];
            const billForMonth = document.getElementById('billForMonth').value;
            const billDueDate = document.getElementById('billDueDate').value;
            const csrf_token = document.querySelector('input[name="csrf_token"]').value;

            if (!memberId || !billFile || !billForMonth || !billDueDate) {
                Swal.fire('Validation Error', 'Please fill all fields.', 'warning');
                btn.disabled = false; btn.textContent = 'Save Bill';
                return;
            }

            const formData = new FormData();
            formData.append('action', 'add_bill');
            formData.append('bill_member_id', memberId);
            formData.append('bill_for_month', billForMonth);
            formData.append('bill_due_date', billDueDate);
            formData.append('csrf_token', csrf_token);
            formData.append('bill_file', billFile);

            fetch('assets/includes/functions/ajax-handlers/bills/add_new_bill.php', {
                method: 'POST',
                body: formData
            })
            .then(res => res.json())
            .then(data => {
                if (data.success) {
                    Swal.fire('Success', 'Bill added successfully.', 'success').then(() => {
                        // Refresh the page or redirect
                        window.location.reload();
                    });
                } else {
                    Swal.fire('Error', data.error || 'Failed to add bill.', 'error').then(() => {
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
                btn.disabled = false; btn.textContent = 'Save Bill';
            });
        }
    }
</script>