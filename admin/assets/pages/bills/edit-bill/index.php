<?php 
    $bill_id = isset($_GET['bill_id']) ? trim($_GET['bill_id']) : '';
    if (!empty($bill_id)) {
        $bill = get_bill_details($bill_id);
        if ($bill) {
            $bill_member_block = $bill['member_block'];
            $bill_member_flatnumber = $bill['member_flat_number'];
            $bill_member_salutation = ucwords(strtolower(htmlspecialchars($bill['member_salutation'])));
            $bill_member_fullname = ucwords(strtolower(htmlspecialchars($bill['member_fullname'])));
                $bill_member_display = "(" . $bill_member_block . "-" . $bill_member_flatnumber . ") " . $bill_member_salutation . " " . $bill_member_fullname;
?>
<div class="d-flex flex-wrap align-items-center justify-content-between gap-3 mb-24">
    <h6 class="fw-semibold mb-0">Edit Bill</h6>
    <ul class="d-flex align-items-center gap-2">
        <li class="fw-medium">
            <a href="<?= get_site_option('dashboard_url') ?>" class="d-flex align-items-center gap-1 hover-text-primary">
                <iconify-icon icon="solar:home-smile-angle-outline" class="icon text-lg"></iconify-icon>
                Dashboard
            </a>
        </li>
        <li>/</li>
        <li class="fw-medium">Edit Bill</li>
    </ul>
</div>

<div class="card basic-data-table">
    <div class="card-header d-flex align-items-center justify-content-between">
        <h5 class="card-title mb-0">Edit Bill</h5>
        <a href="<?= get_site_option('dashboard_url') ?>?page=bills-management" class="btn btn-secondary d-inline-flex align-items-center gap-2">
            <iconify-icon icon="proicons:cancel-circle" class="icon text-lg"></iconify-icon>
            Cancel
        </a>
    </div>
    <div class="card-body">
        <div class="row gy-3">
            <form id="editBillForm">
                <?php 
                    echo csrf_input_field(); 
                ?>
                <input type="hidden" id="editBillId" value="<?= htmlspecialchars($bill_id) ?>" readonly required>
                <div class="row">
                    <div class="col-md-6">
                        <div class="mb-3">
                            <label for="editBillForMember" class="form-label">For Member:</label>
                            <input type="hidden" id="editBillMemberValue" name="edit_bill_member" value="<?= htmlspecialchars($bill['bill_for_member']) ?>" readonly required>
                            <input type="text" id="editBillForMember" class="form-control" value="<?= $bill_member_display ?>" readonly required>
                            <p class="form-text">Bill cannot be reassigned to another member.</p>
                        </div>
                    </div>
                    <div class="col-md-2">
                        <div class="mb-3">
                            <label for="editBillFile" class="form-label">File:</label><br>
                            <a href="<?= get_site_option('dashboard_url') ?>assets/uploads/documents/bills/<?= htmlspecialchars($bill['bill_file']) ?>" class="d-inline-flex align-items-center gap-2" target="_blank">
                                <iconify-icon icon="clarity:pop-out-line" class="icon text-lg"></iconify-icon>
                                View Current Bill
                            </a>
                        </div>
                    </div>
                    <div class="col-md-4">
                        <div class="mb-3">
                            <label for="editBillFile" class="form-label"></label>
                            <input type="file" id="editBillFile" name="edit_bill_file" class="form-control" accept=".pdf,.doc,.docx,.xls,.xlsx">
                            <p class="form-text">Upload a new file, if you want to replace the current bill.</p>
                        </div>
                    </div>
                    <div class="col-md-6">
                        <div class="mb-3">
                            <label for="editBillMonth" class="form-label">Bill Month:</label>
                            <input type="month" id="editBillMonth" name="edit_bill_month" class="form-control" required value="<?= date('Y-m', strtotime($bill['bill_for_month'])) ?>" />
                        </div>
                    </div>
                    <div class="col-md-6">
                        <div class="mb-3">
                            <label for="editBillDueDate" class="form-label">Bill Due Date:</label>
                            <input type="date" id="editBillDueDate" name="edit_bill_due_date" class="form-control" required value="<?= date('Y-m-d', strtotime($bill['bill_due_on'])) ?>" />
                        </div>
                    </div>
                </div>
                <div class="mb-3">
                    <button type="reset" class="btn btn-secondary">Reset</button>
                    <button type="submit" class="btn btn-primary" id="submitEditBill">Save Changes</button>
                </div>
            </form>
        </div>
    </div>
</div>

<script>
    const editBillForm = document.getElementById('editBillForm');
    if (editBillForm) {
        editBillForm.onsubmit = function(e) {
            e.preventDefault();

            const btn = document.getElementById('submitEditBill');
            btn.disabled = true;
            btn.textContent = 'Saving...';

            const billId = document.getElementById('editBillId').value.trim();
            const billMember = document.getElementById('editBillMemberValue').value.trim();
            const billFileInput = document.getElementById('editBillFile');
            const billFile = billFileInput && billFileInput.files.length ? billFileInput.files[0] : null;
            const billMonth = document.getElementById('editBillMonth').value.trim();
            const billDueDate = document.getElementById('editBillDueDate').value.trim();
            const csrfToken = document.querySelector('input[name="csrf_token"]').value;

            if (!billId || !billMember || !billMonth || !billDueDate || !csrfToken) {
                Swal.fire('Validation Error', 'Please fill all required fields.', 'warning');
                btn.disabled = false; btn.textContent = 'Save Changes';
                return;
            }

            const formData = new FormData();
            formData.append('bill_id', billId);
            formData.append('bill_member', billMember);
            formData.append('bill_month', billMonth);
            formData.append('bill_due_date', billDueDate);
            formData.append('csrf_token', csrfToken);
            if (billFile) {
                formData.append('bill_file', billFile);
            }

            fetch('assets/includes/functions/ajax-handlers/bills/edit_bill.php', {
                method: 'POST',
                body: formData
            })
            .then(res => res.json())
            .then(data => {
                if (data.success) {
                    Swal.fire('Success', 'Bill updated successfully.', 'success').then(() => {
                        window.location.href = '<?= get_site_option('dashboard_url') ?>?page=bills-management';
                    });
                } else {
                    Swal.fire('Error', data.error || 'Failed to update bill.', 'error');
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