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
    $category_name = isset($_POST['notice_category_name']) ? ucwords(trim($_POST['notice_category_name'])) : '';
    $parent_category_id = isset($_POST['notice_parent_category_id']) ? trim($_POST['notice_parent_category_id']) : '';

    // Required validations
    if (empty($category_name)) {
        ob_clean();
        echo json_encode(['success' => false, 'error' => 'Category name is required.']);
        exit;
    }

    // Convert parent category to NULL if empty or 'NULL'
    $parent_id = null;
    if (!empty($parent_category_id) && $parent_category_id !== 'NULL') {
        $parent_id = (int) $parent_category_id;
    }

    global $con;

    // Function to generate slug from name
    function generate_slug($text) {
        // Convert to lowercase
        $text = strtolower($text);
        // Replace spaces and special characters with hyphens
        $text = preg_replace('/[^a-z0-9]+/', '-', $text);
        // Remove leading/trailing hyphens
        $text = trim($text, '-');
        return $text;
    }

    // Generate base slug
    $base_slug = generate_slug($category_name);

    // Check for duplicates in the same hierarchy
    if ($parent_id === null) {
        // Check for root level categories with the same name
        $dupStmt = $con->prepare("SELECT 1 FROM notice_categories WHERE notice_category_name = ? AND (notice_parent_category_id IS NULL OR notice_parent_category_id = 0) AND notice_category_status != 'deleted' LIMIT 1");
        if (!$dupStmt) {
            ob_clean();
            echo json_encode(['success' => false, 'error' => 'Could not validate existing categories.']);
            exit;
        }
        $dupStmt->bind_param("s", $category_name);
    } else {
        // Check for categories with the same name under the same parent
        $dupStmt = $con->prepare("SELECT 1 FROM notice_categories WHERE notice_category_name = ? AND notice_parent_category_id = ? AND notice_category_status != 'deleted' LIMIT 1");
        if (!$dupStmt) {
            ob_clean();
            echo json_encode(['success' => false, 'error' => 'Could not validate existing categories.']);
            exit;
        }
        $dupStmt->bind_param("si", $category_name, $parent_id);
    }
    
    $dupStmt->execute();
    $dupResult = $dupStmt->get_result();
    if ($dupResult && $dupResult->num_rows > 0) {
        $dupStmt->close();
        ob_clean();
        echo json_encode(['success' => false, 'error' => 'A category with this name already exists in the same hierarchy.']);
        exit;
    }
    $dupStmt->close();

    // Check if slug exists and generate unique slug
    $final_slug = $base_slug;
    $slug_counter = 1;
    
    while (true) {
        $slugCheckStmt = $con->prepare("SELECT 1 FROM notice_categories WHERE notice_category_slug = ? AND notice_category_status != 'deleted' LIMIT 1");
        if (!$slugCheckStmt) {
            ob_clean();
            echo json_encode(['success' => false, 'error' => 'Could not validate slug.']);
            exit;
        }
        $slugCheckStmt->bind_param("s", $final_slug);
        $slugCheckStmt->execute();
        $slugResult = $slugCheckStmt->get_result();
        
        if ($slugResult && $slugResult->num_rows > 0) {
            // Slug exists, append counter
            $final_slug = $base_slug . '-' . $slug_counter;
            $slug_counter++;
            $slugCheckStmt->close();
        } else {
            // Slug is unique
            $slugCheckStmt->close();
            break;
        }
    }

    try {
        $added_by = $_SESSION['office_member_unique_id'] ?? null;
        $added_on = date('Y-m-d H:i:s');

        $insert_success = add_new_notice_category(
            $category_name,
            $parent_id,
            $final_slug,
            $added_by,
            $added_on
        );

        if ($insert_success) {
            ob_clean();
            echo json_encode(['success' => true]);
        } else {
            ob_clean();
            echo json_encode(['success' => false, 'error' => 'Failed to add notice category.']);
        }
    } catch (Throwable $e) {
        ob_clean();
        echo json_encode(['success' => false, 'error' => 'Exception: ' . $e->getMessage()]);
    }
?>
