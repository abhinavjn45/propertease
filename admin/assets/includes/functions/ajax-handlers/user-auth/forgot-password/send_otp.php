<?php
    session_start();
    ob_start();
    header('Content-Type: application/json');
    error_reporting(E_ALL);
    ini_set('display_errors', '0');

    // Load DB config and helpers
    require_once __DIR__ . '/../../../../config/config.php';
    require_once __DIR__ . '/../../../dashboard_functions.php';
    require_once __DIR__ . '/../../../utility_functions.php';
    require_once __DIR__ . '/../../../send_emails.php';

    if ($_SERVER['REQUEST_METHOD'] !== 'POST') {
        ob_clean();
        echo json_encode(['success' => false, 'error' => 'Invalid request method']);
        session_write_close();
        exit;
    }

    // Verify CSRF token
    $csrf_token = $_POST['csrf_token'] ?? null;
    if (!verify_csrf_token($csrf_token)) {
        ob_clean();
        echo json_encode(['success' => false, 'error' => 'Invalid security token. Please refresh and try again.']);
        session_write_close();
        exit;
    }

    $resident_email = isset($_POST['residentResetPasswordEmail']) ? trim($_POST['residentResetPasswordEmail']) : '';
    
    if (empty($resident_email)) {
        ob_clean();
        echo json_encode(['success' => false, 'error' => 'Email is required.']);
        session_write_close();
        exit;
    } elseif (!filter_var($resident_email, FILTER_VALIDATE_EMAIL)) {
        ob_clean();
        echo json_encode(['success' => false, 'error' => 'Invalid email format.']);
        session_write_close();
        exit;
    } else {
        $stmt = $con->prepare("SELECT * FROM members WHERE member_email = ? AND member_status = 'active' LIMIT 1");
        
        if ($stmt) {
            $stmt->bind_param("s", $resident_email);
            $stmt->execute();
            $result = $stmt->get_result();
            
            if ($result->num_rows > 0) {
                $row = $result->fetch_assoc();
                
                $mail_sent = send_emails('resident_forgot_password' ,$resident_email);

                if ($mail_sent) {
                    // Rotate token after successful OTP send
                    $new_token = get_csrf_token(true);
                    
                    ob_clean();
                    echo json_encode(['success' => true, 'csrf_token' => $new_token]);
                    session_write_close();
                    exit();
                } else {
                    ob_clean();
                    echo json_encode(['success' => false, 'error' => 'Failed to send OTP email. Please try again later.']);
                    session_write_close();
                    exit;
                }

            } else {
                ob_clean();
                echo json_encode(['success' => false, 'error' => 'No active account found with this email.']);
                session_write_close();
                exit;
            }
            
            $stmt->close();
        } else {
            ob_clean();
            echo json_encode(['success' => false, 'error' => 'Database error. Please try again later.']);
            session_write_close();
            exit;
        }
    }
?>
