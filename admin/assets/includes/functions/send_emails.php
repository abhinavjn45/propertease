<?php 
    require_once __DIR__ . '/../config/config.php';
    require_once __DIR__ . '/data_fetcher.php';
    require_once __DIR__ . '/utility_functions.php';
    require_once __DIR__ . '/send_emails.php';

    //Import PHPMailer classes into the global namespace
    //These must be at the top of your script, not inside a function
    use PHPMailer\PHPMailer\PHPMailer;
    use PHPMailer\PHPMailer\SMTP;
    use PHPMailer\PHPMailer\Exception;

    //Load Composer's autoloader
    require __DIR__ . '/../php-mailer/Exception.php';
    require __DIR__ . '/../php-mailer/PHPMailer.php';
    require __DIR__ . '/../php-mailer/SMTP.php';

    function send_emails($purpose, $to_email) {
        global $con;

        if (get_site_option('can_send_mail') !== 'on') {
            return false;
        }

        $temp_query = "SELECT * FROM email_templates WHERE email_template_purpose = ? AND email_template_status = 'active' LIMIT 1";
        $temp_stmt = $con->prepare($temp_query);
        $temp_stmt->bind_param("s", $purpose);
        $temp_stmt->execute();
        $temp_result = $temp_stmt->get_result();
        
        if (mysqli_num_rows($temp_result) <= 0) {
            return false;
        }

        $template = $temp_result->fetch_assoc();

        $member = get_member_details(null, null, $to_email);

        if (!$member) {
            return false;
        }

        $member_password = '';
        $member_password_hashed = '';
        $member_otp = '';
        $member_otp_hashed = '';

        if ($purpose === 'initial_password_send' || $purpose === 'resend_password_email') {
            $member_password = generate_random_password(8);
            $member_password_hashed = password_hash($member_password, PASSWORD_BCRYPT);
        } elseif ($purpose === 'resident_forgot_password') {
            $member_otp = generate_otp(6);
            $member_otp_hashed = password_hash($member_otp, PASSWORD_BCRYPT);
        }

        $placeholders = [
            // Site Options
            '{site_title}' => get_site_option('site_title'),
            '{site_url}' => get_site_option('site_url'),
            '{admin_email}' => get_site_option('admin_email'),
            '{timezone}' => get_site_option('timezone'),
            '{maintainance_mode}' => get_site_option('maintainance_mode'),
            '{logo}' => get_site_option('logo'),
            '{light_logo}' => get_site_option('light_logo'),
            '{logo_icon}' => get_site_option('logo_icon'),
            '{footer_text}' => get_site_option('footer_text'),
            '{footer_right_text}' => get_site_option('footer_right_text'),
            '{site_fullname}' => get_site_option('site_fullname'),
            '{dashboard_url}' => get_site_option('dashboard_url'),

            // Office Details
            '{office_complete_address}' => get_office_address(),
            '{office_phone_number}' => get_office_details('office_phone_number'),
            '{office_email_address}' => get_office_details('office_email_address'),
            '{office_email_address}' => get_office_details('office_email_address'),
            '{office_hours}' => get_office_hours(),

            // Member Details - to be replaced dynamically
            '{member_salutation}' => ucwords(strtolower(htmlspecialchars($member['member_salutation']))),
            '{member_fullname}' => ucwords(strtolower(htmlspecialchars($member['member_fullname']))),
            '{member_email}' => strtolower(htmlspecialchars($to_email)),
            '{member_password}' => $member_password,
            '{otp}' => $member_otp
        ];

        $email_subject = $template['email_template_subject'];
            $email_subject = str_replace(array_keys($placeholders), array_values($placeholders), $email_subject);
        
        $email_body = $template['email_template_body'];
            $email_body = str_replace(array_keys($placeholders), array_values($placeholders), $email_body);
    
        $temp_stmt->close();

        //Create an instance; passing `true` enables exceptions
        $mail = new PHPMailer(true);

        try {
            //Server settings
            $mail->SMTPDebug = 0;                      //Enable verbose debug output
            $mail->isSMTP();                                            //Send using SMTP
            $mail->Host       = get_site_option('webmail_host');                     //Set the SMTP server to send through
            $mail->SMTPAuth   = true;                                   //Enable SMTP authentication
            $mail->Username   = get_site_option('webmail_username');                     //SMTP username
            $mail->Password   = get_site_option('webmail_auth');                               //SMTP password
            $mail->SMTPSecure = PHPMailer::ENCRYPTION_SMTPS;            //Enable implicit TLS encryption
            $mail->Port       = get_site_option('webmail_port');                                    //TCP port to connect to; use 587 if you have set `SMTPSecure = PHPMailer::ENCRYPTION_STARTTLS`

            //Recipients
            $mail->setFrom(get_site_option('webmail_username'), get_site_option('site_title'));

            $mail->addAddress($to_email);     //Add a recipient

            //Content
            $mail->isHTML(true);                                  //Set email format to HTML
            $mail->Subject = $email_subject;
            $mail->Body    = $email_body;

            if ($purpose === 'initial_password_send' || $purpose === 'resend_password_email') {
                $stmt_update = $con->prepare("UPDATE members SET member_password = ? WHERE member_email = ?");
                $stmt_update->bind_param("ss", $member_password_hashed, $to_email);
                    if ($stmt_update->execute()) {
                        if ($mail->send()) {
                            return true;
                        } else {
                            return false;
                        }
                    } else {
                        return false;
                    }
            } elseif ($purpose === 'resident_forgot_password') {
                $stmt_update = $con->prepare("UPDATE members SET member_vkey = ?, member_vkey_generated_on = ? WHERE member_email = ?");
                $current_time = date('Y-m-d H:i:s');
                $stmt_update->bind_param("sss", $member_otp_hashed, $current_time, $to_email);
                    if ($stmt_update->execute()) {
                        if ($mail->send()) {
                            return true;
                        } else {
                            return false;
                        }
                    } else {
                        return false;
                    }
            } else {
                if ($mail->send()) {
                    return true;
                } else {
                    return false;
                }
            }
            $stmt_update->close();
        } catch (Exception $e) {
            return false;
        }
    }
?>