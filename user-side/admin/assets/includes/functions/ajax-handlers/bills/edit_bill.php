<?php
    session_start();
    ob_start();
    header('Content-Type: application/json');
    error_reporting(E_ALL);
    ini_set('display_errors', '0');

    // Load DB config and helpers
    require_once __DIR__ . '/../../../config/config.php';
    require_once __DIR__ . '/../../dashboard_functions.php';
    require_once __DIR__ . '/../../utility_functions.php';

    if ($_SERVER['REQUEST_METHOD'] !== 'POST') {
        ob_clean();
        echo json_encode(['success' => false, 'error' => 'Invalid request method']);
        exit;
    }

    // Verify CSRF token
    $csrf_token = $_POST['csrf_token'] ?? null;
    if (!verify_csrf_token($csrf_token)) {
        ob_clean();
        echo json_encode(['success' => false, 'error' => 'Invalid security token. Please refresh and try again.']);
        exit;
    }

    $bill_id = isset($_POST['bill_id']) ? (int) $_POST['bill_id'] : 0;
    $bill_member = isset($_POST['bill_member']) ? trim($_POST['bill_member']) : '';
    $bill_month = isset($_POST['bill_month']) ? trim($_POST['bill_month']) : '';
    $bill_due_date = isset($_POST['bill_due_date']) ? trim($_POST['bill_due_date']) : '';
    $bill_file = $_FILES['bill_file'] ?? null;

    if ($bill_id <= 0 || empty($bill_member) || empty($bill_month) || empty($bill_due_date)) {
        ob_clean();
        echo json_encode(['success' => false, 'error' => 'All required fields must be provided.']);
        exit;
    }

    try {
        $existingBill = get_bill_details($bill_id);
        if (!$existingBill) {
            ob_clean();
            echo json_encode(['success' => false, 'error' => 'Bill not found or already deleted.']);
            exit;
        }

        if ($bill_member !== $existingBill['bill_for_member']) {
            ob_clean();
            echo json_encode(['success' => false, 'error' => 'Bill member does not match the existing record.']);
            exit;
        }

        // Prevent duplicate bill for same member and month (excluding current bill)
        global $con;
        $dupStmt = $con->prepare("SELECT 1 FROM bills WHERE bill_for_member = ? AND bill_for_month = ? AND bill_id != ? AND bill_status != 'deleted' LIMIT 1");
        if (!$dupStmt) {
            ob_clean();
            echo json_encode(['success' => false, 'error' => 'Could not validate existing bills.']);
            exit;
        }
        $dupStmt->bind_param("ssi", $bill_member, $bill_month, $bill_id);
        $dupStmt->execute();
        $dupResult = $dupStmt->get_result();
        if ($dupResult && $dupResult->num_rows > 0) {
            $dupStmt->close();
            ob_clean();
            echo json_encode(['success' => false, 'error' => 'This member already has a bill for the selected month.']);
            exit;
        }
        $dupStmt->close();

        $allowed_extensions = ['pdf', 'doc', 'docx', 'xls', 'xlsx'];
        $billsDir = __DIR__ . '/../../../../uploads/documents/bills/';
        $newFileName = null;
        $newFileAbsolutePath = null;

        if ($bill_file && $bill_file['error'] !== UPLOAD_ERR_NO_FILE) {
            if ($bill_file['error'] !== UPLOAD_ERR_OK) {
                ob_clean();
                echo json_encode(['success' => false, 'error' => 'File upload failed. Please try again.']);
                exit;
            }

            $file_extension = strtolower(pathinfo($bill_file['name'], PATHINFO_EXTENSION));
            if (!in_array($file_extension, $allowed_extensions, true)) {
                ob_clean();
                echo json_encode(['success' => false, 'error' => 'Invalid file type. Allowed: pdf, doc, docx, xls, xlsx.']);
                exit;
            }

            if (!is_dir($billsDir) && !mkdir($billsDir, 0775, true)) {
                ob_clean();
                echo json_encode(['success' => false, 'error' => 'Unable to create bills upload directory.']);
                exit;
            }

            $safeBase = preg_replace('/[^A-Za-z0-9_-]/', '_', pathinfo($bill_file['name'], PATHINFO_FILENAME));
            if ($safeBase === '') {
                $safeBase = 'bill';
            }

            $newFileName = $safeBase . '_' . uniqid('', true) . '.' . $file_extension;
            $newFileAbsolutePath = $billsDir . $newFileName;

            if (!move_uploaded_file($bill_file['tmp_name'], $newFileAbsolutePath)) {
                ob_clean();
                echo json_encode(['success' => false, 'error' => 'Failed to save uploaded file.']);
                exit;
            }
        }

        $update_success = edit_bill($bill_id, $bill_month, $bill_due_date, $newFileName);

        if (!$update_success) {
            if ($newFileAbsolutePath && file_exists($newFileAbsolutePath)) {
                unlink($newFileAbsolutePath);
            }
            ob_clean();
            echo json_encode(['success' => false, 'error' => 'Failed to update bill.']);
            exit;
        }

        if ($newFileName) {
            $oldFilePath = $billsDir . $existingBill['bill_file'];
            if (is_file($oldFilePath)) {
                @unlink($oldFilePath);
            }
        }

        ob_clean();
        echo json_encode(['success' => true]);
    } catch (Throwable $e) {
        if (isset($newFileAbsolutePath) && $newFileAbsolutePath && file_exists($newFileAbsolutePath)) {
            unlink($newFileAbsolutePath);
        }
        ob_clean();
        echo json_encode(['success' => false, 'error' => 'Exception: ' . $e->getMessage()]);
    }
?>