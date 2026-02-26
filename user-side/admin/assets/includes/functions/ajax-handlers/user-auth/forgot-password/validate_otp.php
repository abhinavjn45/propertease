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
    $resident_otp = isset($_POST['residentOTP']) ? trim($_POST['residentOTP']) : '';
    
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
    } elseif (empty($resident_otp) || strlen($resident_otp) != 6 || !ctype_digit($resident_otp)) {
        ob_clean();
        echo json_encode(['success' => false, 'error' => 'OTP is required.']);
        session_write_close();
        exit;
    } else {
        // Check if OTP was generated within last 10 minutes
        $stmt = $con->prepare("SELECT * FROM members WHERE member_email = ? AND member_vkey IS NOT NULL AND member_vkey_generated_on IS NOT NULL AND TIMESTAMPDIFF(MINUTE, member_vkey_generated_on, NOW()) < 10 AND member_status = 'active' LIMIT 1");
        
        if ($stmt) {
            $stmt->bind_param("s", $resident_email);
            $stmt->execute();
            $result = $stmt->get_result();
            
            if ($result->num_rows > 0) {
                $row = $result->fetch_assoc();

                // Verify hashed OTP using password_verify()
                if (password_verify($resident_otp, $row['member_vkey'])) {
                    if ($row['member_status'] === 'active') {
                        $_SESSION['member_email'] = $resident_email;
                        
                        // Rotate token after successful OTP validation
                        $new_token = get_csrf_token(true);
                        
                        ob_clean();
                        echo json_encode(['success' => true, 'csrf_token' => $new_token]);
                        exit();
                    } else {
                        ob_clean();
                        echo json_encode(['success' => false, 'error' => 'Your account is inactive or deleted. Please contact the Society admin.']);
                        session_write_close();
                        exit;
                    }
                } else {
                    ob_clean();
                    echo json_encode(['success' => false, 'error' => 'Invalid OTP. Please try again.']);
                    session_write_close();
                    exit;
                }

            } else {
                // Check if OTP exists but is expired
                $stmt_check = $con->prepare("SELECT member_vkey_generated_on FROM members WHERE member_email = ? AND member_vkey IS NOT NULL AND member_status = 'active' LIMIT 1");
                $stmt_check->bind_param("s", $resident_email);
                $stmt_check->execute();
                $check_result = $stmt_check->get_result();
                
                if ($check_result->num_rows > 0) {
                    ob_clean();
                    echo json_encode(['success' => false, 'error' => 'OTP has expired. Please request a new one.']);
                    session_write_close();
                    exit;
                } else {
                    ob_clean();
                    echo json_encode(['success' => false, 'error' => 'No active account found with this email or OTP not sent.']);
                    session_write_close();
                    exit;
                }
                $stmt_check->close();
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
