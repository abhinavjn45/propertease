<?php
    session_start();
    require_once __DIR__ . '/../../../config/config.php';
    require_once __DIR__ . '/../../dashboard_functions.php';
    require_once __DIR__ . '/../../utility_functions.php';
    require_once __DIR__ . '/../../send_emails.php';

    // Check if user is logged in
    if (!isset($_SESSION['office_member_unique_id'])) {
        echo json_encode(['success' => false, 'error' => 'Unauthorized access.']);
        exit;
    }

    // Verify CSRF token
    if (!isset($_POST['csrf_token']) || $_POST['csrf_token'] !== $_SESSION['csrf_token']) {
        echo json_encode(['success' => false, 'error' => 'CSRF token validation failed.']);
        exit;
    }

    // Get form data
    $action = isset($_POST['action']) ? $_POST['action'] : '';
    $member_salutation = strtoupper(isset($_POST['member_salutation']) ? trim($_POST['member_salutation']) : '');
    $member_fullname = strtoupper(isset($_POST['member_fullname']) ? trim($_POST['member_fullname']) : '');
    $member_block = strtoupper(isset($_POST['member_block']) ? trim($_POST['member_block']) : '');
    $member_flat_number = isset($_POST['member_flat_number']) ? trim($_POST['member_flat_number']) : '';
    $member_email = strtolower(isset($_POST['member_email']) ? trim($_POST['member_email']) : '');
    $member_country_code = isset($_POST['member_country_code']) ? trim($_POST['member_country_code']) : '';
    $member_phone_number = isset($_POST['member_phone_number']) ? trim($_POST['member_phone_number']) : '';
    
    // Format phone number with space in middle (works for any length)
    $phone_length = strlen($member_phone_number);
    $mid_point = (int)($phone_length / 2);
    $formatted_phone = substr($member_phone_number, 0, $mid_point) . ' ' . substr($member_phone_number, $mid_point);
    $member_phone_number_data = $member_country_code . " " . $formatted_phone;
    
    $member_type = strtolower(isset($_POST['member_type']) ? trim($_POST['member_type']) : '');

    // Validate input
    if (!$action || $action !== 'add_member') {
        echo json_encode(['success' => false, 'error' => 'Invalid action.']);
        exit;
    }

    if (empty($member_salutation) || empty($member_fullname) || empty($member_block) || empty($member_flat_number) || 
        empty($member_email) || empty($member_country_code) || empty($member_phone_number) || empty($member_type)) {
        echo json_encode(['success' => false, 'error' => 'All required fields must be filled.']);
        exit;
    }

    // Validate email
    if (!filter_var($member_email, FILTER_VALIDATE_EMAIL)) {
        echo json_encode(['success' => false, 'error' => 'Invalid email address.']);
        exit;
    }

    // Check if email already exists
    $check_email_stmt = $con->prepare("SELECT member_id FROM members WHERE member_email = ? AND member_email != 'demo.member@gmail.com' LIMIT 1");
    $check_email_stmt->bind_param("s", $member_email);
    $check_email_stmt->execute();
    $check_email_result = $check_email_stmt->get_result();
    if ($check_email_result->num_rows > 0) {
        echo json_encode(['success' => false, 'error' => 'Email address already exists.']);
        $check_email_stmt->close();
        exit;
    }
    $check_email_stmt->close();

    // Handle image upload and resizing
    $member_image_filename = NULL;
    if (isset($_FILES['member_image_file']) && $_FILES['member_image_file']['size'] > 0) {
        $image_file = $_FILES['member_image_file'];
        
        // Validate file type
        $allowed_types = ['image/jpeg', 'image/png', 'image/webp', 'image/gif'];
        if (!in_array($image_file['type'], $allowed_types)) {
            echo json_encode(['success' => false, 'error' => 'Invalid image file type.']);
            exit;
        }

        // Validate file size (max 5MB)
        if ($image_file['size'] > 5 * 1024 * 1024) {
            echo json_encode(['success' => false, 'error' => 'Image size exceeds 5MB limit.']);
            exit;
        }

        // Generate unique filename
        $image_extension = pathinfo($image_file['name'], PATHINFO_EXTENSION);
        $member_image_filename = 'member_image_' . uniqid() . '.' . $image_extension;
        $upload_path = __DIR__ . '/../../../../assets/uploads/images/members/';

        // Create directory if it doesn't exist
        if (!is_dir($upload_path)) {
            mkdir($upload_path, 0755, true);
        }

        $temp_upload_path = $upload_path . $member_image_filename;

        // Move uploaded file to temporary location
        if (!move_uploaded_file($image_file['tmp_name'], $temp_upload_path)) {
            echo json_encode(['success' => false, 'error' => 'Failed to upload image.']);
            exit;
        }

        // Resize image to 120x120px
        $image = null;
        if ($image_file['type'] === 'image/jpeg') {
            $image = imagecreatefromjpeg($temp_upload_path);
        } elseif ($image_file['type'] === 'image/png') {
            $image = imagecreatefrompng($temp_upload_path);
        } elseif ($image_file['type'] === 'image/webp') {
            $image = imagecreatefromwebp($temp_upload_path);
        } elseif ($image_file['type'] === 'image/gif') {
            $image = imagecreatefromgif($temp_upload_path);
        }

        if (!$image) {
            unlink($temp_upload_path);
            echo json_encode(['success' => false, 'error' => 'Failed to process image.']);
            exit;
        }

        // Resize image to 120x120
        $resized_image = imagecreatetruecolor(120, 120);
        
        // Preserve transparency for PNG and GIF
        if ($image_file['type'] === 'image/png' || $image_file['type'] === 'image/gif') {
            $transparent = imagecolorallocatealpha($resized_image, 0, 0, 0, 127);
            imagefill($resized_image, 0, 0, $transparent);
            imagesavealpha($resized_image, true);
        }
        
        $width = imagesx($image);
        $height = imagesy($image);
        
        // Calculate crop coordinates to get a square
        $min_dimension = min($width, $height);
        $x = ($width - $min_dimension) / 2;
        $y = ($height - $min_dimension) / 2;
        
        // Copy and resize
        imagecopyresampled($resized_image, $image, 0, 0, $x, $y, 120, 120, $min_dimension, $min_dimension);

        // Delete original
        imagedestroy($image);

        // Save resized image
        if ($image_file['type'] === 'image/jpeg') {
            imagejpeg($resized_image, $temp_upload_path, 85);
        } elseif ($image_file['type'] === 'image/png') {
            imagepng($resized_image, $temp_upload_path, 9);
        } elseif ($image_file['type'] === 'image/webp') {
            imagewebp($resized_image, $temp_upload_path, 85);
        } elseif ($image_file['type'] === 'image/gif') {
            imagegif($resized_image, $temp_upload_path);
        }

        imagedestroy($resized_image);
    }

    // Generate unique member ID and add to database
    $logged_in_member = get_logged_in_member_details();
    if (!$logged_in_member) {
        if ($member_image_filename) {
            unlink($upload_path . $member_image_filename);
        }
        echo json_encode(['success' => false, 'error' => 'Session error. Please login again.']);
        exit;
    }

    $added_by = $logged_in_member['office_member_unique_id'];
    $added_on = date('Y-m-d H:i:s');

    // Generate member unique ID
    $get_max_number_stmt = $con->prepare("
        SELECT MAX(CAST(SUBSTRING(member_unique_id, -5) AS UNSIGNED)) as max_number 
        FROM members 
        WHERE member_unique_id LIKE CONCAT(?, '%') 
        AND member_email != 'demo.member@gmail.com'
    ");
    $id_prefix = 'JCGHS' . $member_block . $member_flat_number;
    $get_max_number_stmt->bind_param("s", $id_prefix);
    $get_max_number_stmt->execute();
    $max_number_result = $get_max_number_stmt->get_result();
    $max_number_row = $max_number_result->fetch_assoc();
    $next_number = ($max_number_row['max_number'] ?? 0) + 1;
    $get_max_number_stmt->close();

    $unique_id_number = str_pad($next_number, 5, '0', STR_PAD_LEFT);
    $member_unique_id = $id_prefix . $unique_id_number;

    // Call the database function
    $result = add_new_member(
        $member_salutation,
        $member_fullname,
        $member_block,
        $member_flat_number,
        $member_email,
        $member_phone_number_data,
        $member_type,
        $member_unique_id,
        $member_image_filename,
        $added_by,
        $added_on
    );

    if (!$result) {
        // Rollback: delete uploaded image if exists
        if ($member_image_filename) {
            unlink($upload_path . $member_image_filename);
        }
        echo json_encode(['success' => false, 'error' => 'Failed to add member to database.']);
        exit;
    }

    $mail_sent = send_emails('initial_password_send', $member_email);
    
    if (!$mail_sent) {
        echo json_encode(['success' => false, 'error' => 'Member added but failed to send email.']);
        exit;
    }

    echo json_encode(['success' => true, 'message' => 'Member added successfully and email sent.']);
    exit;
?>
