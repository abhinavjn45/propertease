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
    $agbm_number = isset($_POST['agbm_number']) ? trim($_POST['agbm_number']) : '';
    $agbm_title = isset($_POST['agbm_title']) ? trim($_POST['agbm_title']) : '';
    $agbm_single_line = isset($_POST['agbm_single_line']) ? trim($_POST['agbm_single_line']) : '';
    $agbm_excerpt = isset($_POST['agbm_excerpt']) ? trim($_POST['agbm_excerpt']) : '';
    $agbm_content = isset($_POST['agbm_content']) ? trim($_POST['agbm_content']) : '';
    $agbm_video_link = isset($_POST['agbm_video_link']) ? trim($_POST['agbm_video_link']) : '';
    $agbm_material_title = isset($_POST['agbm_material_title']) ? trim($_POST['agbm_material_title']) : '';
    $agbm_material_file = isset($_FILES['agbm_material_file']) ? $_FILES['agbm_material_file'] : null;

    // Required validations
    if (empty($agbm_number) || empty($agbm_title) || empty($agbm_single_line) || empty($agbm_excerpt) || empty($agbm_content)) {
        ob_clean();
        echo json_encode(['success' => false, 'error' => 'All required fields must be provided.']);
        exit;
    }

    // Material fields: both-or-none
    $material_any = (!empty($agbm_material_title)) || ($agbm_material_file && $agbm_material_file['error'] !== UPLOAD_ERR_NO_FILE);
    $material_both = (!empty($agbm_material_title)) && ($agbm_material_file && $agbm_material_file['error'] !== UPLOAD_ERR_NO_FILE);
    if ($material_any && !$material_both) {
        ob_clean();
        echo json_encode(['success' => false, 'error' => 'Provide both Material Title and Material File or leave both empty.']);
        exit;
    }

    // Duplicate check: AGBM number
    global $con;
    $dupStmt = $con->prepare("SELECT 1 FROM agbms WHERE agbm_number = ? AND agbm_status != 'deleted' LIMIT 1");
    if (!$dupStmt) {
        ob_clean();
        echo json_encode(['success' => false, 'error' => 'Could not validate existing AGBMs.']);
        exit;
    }
    $dupStmt->bind_param("s", $agbm_number);
    $dupStmt->execute();
    $dupResult = $dupStmt->get_result();
    if ($dupResult && $dupResult->num_rows > 0) {
        $dupStmt->close();
        ob_clean();
        echo json_encode(['success' => false, 'error' => 'An AGBM with this number already exists.']);
        exit;
    }
    $dupStmt->close();

    $storedFileName = null;
    $absoluteFilePath = null;

    // Prepare upload path and filename if file provided (move after successful DB insert)
    if ($material_both) {
        if ($agbm_material_file['error'] !== UPLOAD_ERR_OK) {
            ob_clean();
            echo json_encode(['success' => false, 'error' => 'File upload failed. Please try again.']);
            exit;
        }

        $allowed_extensions = ['pdf', 'doc', 'docx', 'xls', 'xlsx'];
        $file_extension = strtolower(pathinfo($agbm_material_file['name'], PATHINFO_EXTENSION));
        if (!in_array($file_extension, $allowed_extensions, true)) {
            ob_clean();
            echo json_encode(['success' => false, 'error' => 'Invalid file type. Allowed: pdf, doc, docx, xls, xlsx.']);
            exit;
        }

        $documentsDir = __DIR__ . '/../../../../uploads/documents/agbms/';
        if (!is_dir($documentsDir) && !mkdir($documentsDir, 0775, true)) {
            ob_clean();
            echo json_encode(['success' => false, 'error' => 'Unable to create AGBM materials upload directory.']);
            exit;
        }

        $safeBase = preg_replace('/[^A-Za-z0-9_-]/', '_', pathinfo($agbm_material_file['name'], PATHINFO_FILENAME));
        if ($safeBase === '') {
            $safeBase = 'agbm_material';
        }
        $storedFileName = $safeBase . '_' . uniqid('', true) . '.' . $file_extension;
        $absoluteFilePath = $documentsDir . $storedFileName;
    }

    try {
        $added_by = $_SESSION['office_member_unique_id'] ?? null;
        $added_on = date('Y-m-d H:i:s');

        $insert_success = add_new_agbm(
            $agbm_number,
            $agbm_title,
            $agbm_single_line,
            $agbm_excerpt,
            $agbm_content,
            $agbm_video_link,
            $material_both ? $agbm_material_title : null,
            $material_both ? $storedFileName : null,
            $added_by,
            $added_on
        );

        if ($insert_success) {
            if ($material_both) {
                if (!move_uploaded_file($agbm_material_file['tmp_name'], $absoluteFilePath)) {
                    // Rollback insert if file move fails
                    $rollback = $con->prepare("DELETE FROM agbms WHERE agbm_number = ? AND agbm_material = ? LIMIT 1");
                    if ($rollback) {
                        $rollback->bind_param("ss", $agbm_number, $storedFileName);
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
            echo json_encode(['success' => false, 'error' => 'Failed to add AGBM.']);
        }
    } catch (Throwable $e) {
        // Cleanup if file had been written but exception occurred (unlikely here before move)
        ob_clean();
        echo json_encode(['success' => false, 'error' => 'Exception: ' . $e->getMessage()]);
    }
?>
