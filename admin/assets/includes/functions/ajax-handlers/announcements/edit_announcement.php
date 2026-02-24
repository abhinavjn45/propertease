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

    $announcement_id = isset($_POST['announcement_id']) ? (int) $_POST['announcement_id'] : 0;
    $content = isset($_POST['announcement_content']) ? trim($_POST['announcement_content']) : '';
    $expiry_on = isset($_POST['announcement_expiry_on']) ? trim($_POST['announcement_expiry_on']) : '';

    if ($announcement_id <= 0 || empty($content) || empty($expiry_on)) {
        ob_clean();
        echo json_encode(['success' => false, 'error' => 'All fields are required.']);
        exit;
    }

    try {
        // Ensure announcement exists and is not deleted
        $announcement = get_announcement_details($announcement_id);
        if (!$announcement) {
            ob_clean();
            echo json_encode(['success' => false, 'error' => 'Announcement not found or already deleted.']);
            exit;
        }

        $update_success = edit_announcement($announcement_id, $content, $expiry_on);
        ob_clean();
        if ($update_success) {
            echo json_encode(['success' => true]);
        } else {
            echo json_encode(['success' => false, 'error' => 'Failed to update announcement.']);
        }
    } catch (Throwable $e) {
        ob_clean();
        echo json_encode(['success' => false, 'error' => 'Exception: ' . $e->getMessage()]);
    }
?>
