<?php
    session_start();
    ob_start();
    header('Content-Type: application/json');
    error_reporting(E_ALL);
    ini_set('display_errors', '0');

    // Load DB config and helpers
    require_once __DIR__ . '/../../config/config.php';
    require_once __DIR__ . '/../dashboard_functions.php';
    require_once __DIR__ . '/../utility_functions.php';

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

    $required = ['type', 'field', 'idValue', 'statusField', 'newStatus', 'updatedTimeField'];
    foreach ($required as $key) {
        if (!isset($_POST[$key])) {
            ob_clean();
            echo json_encode(['success' => false, 'error' => 'Missing parameter: ' . $key]);
            exit;
        }
    }

    $type = $_POST['type'];
    $id_field = $_POST['field'];
    $id = (int)$_POST['idValue'];
    $status_field = $_POST['statusField'];
    $new_status = $_POST['newStatus'];
    $updated_time_field = $_POST['updatedTimeField'];

    try {
        $update_success = change_status($type, $id_field, $id, $status_field, $new_status, $updated_time_field);
        ob_clean();
        if ($update_success) {
            echo json_encode(['success' => true]);
        } else {
            echo json_encode(['success' => false, 'error' => 'Failed to update status.']);
        }
    } catch (Throwable $e) {
        ob_clean();
        echo json_encode(['success' => false, 'error' => 'Exception: ' . $e->getMessage()]);
    }
?>