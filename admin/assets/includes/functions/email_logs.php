<?php 
    require_once '../config/config.php';
    require_once './data_fetcher.php';
    require_once './utility_functions.php';
    require_once './send_emails.php';

    $get_password_members = "SELECT * FROM members WHERE member_password = '' AND member_email != ''";
    $password_members_result = mysqli_query($con, $get_password_members);
    if (mysqli_num_rows($password_members_result) > 0) {
        $i = 0;
        while ($member = mysqli_fetch_assoc($password_members_result)) {
            $i++;
            $member_email = $member['member_email'];
            $purpose = 'initial_password_send';
            $status = 'pending';
            $by = 'JCGHSOFF00001';

            $insert_email_log = "INSERT INTO email_logs (email_sent_to, email_purpose, email_status, email_logged_by, email_logged_on, email_sent_on, email_updated_on) VALUES (?, ?, ?, ?, NOW(), NOW(), NOW())";
            $stmt = $con->prepare($insert_email_log);
            $stmt->bind_param("ssss", $member_email, $purpose, $status, $by);
            if ($stmt->execute()) {
                echo $i . " Email Log created for email to: " . $member_email . "<br>";
            }
        }
    }
?>