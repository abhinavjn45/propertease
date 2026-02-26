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
    $category_id = isset($_POST['notice_category_id']) ? (int) $_POST['notice_category_id'] : 0;
    $category_name = isset($_POST['notice_category_name']) ? ucwords(trim($_POST['notice_category_name'])) : '';
    $parent_category_id = isset($_POST['notice_parent_category_id']) ? trim($_POST['notice_parent_category_id']) : '';

    // Required validations
    if ($category_id <= 0 || empty($category_name)) {
        ob_clean();
        echo json_encode(['success' => false, 'error' => 'Category ID and name are required.']);
        exit;
    }

    global $con;

    // Get existing category
    $existingCategory = get_notice_category_details($category_id);
    if (!$existingCategory) {
        ob_clean();
        echo json_encode(['success' => false, 'error' => 'Notice category not found or already deleted.']);
        exit;
    }

    // Convert parent category to NULL if empty or 'NULL'
    $parent_id = null;
    if (!empty($parent_category_id) && $parent_category_id !== 'NULL') {
        $parent_id = (int) $parent_category_id;
    }

    // Check if category is trying to set itself as parent (circular reference)
    if ($parent_id !== null && $parent_id === $category_id) {
        ob_clean();
        echo json_encode(['success' => false, 'error' => 'A category cannot be its own parent.']);
        exit;
    }

    // Check if the new parent is a descendant of the current category (circular hierarchy)
    if ($parent_id !== null) {
        function is_descendant($con, $category_id, $potential_parent_id) {
            // Check if potential_parent_id is a descendant of category_id
            $stmt = $con->prepare("SELECT notice_parent_category_id FROM notice_categories WHERE notice_category_id = ? AND notice_category_status != 'deleted' LIMIT 1");
            if (!$stmt) {
                return false;
            }
            $stmt->bind_param("i", $potential_parent_id);
            $stmt->execute();
            $result = $stmt->get_result();
            
            if ($result && $result->num_rows > 0) {
                $row = $result->fetch_assoc();
                $parent_of_potential = $row['notice_parent_category_id'];
                $stmt->close();
                
                // If parent is null or 0, it's a root category, not a descendant
                if ($parent_of_potential === null || $parent_of_potential == 0) {
                    return false;
                }
                
                // If the parent of potential_parent is the category we're editing, it's a descendant
                if ($parent_of_potential == $category_id) {
                    return true;
                }
                
                // Recursively check if it's a deeper descendant
                return is_descendant($con, $category_id, $parent_of_potential);
            }
            
            $stmt->close();
            return false;
        }
        
        if (is_descendant($con, $category_id, $parent_id)) {
            ob_clean();
            echo json_encode(['success' => false, 'error' => 'Cannot set a descendant category as parent. This would create a circular hierarchy.']);
            exit;
        }
    }

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

    // Check for duplicates in the same hierarchy (excluding current category)
    if ($parent_id === null) {
        // Check for root level categories with the same name
        $dupStmt = $con->prepare("SELECT 1 FROM notice_categories WHERE notice_category_name = ? AND (notice_parent_category_id IS NULL OR notice_parent_category_id = 0) AND notice_category_id != ? AND notice_category_status != 'deleted' LIMIT 1");
        if (!$dupStmt) {
            ob_clean();
            echo json_encode(['success' => false, 'error' => 'Could not validate existing categories.']);
            exit;
        }
        $dupStmt->bind_param("si", $category_name, $category_id);
    } else {
        // Check for categories with the same name under the same parent
        $dupStmt = $con->prepare("SELECT 1 FROM notice_categories WHERE notice_category_name = ? AND notice_parent_category_id = ? AND notice_category_id != ? AND notice_category_status != 'deleted' LIMIT 1");
        if (!$dupStmt) {
            ob_clean();
            echo json_encode(['success' => false, 'error' => 'Could not validate existing categories.']);
            exit;
        }
        $dupStmt->bind_param("sii", $category_name, $parent_id, $category_id);
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

    // Check if slug exists and generate unique slug (excluding current category)
    $final_slug = $base_slug;
    $slug_counter = 1;
    
    while (true) {
        $slugCheckStmt = $con->prepare("SELECT 1 FROM notice_categories WHERE notice_category_slug = ? AND notice_category_id != ? AND notice_category_status != 'deleted' LIMIT 1");
        if (!$slugCheckStmt) {
            ob_clean();
            echo json_encode(['success' => false, 'error' => 'Could not validate slug.']);
            exit;
        }
        $slugCheckStmt->bind_param("si", $final_slug, $category_id);
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
        $update_success = edit_notice_category(
            $category_id,
            $category_name,
            $parent_id,
            $final_slug
        );

        if ($update_success) {
            ob_clean();
            echo json_encode(['success' => true]);
        } else {
            ob_clean();
            echo json_encode(['success' => false, 'error' => 'Failed to update notice category.']);
        }
    } catch (Throwable $e) {
        ob_clean();
        echo json_encode(['success' => false, 'error' => 'Exception: ' . $e->getMessage()]);
    }
?>
