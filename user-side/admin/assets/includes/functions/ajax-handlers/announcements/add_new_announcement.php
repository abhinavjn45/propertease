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

    $content = isset($_POST['announcement_content']) ? trim($_POST['announcement_content']) : '';
    $expiry_on = isset($_POST['announcement_expiry_on']) ? trim($_POST['announcement_expiry_on']) : '';

    if (empty($content) || empty($expiry_on)) {
        ob_clean();
        echo json_encode(['success' => false, 'error' => 'All fields are required.']);
        exit;
    }
    
    try {
        $insert_success = add_new_announcement($content, $expiry_on);
        ob_clean();
        if ($insert_success) {
            echo json_encode(['success' => true]);
        } else {
            echo json_encode(['success' => false, 'error' => 'Failed to add announcement.']);
        }
    } catch (Throwable $e) {
        ob_clean();
        echo json_encode(['success' => false, 'error' => 'Exception: ' . $e->getMessage()]);
    }
?>