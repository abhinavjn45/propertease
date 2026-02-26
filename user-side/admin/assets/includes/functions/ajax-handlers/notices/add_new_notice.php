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

    // Collect fields
    $notice_number = isset($_POST['notice_number']) ? trim($_POST['notice_number']) : '';
    $notice_title = isset($_POST['notice_title']) ? trim($_POST['notice_title']) : '';
    $notice_single_line = isset($_POST['notice_single_line']) ? trim($_POST['notice_single_line']) : '';
    $notice_category = isset($_POST['notice_category']) ? trim($_POST['notice_category']) : '';
    $notice_badge = isset($_POST['notice_badge']) ? trim($_POST['notice_badge']) : '';
    $notice_excerpt = isset($_POST['notice_excerpt']) ? trim($_POST['notice_excerpt']) : '';
    $notice_content = isset($_POST['notice_content']) ? trim($_POST['notice_content']) : '';
    $material_title = isset($_POST['notice_material_title']) ? trim($_POST['notice_material_title']) : '';
    $material_file = isset($_FILES['notice_material_file']) ? $_FILES['notice_material_file'] : null;

    // Required validations
    if (empty($notice_number) || empty($notice_title) || empty($notice_single_line) || empty($notice_category) || empty($notice_excerpt) || empty($notice_content)) {
        ob_clean();
        echo json_encode(['success' => false, 'error' => 'All required fields must be provided.']);
        exit;
    }

    // Material fields: both-or-none
    $material_any = (!empty($material_title)) || ($material_file && $material_file['error'] !== UPLOAD_ERR_NO_FILE);
    $material_both = (!empty($material_title)) && ($material_file && $material_file['error'] !== UPLOAD_ERR_NO_FILE);
    if ($material_any && !$material_both) {
        ob_clean();
        echo json_encode(['success' => false, 'error' => 'Provide both Material Title and Material File or leave both empty.']);
        exit;
    }

    // Duplicate check: notice number
    global $con;
    $dupStmt = $con->prepare("SELECT 1 FROM notices WHERE notice_number = ? LIMIT 1");
    if (!$dupStmt) {
        ob_clean();
        echo json_encode(['success' => false, 'error' => 'Could not validate existing notices.']);
        exit;
    }
    $dupStmt->bind_param("s", $notice_number);
    $dupStmt->execute();
    $dupResult = $dupStmt->get_result();
    if ($dupResult && $dupResult->num_rows > 0) {
        $dupStmt->close();
        ob_clean();
        echo json_encode(['success' => false, 'error' => 'A notice with this number already exists.']);
        exit;
    }
    $dupStmt->close();

    $storedFileName = null;
    $absoluteFilePath = null;

    // Prepare upload path and filename if file provided (move after successful DB insert)
    if ($material_both) {
        if ($material_file['error'] !== UPLOAD_ERR_OK) {
            ob_clean();
            echo json_encode(['success' => false, 'error' => 'File upload failed. Please try again.']);
            exit;
        }

        $allowed_extensions = ['pdf', 'doc', 'docx', 'xls', 'xlsx'];
        $file_extension = strtolower(pathinfo($material_file['name'], PATHINFO_EXTENSION));
        if (!in_array($file_extension, $allowed_extensions, true)) {
            ob_clean();
            echo json_encode(['success' => false, 'error' => 'Invalid file type. Allowed: pdf, doc, docx, xls, xlsx.']);
            exit;
        }

        $documentsDir = __DIR__ . '/../../../../uploads/documents/notices/';
        if (!is_dir($documentsDir) && !mkdir($documentsDir, 0775, true)) {
            ob_clean();
            echo json_encode(['success' => false, 'error' => 'Unable to create documents directory.']);
            exit;
        }

        $safeBase = preg_replace('/[^A-Za-z0-9_-]/', '_', pathinfo($material_file['name'], PATHINFO_FILENAME));
        if ($safeBase === '') {
            $safeBase = 'notice_material';
        }
        $storedFileName = $safeBase . '_' . uniqid('', true) . '.' . $file_extension;
        $absoluteFilePath = $documentsDir . $storedFileName;
    }

    try {
        $posted_by = $_SESSION['office_member_unique_id'] ?? null;
        $posted_on = date('Y-m-d H:i:s');

        $insert_success = add_new_notice(
            $notice_number,
            $notice_title,
            $notice_single_line,
            $notice_category,
            $notice_badge,
            $notice_excerpt,
            $notice_content,
            $material_both ? $material_title : null,
            $material_both ? $storedFileName : null,
            $posted_by,
            $posted_on
        );

        if ($insert_success) {
            if ($material_both) {
                if (!move_uploaded_file($material_file['tmp_name'], $absoluteFilePath)) {
                    // Rollback insert if file move fails
                    $rollback = $con->prepare("DELETE FROM notices WHERE notice_number = ? AND notice_material = ? LIMIT 1");
                    if ($rollback) {
                        $rollback->bind_param("ss", $notice_number, $storedFileName);
                        $rollback->execute();
                        $rollback->close();
                    }
                    ob_clean();
                    echo json_encode(['success' => false, 'error' => 'Failed to save uploaded file.']);
                    exit;
                }
            }

            ob_clean();
            echo json_encode(['success' => true]);
        } else {
            ob_clean();
            echo json_encode(['success' => false, 'error' => 'Failed to add notice.']);
        }
    } catch (Throwable $e) {
        // Cleanup if file had been written but exception occurred (unlikely here before move)
        ob_clean();
        echo json_encode(['success' => false, 'error' => 'Exception: ' . $e->getMessage()]);
    }
?>