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

    $member_id = isset($_POST['member_id']) ? (int) $_POST['member_id'] : 0;
    $member_unique_id = isset($_POST['member_unique_id']) ? trim($_POST['member_unique_id']) : '';
    $member_salutation = isset($_POST['member_salutation']) ? trim($_POST['member_salutation']) : '';
    $member_fullname = isset($_POST['member_fullname']) ? trim($_POST['member_fullname']) : '';
    $member_block = isset($_POST['member_block']) ? trim($_POST['member_block']) : '';
    $member_flat_number = isset($_POST['member_flat_number']) ? trim($_POST['member_flat_number']) : '';
    $member_email = isset($_POST['member_email']) ? trim($_POST['member_email']) : '';
    $member_country_code = isset($_POST['member_country_code']) ? trim($_POST['member_country_code']) : '';
    $member_phone_number = isset($_POST['member_phone_number']) ? trim($_POST['member_phone_number']) : '';

    $phone_length = strlen($member_phone_number);
    $mid_point = (int)($phone_length / 2);
    $formatted_phone = substr($member_phone_number, 0, $mid_point) . ' ' . substr($member_phone_number, $mid_point);
    $member_phone_number_data = $member_country_code . " " . $formatted_phone;

    $member_type = isset($_POST['member_type']) ? trim($_POST['member_type']) : '';
    $member_image = $_FILES['member_image'] ?? null;

    if ($member_id <= 0 || empty($member_unique_id) || empty($member_salutation) || empty($member_fullname) || empty($member_block) || empty($member_flat_number) || empty($member_email) || empty($member_country_code) || empty($member_phone_number) || empty($member_type)) {
        ob_clean();
        echo json_encode(['success' => false, 'error' => 'All required fields must be provided.']);
        exit;
    }

    if (!filter_var($member_email, FILTER_VALIDATE_EMAIL)) {
        ob_clean();
        echo json_encode(['success' => false, 'error' => 'Invalid email format.']);
        exit;
    }

    try {
        $existingMember = get_member_details($member_id, $member_unique_id, $member_email);
        $existingNotice = get_notice_details($notice_id);
        if (!$existingNotice) {
            ob_clean();
            echo json_encode(['success' => false, 'error' => 'Notice not found or already deleted.']);
            exit;
        }

        // Check for duplicate notice number (excluding current notice)
        global $con;
        $dupStmt = $con->prepare("SELECT 1 FROM notices WHERE notice_number = ? AND notice_id != ? AND notice_status != 'deleted' LIMIT 1");
        if (!$dupStmt) {
            ob_clean();
            echo json_encode(['success' => false, 'error' => 'Could not validate existing notices.']);
            exit;
        }
        $dupStmt->bind_param("si", $notice_number, $notice_id);
        $dupStmt->execute();
        $dupResult = $dupStmt->get_result();
        if ($dupResult && $dupResult->num_rows > 0) {
            $dupStmt->close();
            ob_clean();
            echo json_encode(['success' => false, 'error' => 'A notice with this number already exists.']);
            exit;
        }
        $dupStmt->close();

        $allowed_extensions = ['pdf', 'doc', 'docx', 'xls', 'xlsx'];
        $noticesDir = __DIR__ . '/../../../../uploads/documents/notices/';
        $newMaterialName = null;
        $newMaterialAbsolutePath = null;

        if ($notice_material && $notice_material['error'] !== UPLOAD_ERR_NO_FILE) {
            if ($notice_material['error'] !== UPLOAD_ERR_OK) {
                ob_clean();
                echo json_encode(['success' => false, 'error' => 'File upload failed. Please try again.']);
                exit;
            }

            $file_extension = strtolower(pathinfo($notice_material['name'], PATHINFO_EXTENSION));
            if (!in_array($file_extension, $allowed_extensions, true)) {
                ob_clean();
                echo json_encode(['success' => false, 'error' => 'Invalid file type. Allowed: pdf, doc, docx, xls, xlsx.']);
                exit;
            }

            if (!is_dir($noticesDir) && !mkdir($noticesDir, 0775, true)) {
                ob_clean();
                echo json_encode(['success' => false, 'error' => 'Unable to create notice materials upload directory.']);
                exit;
            }

            $safeBase = preg_replace('/[^A-Za-z0-9_-]/', '_', pathinfo($notice_material['name'], PATHINFO_FILENAME));
            if ($safeBase === '') {
                $safeBase = 'notice_material';
            }

            $newMaterialName = $safeBase . '_' . uniqid('', true) . '.' . $file_extension;
            $newMaterialAbsolutePath = $noticesDir . $newMaterialName;

            if (!move_uploaded_file($notice_material['tmp_name'], $newMaterialAbsolutePath)) {
                ob_clean();
                echo json_encode(['success' => false, 'error' => 'Failed to save uploaded file.']);
                exit;
            }
        }

        $update_success = edit_notice($notice_id, $notice_number, $notice_title, $notice_single_line, $notice_category, $notice_badge, $notice_excerpt, $notice_content, $notice_material_title, $newMaterialName);

        if (!$update_success) {
            if ($newMaterialAbsolutePath && file_exists($newMaterialAbsolutePath)) {
                unlink($newMaterialAbsolutePath);
            }
            ob_clean();
            echo json_encode(['success' => false, 'error' => 'Failed to update notice.']);
            exit;
        }

        // Delete old material file if a new one was uploaded
        if ($newMaterialName && !empty($existingNotice['notice_material'])) {
            $oldMaterialPath = $noticesDir . $existingNotice['notice_material'];
            if (is_file($oldMaterialPath)) {
                @unlink($oldMaterialPath);
            }
        }

        ob_clean();
        echo json_encode(['success' => true]);
    } catch (Throwable $e) {
        if (isset($newMaterialAbsolutePath) && $newMaterialAbsolutePath && file_exists($newMaterialAbsolutePath)) {
            unlink($newMaterialAbsolutePath);
        }
        ob_clean();
        echo json_encode(['success' => false, 'error' => 'Exception: ' . $e->getMessage()]);
    }
?>
