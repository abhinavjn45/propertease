<?php 
    require_once __DIR__ . '/utility_functions.php';

    if (isset($_POST['resident_login'])) {
        // Verify CSRF token
        $csrf_token = $_POST['csrf_token'] ?? null;
        if (!verify_csrf_token($csrf_token)) {
            exit;
        }


        $resident_email = isset($_POST['loginEmail']) ? trim($_POST['loginEmail']) : '';
        $resident_password = isset($_POST['loginPassword']) ? $_POST['loginPassword'] : '';
        
        if (empty($resident_email)) {
            $msg = "Email is required!";
        } elseif (!filter_var($resident_email, FILTER_VALIDATE_EMAIL)) {
            $msg = "Invalid email format!";
        } elseif (empty($resident_password)) {
            $msg = "Password is required!";
        } elseif (strlen($resident_password) < 3 || strlen($resident_password) > 100) {
            $msg = "Invalid password!";
        } else {
            $stmt = $con->prepare("SELECT member_id, member_password, member_status FROM members WHERE member_email = ?");
            
            if ($stmt) {
                $stmt->bind_param("s", $resident_email);
                $stmt->execute();
                $result = $stmt->get_result();
                
                if ($result->num_rows > 0) {
                    $row = $result->fetch_assoc();
                    
                    // Verify hashed password using password_verify()
                    if (password_verify($resident_password, $row['member_password'])) {
                        if ($row['member_status'] === 'active') {
                            $_SESSION['member_email'] = $resident_email;
                            $_SESSION['member_id'] = $row['member_id'];
                            header("Location: " . get_site_option('site_url'));
                            exit();
                        } else {
                            $msg = "Your account is inactive or deleted. Please contact the Society admin.";
                        }
                    } else {
                        $msg = "Invalid Email or Password!";
                    }
                } else {
                    $msg = "Invalid Email or Password!";
                }
                
                $stmt->close();
            } else {
                $msg = "Database error. Please try again later.";
            }
        }
    }

    if (isset($_POST['office_login'])) {
        // Verify CSRF token
        $csrf_token = $_POST['csrf_token'] ?? null;
        if (!verify_csrf_token($csrf_token)) {
            exit;
        }


        // Sanitize and validate inputs
        $office_email = isset($_POST['officeLoginEmail']) ? trim($_POST['officeLoginEmail']) : '';
        $office_password = isset($_POST['officeLoginPassword']) ? $_POST['officeLoginPassword'] : '';
        
        // Validate email format
        if (empty($office_email)) {
            $o_msg = "Email is required!";
        } elseif (!filter_var($office_email, FILTER_VALIDATE_EMAIL)) {
            $o_msg = "Invalid email format!";
        } elseif (empty($office_password)) {
            $o_msg = "Password is required!";
        } elseif (strlen($office_password) < 3 || strlen($office_password) > 100) {
            $o_msg = "Invalid password!";
        } else {
            // Use prepared statement to prevent SQL injection
            $stmt = $con->prepare("SELECT office_member_id, office_member_unique_id, office_member_password, office_member_status FROM office_members WHERE office_member_email = ?");
            
            if ($stmt) {
                $stmt->bind_param("s", $office_email);
                $stmt->execute();
                $result = $stmt->get_result();
                
                if ($result->num_rows > 0) {
                    $row = $result->fetch_assoc();
                    
                    // Verify hashed password using password_verify()
                    if (password_verify($office_password, $row['office_member_password'])) {
                        if ($row['office_member_status'] === 'active') {
                            $_SESSION['office_member_unique_id'] = $row['office_member_unique_id'];
                            header("Location: " . get_site_option('dashboard_url'));
                            exit();
                        } else {
                            $o_msg = "Your account is inactive or deleted. Please contact the Society admin.";
                        }
                    } else {
                        $o_msg = "Invalid Email or Password!";
                    }
                } else {
                    $o_msg = "Invalid Email or Password!";
                }
                
                $stmt->close();
            } else {
                $o_msg = "Database error. Please try again later.";
            }
        }
    }

    function check_user_logged_in() {
        if (isset($_SESSION['member_email'])) {
            return true;
        } elseif (isset($_SESSION['office_member_email'])) {
            return true;
        }
    }

    // Redirect based on who is logged in: members refresh current page; office members go elsewhere
    function redirect_if_logged_in($office_redirect_url = './office/') {
        if (isset($_SESSION['office_member_email'])) {
            header('Location: ' . $office_redirect_url);
            exit();
        }

        if (isset($_SESSION['member_email'])) {
            $current_url = $_SERVER['REQUEST_URI'] ?? './';
            header('Location: ' . $current_url);
            exit();
        }
    }

    if (isset($_POST['change_password'])) {
        $new_password = isset($_POST['newPassword']) ? $_POST['newPassword'] : '';
        $confirm_new_password = isset($_POST['confirmPassword']) ? $_POST['confirmPassword'] : '';

        if (empty($new_password) || empty($confirm_new_password)) {
            $cp_msg = "Both password fields are required!";
        } elseif ($new_password !== $confirm_new_password) {
            $cp_msg = "Passwords do not match!";
        } elseif (strlen($new_password) < 6) {
            $cp_msg = "Password must be at least 6 characters long!";
        } else {
            // Hash the new password
            $hashed_password = password_hash($new_password, PASSWORD_DEFAULT);

            // Update the password in the database
            if (isset($_SESSION['member_email'])) {
                $member_email = $_SESSION['member_email'];
                $stmt = $con->prepare("UPDATE members SET member_password = ? WHERE member_email = ?");
                if ($stmt) {
                    $stmt->bind_param("ss", $hashed_password, $member_email);
                    if ($stmt->execute()) {
                        echo "<script>alert('Password changed successfully. Please log in again.');</script>";
                        header("Location: " . get_site_option('site_url') . "user-auth/logout/");
                        exit();
                    } else {
                        echo "<script>alert('Error updating password. Please try again.');</script>";
                        header("Location: " . get_site_option('site_url') . "user-auth/my-account/");
                        exit();
                    }
                    $stmt->close();
                } else {
                    echo "<script>alert('Error updating password. Please try again.');</script>";
                    header("Location: " . get_site_option('site_url') . "user-auth/my-account/");
                    exit();
                }
            } else {
                echo "<script>alert('No user is logged in.');</script>";
                header("Location: " . get_site_option('site_url') . "user-auth/my-account/");
                exit();
            }
        }
    }
?>