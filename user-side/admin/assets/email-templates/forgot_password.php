<!doctype html>
<html lang='en'>
<head>
    <meta charset='UTF-8'>
    <meta name='viewport' content='width=device-width, initial-scale=1.0'>
    <meta name='color-scheme' content='light'>
    <meta name='supported-color-schemes' content='light'>
    <title>Forgot Password Email Template</title>
</head>
<body style='margin: 0; padding: 0; font-family: "Segoe UI", Tahoma, Geneva, Verdana, sans-serif; background-color: #f0f4f8; overflow-x: hidden;'>
    <div class='email-wrapper' style='width: 100%; min-height: 100vh; background-color: #f0f4f8; padding: 20px 10px;'>
        <!-- Email Preview Container -->
        <table class='presentation-table' role='presentation' cellspacing='0' cellpadding='0' style='border: 0; width: 100%; max-width: 600px; margin: 0 auto;'>
            <tbody>
                <tr>
                    <td>
                        <table class='email-container' role='presentation' cellspacing='0' cellpadding='0' style='border: 0; width: 100%; background-color: #ffffff; border-radius: 12px; overflow: hidden; box-shadow: 0 4px 20px rgba(11, 60, 138, 0.1); border: 1px solid #e3ebff;'>
                            <!-- Header -->
                            <tbody>
                                <tr>
                                    <td class='email-header' style='background: linear-gradient(135deg, #0b3c8a 0%, #122142 100%); padding: 30px 24px; text-align: center; border-bottom: 3px solid #ffc107;'>
                                        <table role='presentation' cellspacing='0' cellpadding='0' border='0' width='100%'>
                                            <tbody>
                                                <tr>
                                                    <td align='center'>
                                                        <img src='{site_url}assets/images/logos/{logo}' alt='Site Logo' id='society-logo' style='background-color: #ffffff; width: 80px; height: 80px; border-radius: 50%; object-fit: cover; box-shadow: 0 0 0 4px rgba(255, 255, 255, 0.2); margin-bottom: 16px; display: block; margin-left: auto; margin-right: auto;'>
                                                        <h1 class='header-title' id='society-name' style='margin: 0; padding: 0; color: #ffffff; font-size: 20px; font-weight: 700; text-transform: uppercase; letter-spacing: 0.5px; line-height: 1.3;'>
                                                            {site_title}
                                                        </h1>
                                                        <p style='margin: 8px 0 0 0; padding: 0; color: #c7d8ff; font-size: 13px; text-transform: uppercase; letter-spacing: 1px; font-weight: 600;'>Official Communication</p>
                                                    </td>
                                                </tr>
                                            </tbody>
                                        </table>
                                    </td>
                                </tr>
                                <tr>
                                    <td class='email-body' style='background-color: #ffffff; padding: 0;'>
                                        <table role='presentation' cellspacing='0' cellpadding='0' border='0' width='100%'>
                                            <!-- Greeting Section -->
                                            <tbody>
                                                <tr>
                                                    <td style='padding: 32px 24px 24px 24px;'>
                                                        <p id='email-greeting' style='margin: 0; padding: 0; color: #122142; font-size: 17px; font-weight: 600; line-height: 1.5;'>
                                                            Dear {member_salutation} {member_fullname},
                                                        </p>
                                                    </td>
                                                </tr>
                                                <!-- Main Content -->
                                                <tr>
                                                    <td style='padding: 0 24px 0 24px;'>
                                                        <div class='content-text' id='email-body' style='color: #4d5c82; font-size: 16px; line-height: 1.8; margin: 0;'>
                                                            <p style='margin: 0 0 16px 0;'>We received a request to reset your password for your {site_title} Resident Portal account. To proceed with resetting your password, please use the One-Time Password (OTP) below:</p>
                                                        </div>
                                                    </td>
                                                </tr>
                                                <!-- Info Box -->
                                                <tr>
                                                    <td style='padding: 0 24px 0 24px;'>
                                                        <div class='otp-section' style='background: linear-gradient(135deg, #f8faff 0%, #e8f0ff 100%); border: 2px solid #0b3c8a; border-radius: 12px; padding: 2rem; text-align: center; margin: 1rem 0;'>
                                                            <div class='otp-label' style='font-size: 0.9rem; font-weight: 600; color: #6c7aa5; text-transform: uppercase; letter-spacing: 0.1em; margin-bottom: 1rem;'>
                                                                Your One-Time Password
                                                            </div>
                                                            <div class='otp-code' id='otpCode' style='font-size: 2.5rem; font-weight: 700; color: #0b3c8a; letter-spacing: 0.5rem; font-family: "Courier New", monospace; margin: 0;'>
                                                                {otp}
                                                            </div>
                                                            <div class='otp-validity' style='font-size: 0.85rem; color: #dc3545; font-weight: 600; margin-top: 1rem; display: flex; align-items: center; justify-content: center; gap: 0.5rem;'>
                                                                &#8986; <span>This OTP is valid for 10 minutes only</span>
                                                            </div>
                                                        </div>

                                                        <div class='security-notice' style='background: #fff3cd; border-left: 4px solid #ffc107; border-radius: 0.5rem; padding: 1.25rem; margin: 1rem 0;'>
                                                            <div class='security-title' style='font-size: 1rem; font-weight: 700; color: #856404; margin: 0 0 0.5rem 0; display: flex; align-items: center; gap: 0.5rem;'>
                                                                &#128737; <span>Security Notice</span>
                                                            </div>
                                                            <p class='security-text' style='font-size: 0.9rem; color: #856404; line-height: 1.6; margin: 0;'>If you did not request a password reset, please ignore this email and contact our support team immediately. Your account security is important to us.</p>
                                                        </div>
                                                    </td>
                                                </tr>
                                                <tr>
                                                    <td style='padding: 0 24px 0 24px;'>
                                                        <p class='email-text' style='font-size: 1rem; color: #4d5c82; line-height: 1.7; margin: 0 0 1.5rem 0;'>Enter this OTP on the password reset page to create your new password. For your security, do not share this OTP with anyone, including society staff members.</p>
                                                    </td>
                                                </tr>
                                                <!-- Key Points Section -->
                                                <tr>
                                                    <td style='padding: 0 24px 24px 24px;'>
                                                        <div class='info-box' style='background: #f8faff; border: 1px solid #e3ebff; border-radius: 0.75rem; padding: 1.25rem; margin: 0 0;'>
                                                            <div class='info-title' style='font-size: 0.95rem; font-weight: 700; color: #122142; margin: 0 0 0.75rem 0;'>
                                                                Password Reset Guidelines:
                                                            </div>
                                                            <ul class='info-list' style='list-style: none; padding: 0; margin: 0;'>
                                                                <li style='font-size: 0.9rem; color: #4d5c82; line-height: 1.6; margin-bottom: 0.5rem; padding-left: 1.5rem; position: relative;'>
                                                                    <span style='position: absolute; left: 0; color: #198754; font-weight: 700;'>&#10004;</span>
                                                                    Use this OTP within 10 minutes of receiving this email
                                                                </li>
                                                                <li style='font-size: 0.9rem; color: #4d5c82; line-height: 1.6; margin-bottom: 0.5rem; padding-left: 1.5rem; position: relative;'>
                                                                    <span style='position: absolute; left: 0; color: #198754; font-weight: 700;'>&#10004;</span>
                                                                    Create a strong password with at least 8 characters
                                                                </li>
                                                                <li style='font-size: 0.9rem; color: #4d5c82; line-height: 1.6; margin-bottom: 0.5rem; padding-left: 1.5rem; position: relative;'>
                                                                    <span style='position: absolute; left: 0; color: #198754; font-weight: 700;'>&#10004;</span>
                                                                    Include a mix of uppercase, lowercase, numbers, and symbols
                                                                </li>
                                                                <li style='font-size: 0.9rem; color: #4d5c82; line-height: 1.6; margin-bottom: 0.5rem; padding-left: 1.5rem; position: relative;'>
                                                                    <span style='position: absolute; left: 0; color: #198754; font-weight: 700;'>&#10004;</span>
                                                                    Never share your password with anyone
                                                                </li>
                                                                <li style='font-size: 0.9rem; color: #4d5c82; line-height: 1.6; margin-bottom: 0.5rem; padding-left: 1.5rem; position: relative;'>
                                                                    <span style='position: absolute; left: 0; color: #198754; font-weight: 700;'>&#10004;</span>
                                                                    Change your password regularly for better security
                                                                </li>
                                                            </ul>
                                                        </div>
                                                    </td>
                                                </tr>

                                                <!-- Closing -->
                                                <tr>
                                                    <td style='padding: 0 24px 32px 24px;'>
                                                        <div class='content-text' style='color: #4d5c82; font-size: 16px; line-height: 1.8;'>
                                                            <p style='margin: 0 0 16px 0;'>For any queries or clarifications, please feel free to contact the society office during working hours or reach out to us at <a href='mailto:{office_email_address}' style='color: #0b3c8a; text-decoration: none; font-weight: 600;'>{office_email_address}</a>.</p>
                                                            <p style='margin: 0; font-weight: 600; color: #122142;'>
                                                                Warm regards,<br>
                                                                Managing Committee<br>
                                                                {site_fullname}
                                                            </p>
                                                        </div>
                                                    </td>
                                                </tr>
                                            </tbody>
                                        </table>
                                    </td>
                                </tr>
                                <!-- Footer -->
                                <tr>
                                    <td class='email-footer' style='background-color: #f8faff; padding: 24px; text-align: center; border-top: 2px solid #e3ebff;'>
                                        <table role='presentation' cellspacing='0' cellpadding='0' border='0' width='100%'>
                                            <!-- Contact Info -->
                                            <tbody>
                                                <tr>
                                                    <td style='padding-bottom: 16px;'>
                                                        <p style='margin: 0 0 12px 0; color: #6c7aa5; font-size: 14px; font-weight: 600; text-transform: uppercase; letter-spacing: 0.5px;'>
                                                            Contact Information
                                                        </p>
                                                        <table role='presentation' cellspacing='0' cellpadding='0' border='0' align='center'>
                                                            <tbody>
                                                                <tr>
                                                                    <td style='padding: 0 12px;'>
                                                                        &#128231; 
                                                                        <a href='mailto:{office_email_address}' class='footer-link' id='footer-contact' style='color: #0b3c8a; text-decoration: none; font-size: 14px; font-weight: 600;'> 
                                                                            {office_email_address} 
                                                                        </a>
                                                                    </td>
                                                                </tr>
                                                                <tr>
                                                                    <td style='padding: 8px 12px 0 12px;'>
                                                                        &#128222; 
                                                                        <a href='tel:{office_phone_number}' class='footer-link' id='footer-phone' style='color: #0b3c8a; text-decoration: none; font-size: 14px; font-weight: 600;'> 
                                                                            {office_phone_number} 
                                                                        </a>
                                                                    </td>
                                                                </tr>
                                                            </tbody>
                                                        </table>
                                                    </td>
                                                </tr>
                                                <!-- Divider -->
                                                <tr>
                                                    <td style='padding: 16px 0;'>
                                                        <div class='divider' style='height: 1px; background-color: #d3def8; margin: 0;'></div>
                                                    </td>
                                                </tr>
                                                <!-- Office Hours -->
                                                <tr>
                                                    <td style='padding-bottom: 16px;'>
                                                        <p style='margin: 0; color: #6c7aa5; font-size: 13px; line-height: 1.6;'>
                                                            <strong>Office Hours:</strong><br>
                                                            {office_hours}
                                                        </p>
                                                    </td>
                                                </tr>
                                                <!-- Divider -->
                                                <tr>
                                                    <td style='padding: 16px 0;'>
                                                        <div class='divider' style='height: 1px; background-color: #d3def8; margin: 0;'></div>
                                                    </td>
                                                </tr>
                                                <!-- Copyright -->
                                                <tr>
                                                    <td>
                                                        <p style='margin: 0 0 8px 0; color: #6c7aa5; font-size: 12px; line-height: 1.6;'>
                                                            {footer_text}
                                                        </p>
                                                        <p style='margin: 0; color: #8ba3d4; font-size: 11px; line-height: 1.5;'>
                                                            This is an official email from {site_title}<br>
                                                            Please do not reply directly to this email.
                                                        </p>
                                                    </td>
                                                </tr>
                                            </tbody>
                                        </table>
                                    </td>
                                </tr>
                            </tbody>
                        </table>
                    </td>
                </tr>
            </tbody>
        </table>
    </div>
</body>
</html>