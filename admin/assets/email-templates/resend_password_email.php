<!doctype html>
<html lang='en'>
<head>
    <meta charset='UTF-8'>
    <meta name='viewport' content='width=device-width, initial-scale=1.0'>
    <meta name='color-scheme' content='light'>
    <meta name='supported-color-schemes' content='light'>
    <title>Resend Password Send Email Template</title>
    <link rel='stylesheet' href='https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.1/css/all.min.css' integrity='sha512-DTOQO9RWCH3ppGqcWaEA1BIZOC6xxalwEsw9c2QQeAIftl+Vegovlnee1c9QX4TctnWMn13TZye+giMm8e2LwA==' crossorigin='anonymous' referrerpolicy='no-referrer'>
</head>
<body style="margin: 0; padding: 0; font-family: 'Segoe UI', Tahoma, Geneva, Verdana, sans-serif; background-color: #f0f4f8; overflow-x: hidden; box-sizing: border-box;">
    <div class='email-wrapper' style="width: 100%; min-height: 100vh; background-color: #f0f4f8; padding: 20px 10px; box-sizing: border-box;">
        <!-- Email Preview Container -->
        <table class='presentation-table' role='presentation' cellspacing='0' cellpadding='0' style="border: 0; width: 100%; max-width: 600px; margin: 0 auto; box-sizing: border-box;">
            <tbody>
                <tr>
                    <td>
                        <table class='email-container' role='presentation' cellspacing='0' cellpadding='0' style="border: 0; width: 100%; background-color: #ffffff; border-radius: 12px; overflow: hidden; box-shadow: 0 4px 20px rgba(11, 60, 138, 0.1); border: 1px solid #e3ebff; box-sizing: border-box;">
                            <!-- Header -->
                            <tbody>
                                <tr>
                                    <td class='email-header' style="background: linear-gradient(135deg, #0b3c8a 0%, #122142 100%); padding: 30px 24px; text-align: center; border-bottom: 3px solid #ffc107; box-sizing: border-box;">
                                        <table role='presentation' cellspacing='0' cellpadding='0' border='0' width='100%'>
                                            <tbody>
                                                <tr>
                                                    <td align='center'>
                                                        <img src='{site_url}assets/images/logos/{logo}' alt='Site Logo' id='society-logo' style="background-color: #ffffff; width: 80px; height: 80px; border-radius: 50%; object-fit: cover; box-shadow: 0 0 0 4px rgba(255, 255, 255, 0.2); margin-bottom: 16px; display: block; margin-left: auto; margin-right: auto;">
                                                        <h1 class='header-title' id='society-name' style="margin: 0; padding: 0; color: #ffffff; font-size: 20px; font-weight: 700; text-transform: uppercase; letter-spacing: 0.5px; line-height: 1.3;">
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
                                    <td class='email-body' style="background-color: #ffffff; padding: 0; box-sizing: border-box;">
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
                                                <!-- Subject Line -->
                                                <tr>
                                                    <td style='padding: 0 24px 24px 24px;'>
                                                        <h2 class='subject-line' id='email-subject' style='margin: 0; padding: 0; color: #0b3c8a; font-size: 26px; font-weight: 700; line-height: 1.3;'>
                                                            Your Password Has Been Reset for {site_title} Resident Portal
                                                        </h2>
                                                    </td>
                                                </tr>
                                                <!-- Divider -->
                                                <tr>
                                                    <td style='padding: 0 24px;'>
                                                        <div class='divider' style='height: 2px; background-color: #e3ebff; margin: 0;'></div>
                                                    </td>
                                                </tr>
                                                <!-- Main Content -->
                                                <tr>
                                                    <td style='padding: 24px 24px 24px 24px;'>
                                                        <div class='content-text' id='email-body' style='color: #4d5c82; font-size: 16px; line-height: 1.8; margin: 0;'>
                                                            <p style='margin: 0 0 16px 0;'>
                                                                This email is to inform you that your password for the <strong>{site_title}</strong> Resident Portal has been successfully reset.
                                                            </p>
                                                            <p style='margin: 0 0 16px 0;'>
                                                                As requested, we are sharing a <strong>new temporary password</strong> below so you can regain access to your account.
                                                            </p>
                                                            <p style='margin: 0 0 16px 0;'>
                                                                For security reasons, please keep this information confidential and do not share it with anyone.
                                                            </p>
                                                        </div>
                                                    </td>
                                                </tr>
                                                <!-- Info Box -->
                                                <tr>
                                                    <td style='padding: 0 24px 24px 24px;'>
                                                        <table class='info-box' role='presentation' cellspacing='0' cellpadding='0' border='0' width='100%' style='background-color: #fff9e6; border-left: 4px solid #ffc107; border-radius: 8px;'>
                                                            <tbody>
                                                                <tr>
                                                                    <td style='padding: 20px;'>
                                                                        <p class='info-box-title' style='margin: 0 0 8px 0; color: #122142; font-weight: 700; font-size: 16px;'>
                                                                            <span>&#128273; Reset Login Credentials:</span>
                                                                        </p>
                                                                        <div class='info-box-text' style='color: #4d5c82; font-size: 15px; line-height: 1.6; margin: 0;'>
                                                                            <p style='margin: 0 0 12px 0;'>
                                                                                <strong>Email / Username:</strong> {member_email}
                                                                            </p>
                                                                            <p style='margin: 0 0 12px 0;'>
                                                                                <strong>Password:</strong> {member_password}
                                                                            </p>
                                                                        </div>
                                                                    </td>
                                                                </tr>
                                                            </tbody>
                                                        </table>
                                                    </td>
                                                </tr>
                                                <!-- Key Points Section -->
                                                <tr>
                                                    <td style='padding: 0 24px 24px 24px;'>
                                                        <h3 style='margin: 0 0 16px 0; color: #122142; font-size: 18px; font-weight: 700;'>
                                                            Step to Follow for Logging In:
                                                        </h3>
                                                        <div class='content-text' style='color: #4d5c82; font-size: 16px; line-height: 1.8;'>
                                                            <ul>
                                                                <li><strong>Step 1:</strong> Visit the website by <a href='{site_url}' target='_blank'>clicking here</a>.</li>
                                                                <li><strong>Step 2:</strong> On mobile devices, open the menu (three horizontal lines ☰).</li>
                                                                <li><strong>Step 3:</strong> Click on the <strong>Resident Login</strong> option.</li>
                                                                <li><strong>Step 4:</strong> Log in using the credentials provided above.</li>
                                                            </ul>
                                                        </div>
                                                    </td>
                                                </tr>
                                                <tr>
                                                    <td style='padding: 0 24px 24px 24px;'>
                                                        <h3 style='margin: 0 0 16px 0; color: #122142; font-size: 18px; font-weight: 700;'>
                                                            Important Security Instructions:
                                                        </h3>
                                                        <div class='content-text' style='color: #4d5c82; font-size: 16px; line-height: 1.8;'>
                                                            <ul>
                                                                <li>This is a <strong>temporary password</strong> generated after your password reset request.</li>
                                                                <li style='font-weight: bold;'>
                                                                    Please change your password immediately from the <strong>My Account</strong> section after logging in.
                                                                </li>
                                                                <li>If you did not request this password reset, please contact the society office immediately.</li>
                                                            </ul>
                                                        </div>
                                                    </td>
                                                </tr>
                                                <!-- Action Button -->
                                                <tr>
                                                    <td style='padding: 8px 24px 32px 24px;' align='center'>
                                                        <table role='presentation' cellspacing='0' cellpadding='0' border='0'>
                                                            <tbody>
                                                                <tr>
                                                                    <td style='border-radius: 8px; background: linear-gradient(135deg, #0b3c8a, #0a58ca);'>
                                                                        <a href='{site_url}' class='action-button' id='button-text' style='display: inline-block; padding: 16px 32px; color: #ffffff; text-decoration: none; font-weight: 700; font-size: 16px; border-radius: 8px; transition: all 0.2s ease;'> 
                                                                            Visit Website 
                                                                        </a>
                                                                    </td>
                                                                </tr>
                                                            </tbody>
                                                        </table>
                                                    </td>
                                                </tr>
                                                <!-- Additional Info Box -->
                                                <tr>
                                                    <td style='padding: 0 24px 24px 24px;'>
                                                        <table class='info-box' role='presentation' cellspacing='0' cellpadding='0' border='0' width='100%' style='background-color: #e8f0ff; border-left: 4px solid #0b3c8a; border-radius: 8px;'>
                                                            <tbody>
                                                                <tr>
                                                                    <td style='padding: 20px;'>
                                                                        <p class='info-box-title' style='margin: 0 0 8px 0; color: #122142; font-weight: 700; font-size: 16px;'>
                                                                            <span>Need Help?</span>
                                                                        </p>
                                                                        <p class='info-box-text' style='margin: 0; color: #4d5c82; font-size: 15px; line-height: 1.6;'>
                                                                            If you face any issues while logging in or have security concerns, please contact the society office during working hours or write to us at <a href='mailto:{office_email_address}'>{office_email_address}</a>.
                                                                        </p>
                                                                    </td>
                                                                </tr>
                                                            </tbody>
                                                        </table>
                                                    </td>
                                                </tr>
                                                <!-- Closing -->
                                                <tr>
                                                    <td style='padding: 0 24px 32px 24px;'>
                                                        <div class='content-text' style='color: #4d5c82; font-size: 16px; line-height: 1.8;'>
                                                            <p style='margin: 0 0 16px 0;'>We appreciate your cooperation in helping us keep your account secure.</p>
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