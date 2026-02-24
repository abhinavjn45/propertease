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

    $email = isset($_POST['email']) ? trim($_POST['email']) : '';

    if (empty($email) || !filter_var($email, FILTER_VALIDATE_EMAIL)) {
        echo json_encode(['success' => false, 'error' => 'Invalid email address.']);
        exit;
    }

    // Check if member already exists
    $existing_member = get_member_details(null, null, $email);
    if (!$existing_member) {
        echo json_encode(['success' => false, 'error' => 'Member with this email does not exist.']);
        exit;
    }

    $mail_sent = send_emails('resend_password_email', $email);
    
    if (!$mail_sent) {
        echo json_encode(['success' => false, 'error' => 'Member added but failed to send email.']);
        exit;
    }

    echo json_encode(['success' => true, 'message' => 'Member added successfully and email sent.']);
    exit;
?>
