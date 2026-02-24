<?php
session_start();
header('Content-Type: application/json');

// Include database connection and helper functions
require_once __DIR__ . '/../../../config/config.php';
require_once __DIR__ . '/../../dashboard_functions.php';
require_once __DIR__ . '/../../utility_functions.php';
require_once __DIR__ . '/../../send_emails.php';

// Ensure we have a mysqli connection as $conn
$conn = isset($con) ? $con : null;
if (!$conn) {
    http_response_code(500);
    echo json_encode(['success' => false, 'message' => 'Database connection not initialized.']);
    exit;
}

// Check CSRF token
if (!isset($_POST['csrf_token']) || !verify_csrf_token($_POST['csrf_token'])) {
    http_response_code(403);
    echo json_encode(['success' => false, 'message' => 'CSRF token validation failed.']);
    exit;
}

// Check if user is authenticated
if (!isset($_SESSION['office_member_unique_id'])) {
    http_response_code(401);
    echo json_encode(['success' => false, 'message' => 'User not authenticated.']);
    exit;
}

// Validate input
if (!isset($_FILES['gallery_images']) || !isset($_POST['gallery_titles'])) {
    echo json_encode(['success' => false, 'message' => 'No images or titles provided.']);
    exit;
}

$images = $_FILES['gallery_images'];
$titles = $_POST['gallery_titles'];

// Validate arrays
if (!is_array($images['name']) || !is_array($titles)) {
    echo json_encode(['success' => false, 'message' => 'Invalid image or title format.']);
    exit;
}

// Count should match
if (count($images['name']) !== count($titles)) {
    echo json_encode(['success' => false, 'message' => 'Number of images and titles do not match.']);
    exit;
}

$uploadDir = __DIR__ . '/../../../../uploads/images/gallery/';
if (!is_dir($uploadDir)) {
    mkdir($uploadDir, 0755, true);
}

$allowedMimes = ['image/jpeg', 'image/png', 'image/gif', 'image/webp'];
$maxFileSize = 5 * 1024 * 1024; // 5MB
$uploadedCount = 0;
$errors = [];

try {
    // Begin database transaction
    $conn->begin_transaction();

    // Get current user info
    $uploadedBy = $_SESSION['office_member_unique_id'] ?? NULL;

    // Process each image
    for ($i = 0; $i < count($images['name']); $i++) {
        $file = [
            'name' => $images['name'][$i],
            'tmp_name' => $images['tmp_name'][$i],
            'size' => $images['size'][$i],
            'error' => $images['error'][$i],
            'type' => $images['type'][$i]
        ];

        $title = trim($titles[$i]);

        // Validate title
        if (empty($title)) {
            $errors[] = "Image " . ($i + 1) . ": Title cannot be empty.";
            continue;
        }

        if (strlen($title) > 255) {
            $errors[] = "Image " . ($i + 1) . ": Title is too long (max 255 characters).";
            continue;
        }

        // Check upload errors
        if ($file['error'] !== UPLOAD_ERR_OK) {
            $errors[] = "Image " . ($i + 1) . ": Upload error code " . $file['error'];
            continue;
        }

        // Validate file type
        if (!in_array($file['type'], $allowedMimes)) {
            $errors[] = "Image " . ($i + 1) . ": Invalid file type. Allowed types: JPEG, PNG, GIF, WebP";
            continue;
        }

        // Validate file size
        if ($file['size'] > $maxFileSize) {
            $errors[] = "Image " . ($i + 1) . ": File size exceeds 5MB limit.";
            continue;
        }

        // Validate MIME type from file content
        $finfo = finfo_open(FILEINFO_MIME_TYPE);
        $mimeType = finfo_file($finfo, $file['tmp_name']);
        finfo_close($finfo);

        if (!in_array($mimeType, $allowedMimes)) {
            $errors[] = "Image " . ($i + 1) . ": Invalid file content type.";
            continue;
        }

        // Generate unique filename
        $fileExt = pathinfo($file['name'], PATHINFO_EXTENSION);
        $fileName = 'gallery_' . time() . '_' . $i . '_' . md5(uniqid()) . '.' . strtolower($fileExt);
        $filePath = $uploadDir . $fileName;

        // Move uploaded file
        if (!move_uploaded_file($file['tmp_name'], $filePath)) {
            $errors[] = "Image " . ($i + 1) . ": Failed to save file.";
            continue;
        }

        // Prepare and execute database insert
        $stmt = $conn->prepare("
            INSERT INTO gallery (gallery_title, gallery_image, gallery_status, gallery_uploaded_by, gallery_uploaded_on)
            VALUES (?, ?, 'published', ?, NOW())
        ");

        if (!$stmt) {
            $errors[] = "Image " . ($i + 1) . ": Database error - " . $conn->error;
            unlink($filePath); // Remove uploaded file on error
            continue;
        }

        // Bind parameters - use relative path for storage
        $stmt->bind_param("sss", $title, $fileName, $uploadedBy);

        if (!$stmt->execute()) {
            $errors[] = "Image " . ($i + 1) . ": Failed to save to database - " . $stmt->error;
            unlink($filePath); // Remove uploaded file on error
            $stmt->close();
            continue;
        }

        $stmt->close();
        $uploadedCount++;
    }

    // Commit transaction if at least one image was uploaded
    if ($uploadedCount > 0) {
        $conn->commit();
        
        $message = $uploadedCount . ' image(s) uploaded successfully';
        if (!empty($errors)) {
            $message .= '. ' . count($errors) . ' image(s) failed to upload.';
        }

        echo json_encode([
            'success' => true,
            'message' => $message,
            'uploaded_count' => $uploadedCount,
            'errors' => $errors
        ]);
    } else {
        $conn->rollback();
        
        echo json_encode([
            'success' => false,
            'message' => 'No images were uploaded successfully.',
            'errors' => $errors
        ]);
    }

} catch (Exception $e) {
    $conn->rollback();
    
    http_response_code(500);
    echo json_encode([
        'success' => false,
        'message' => 'Server error: ' . $e->getMessage()
    ]);
}

$conn->close();
?>
