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
    require_once __DIR__ . '/../../data_fetcher.php';

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

    $member_unique_id = isset($_POST['bill_member_id']) ? trim($_POST['bill_member_id']) : '';
    $bill_for_month = isset($_POST['bill_for_month']) ? trim($_POST['bill_for_month']) : '';
    $bill_due_date = isset($_POST['bill_due_date']) ? trim($_POST['bill_due_date']) : '';
    $bill_file = isset($_FILES['bill_file']) ? $_FILES['bill_file'] : null;

    if (empty($member_unique_id) || empty($bill_for_month) || empty($bill_due_date) || empty($bill_file)) {
        ob_clean();
        echo json_encode(['success' => false, 'error' => 'All fields are required.']);
        exit;
    }

    if ($bill_file['error'] !== UPLOAD_ERR_OK) {
        ob_clean();
        echo json_encode(['success' => false, 'error' => 'File upload failed. Please try again.']);
        exit;
    }

    $allowed_extensions = ['pdf', 'doc', 'docx', 'xls', 'xlsx'];
    $file_extension = strtolower(pathinfo($bill_file['name'], PATHINFO_EXTENSION));
    if (!in_array($file_extension, $allowed_extensions, true)) {
        ob_clean();
        echo json_encode(['success' => false, 'error' => 'Invalid file type. Allowed: pdf, doc, docx, xls, xlsx.']);
        exit;
    }

    $checkMember = get_member_by_unique_id($member_unique_id);
    
    if (!$checkMember) {
        ob_clean();
        echo json_encode(['success' => false, 'error' => 'Invalid member selected.']);
        exit;
    }

    // Prevent duplicate bill for same member and month
    global $con;
    $dupStmt = $con->prepare("SELECT 1 FROM bills WHERE bill_for_member = ? AND bill_for_month = ? LIMIT 1");
    if (!$dupStmt) {
        ob_clean();
        echo json_encode(['success' => false, 'error' => 'Could not validate existing bills.']);
        exit;
    }
    $dupStmt->bind_param("ss", $member_unique_id, $bill_for_month);
    $dupStmt->execute();
    $dupResult = $dupStmt->get_result();
    if ($dupResult && $dupResult->num_rows > 0) {
        $dupStmt->close();
        ob_clean();
        echo json_encode(['success' => false, 'error' => 'This member already has a bill for the selected month.']);
        exit;
    }
    $dupStmt->close();

    // Prepare upload path and filename (only move after DB insert succeeds)
    $billsDir = __DIR__ . '/../../../../uploads/documents/bills/';
    if (!is_dir($billsDir) && !mkdir($billsDir, 0775, true)) {
        ob_clean();
        echo json_encode(['success' => false, 'error' => 'Unable to create bills upload directory.']);
        exit;
    }

    $safeBase = preg_replace('/[^A-Za-z0-9_-]/', '_', pathinfo($bill_file['name'], PATHINFO_FILENAME));
    if ($safeBase === '') {
        $safeBase = 'bill';
    }
    $storedFileName = $safeBase . '_' . uniqid('', true) . '.' . $file_extension;
    $relativeFilePath = get_site_option('dashboard_url') . "assets/uploads/documents/bills/" . $storedFileName;
    $absoluteFilePath = $billsDir . $storedFileName;

    echo "<script>console.log('Path: ' + " . $absoluteFilePath . ");</script>";

    try {
        $insert_success = add_new_bill($member_unique_id, $bill_for_month, $bill_due_date, $storedFileName);
        if ($insert_success) {
            if (!move_uploaded_file($bill_file['tmp_name'], $absoluteFilePath)) {
                // Rollback insert if file move fails
                $rollback = $con->prepare("DELETE FROM bills WHERE bill_for_member = ? AND bill_for_month = ? AND bill_file = ? LIMIT 1");
                if ($rollback) {
                    $rollback->bind_param("sss", $member_unique_id, $bill_for_month, $relativeFilePath);
                    $rollback->execute();
                    $rollback->close();
                }
                ob_clean();
                echo json_encode(['success' => false, 'error' => 'Failed to save uploaded file.']);
                exit;
            }

            ob_clean();
            echo json_encode(['success' => true, 'file' => $relativeFilePath]);
        } else {
            ob_clean();
            echo json_encode(['success' => false, 'error' => 'Failed to add bill.']);
        }
    } catch (Throwable $e) {
        ob_clean();
        echo json_encode(['success' => false, 'error' => 'Exception: ' . $e->getMessage()]);
    }
?>