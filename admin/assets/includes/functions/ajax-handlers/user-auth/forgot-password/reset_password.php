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
    $new_password = isset($_POST['residentNewPassword']) ? trim($_POST['residentNewPassword']) : '';
    
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
    } elseif (empty($new_password)) {
        ob_clean();
        echo json_encode(['success' => false, 'error' => 'Password is required.']);
        session_write_close();
        exit;
    } elseif (strlen($new_password) < 8) {
        ob_clean();
        echo json_encode(['success' => false, 'error' => 'Password must be at least 8 characters long.']);
        session_write_close();
        exit;
    } else {
        // Verify member exists and has valid OTP
        $stmt = $con->prepare("SELECT * FROM members WHERE member_email = ? AND member_vkey IS NOT NULL AND member_vkey_generated_on IS NOT NULL AND TIMESTAMPDIFF(MINUTE, member_vkey_generated_on, NOW()) < 10 AND member_status = 'active' LIMIT 1");
        
        if ($stmt) {
            $stmt->bind_param("s", $resident_email);
            $stmt->execute();
            $result = $stmt->get_result();
            
            if ($result->num_rows > 0) {
                $row = $result->fetch_assoc();
                
                // Hash the new password
                $hashed_password = password_hash($new_password, PASSWORD_BCRYPT);
                
                // Update password and clear OTP
                $stmt_update = $con->prepare("UPDATE members SET member_password = ?, member_vkey = NULL, member_vkey_generated_on = NULL WHERE member_email = ? AND member_status = 'active'");
                
                if ($stmt_update) {
                    $stmt_update->bind_param("ss", $hashed_password, $resident_email);
                    
                    if ($stmt_update->execute()) {
                        // Clear session - user needs to login again
                        unset($_SESSION['member_email']);
                        
                        // Rotate token after successful password reset
                        $new_token = get_csrf_token(true);
                        
                        ob_clean();
                        echo json_encode(['success' => true, 'message' => 'Password reset successfully! Please login with your new password.', 'csrf_token' => $new_token]);
                        session_write_close();
                        exit();
                    } else {
                        ob_clean();
                        echo json_encode(['success' => false, 'error' => 'Failed to update password. Please try again later.']);
                        session_write_close();
                        exit;
                    }
                    
                    $stmt_update->close();
                } else {
                    ob_clean();
                    echo json_encode(['success' => false, 'error' => 'Database error. Please try again later.']);
                    exit;
                }

            } else {
                // Check if OTP has expired
                $stmt_check = $con->prepare("SELECT member_vkey_generated_on FROM members WHERE member_email = ? AND member_vkey IS NOT NULL AND member_status = 'active' LIMIT 1");
                $stmt_check->bind_param("s", $resident_email);
                $stmt_check->execute();
                $check_result = $stmt_check->get_result();
                
                if ($check_result->num_rows > 0) {
                    ob_clean();
                    echo json_encode(['success' => false, 'error' => 'OTP has expired. Please request a new one.']);
                } else {
                    ob_clean();
                    echo json_encode(['success' => false, 'error' => 'No active account found with this email or OTP not sent.']);
                }
                $stmt_check->close();
            }
            
            $stmt->close();
        } else {
            ob_clean();
            echo json_encode(['success' => false, 'error' => 'Database error. Please try again later.']);
            exit;
        }
    }
?>
