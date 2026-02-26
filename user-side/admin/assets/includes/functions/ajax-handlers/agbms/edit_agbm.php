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

    $agbm_id = isset($_POST['agbm_id']) ? (int) $_POST['agbm_id'] : 0;
    $agbm_number = isset($_POST['agbm_number']) ? trim($_POST['agbm_number']) : '';
    $agbm_title = isset($_POST['agbm_title']) ? trim($_POST['agbm_title']) : '';
    $agbm_single_line = isset($_POST['agbm_single_line']) ? trim($_POST['agbm_single_line']) : '';
    $agbm_excerpt = isset($_POST['agbm_excerpt']) ? trim($_POST['agbm_excerpt']) : '';
    $agbm_content = isset($_POST['agbm_content']) ? trim($_POST['agbm_content']) : '';
    $agbm_video_link = isset($_POST['agbm_video_link']) ? trim($_POST['agbm_video_link']) : '';
    $agbm_material_title = isset($_POST['agbm_material_title']) ? trim($_POST['agbm_material_title']) : '';
    $agbm_material = $_FILES['agbm_material'] ?? null;

    if ($agbm_id <= 0 || empty($agbm_number) || empty($agbm_title) || empty($agbm_single_line) || empty($agbm_excerpt) || empty($agbm_content)) {
        ob_clean();
        echo json_encode(['success' => false, 'error' => 'All required fields must be provided.']);
        exit;
    }

    try {
        $existingAgbm = get_agbm_details($agbm_id);
        if (!$existingAgbm) {
            ob_clean();
            echo json_encode(['success' => false, 'error' => 'AGBM not found or already deleted.']);
            exit;
        }

        // Check for duplicate AGBM number (excluding current AGBM)
        global $con;
        $dupStmt = $con->prepare("SELECT 1 FROM agbms WHERE agbm_number = ? AND agbm_id != ? AND agbm_status != 'deleted' LIMIT 1");
        if (!$dupStmt) {
            ob_clean();
            echo json_encode(['success' => false, 'error' => 'Could not validate existing AGBMs.']);
            exit;
        }
        $dupStmt->bind_param("si", $agbm_number, $agbm_id);
        $dupStmt->execute();
        $dupResult = $dupStmt->get_result();
        if ($dupResult && $dupResult->num_rows > 0) {
            $dupStmt->close();
            ob_clean();
            echo json_encode(['success' => false, 'error' => 'An AGBM with this number already exists.']);
            exit;
        }
        $dupStmt->close();

        $allowed_extensions = ['pdf', 'doc', 'docx', 'xls', 'xlsx'];
        $agbmsDir = __DIR__ . '/../../../../uploads/documents/agbms/';
        $newMaterialName = null;
        $newMaterialAbsolutePath = null;

        if ($agbm_material && $agbm_material['error'] !== UPLOAD_ERR_NO_FILE) {
            if ($agbm_material['error'] !== UPLOAD_ERR_OK) {
                ob_clean();
                echo json_encode(['success' => false, 'error' => 'File upload failed. Please try again.']);
                exit;
            }

            $file_extension = strtolower(pathinfo($agbm_material['name'], PATHINFO_EXTENSION));
            if (!in_array($file_extension, $allowed_extensions, true)) {
                ob_clean();
                echo json_encode(['success' => false, 'error' => 'Invalid file type. Allowed: pdf, doc, docx, xls, xlsx.']);
                exit;
            }

            if (!is_dir($agbmsDir) && !mkdir($agbmsDir, 0775, true)) {
                ob_clean();
                echo json_encode(['success' => false, 'error' => 'Unable to create AGBM materials upload directory.']);
                exit;
            }

            $safeBase = preg_replace('/[^A-Za-z0-9_-]/', '_', pathinfo($agbm_material['name'], PATHINFO_FILENAME));
            if ($safeBase === '') {
                $safeBase = 'agbm_material';
            }

            $newMaterialName = $safeBase . '_' . uniqid('', true) . '.' . $file_extension;
            $newMaterialAbsolutePath = $agbmsDir . $newMaterialName;

            if (!move_uploaded_file($agbm_material['tmp_name'], $newMaterialAbsolutePath)) {
                ob_clean();
                echo json_encode(['success' => false, 'error' => 'Failed to save uploaded file.']);
                exit;
            }
        }

        $update_success = edit_agbm($agbm_id, $agbm_number, $agbm_title, $agbm_single_line, $agbm_excerpt, $agbm_content, $agbm_video_link, $agbm_material_title, $newMaterialName);

        if (!$update_success) {
            if ($newMaterialAbsolutePath && file_exists($newMaterialAbsolutePath)) {
                unlink($newMaterialAbsolutePath);
            }
            ob_clean();
            echo json_encode(['success' => false, 'error' => 'Failed to update AGBM.']);
            exit;
        }

        if ($newMaterialName && !empty($existingAgbm['agbm_material'])) {
            $oldMaterialPath = $agbmsDir . $existingAgbm['agbm_material'];
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
