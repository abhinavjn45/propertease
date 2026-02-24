<?php 
    function get_logged_in_member_details() {
        global $con;

        if (isset($_SESSION['office_member_unique_id'])) {
            $logged_in_unique_id = $_SESSION['office_member_unique_id'];

            $stmt = $con->prepare("SELECT * FROM office_members WHERE office_member_unique_id = ? AND office_member_status = 'active' LIMIT 0,1");
            $stmt->bind_param("s", $logged_in_unique_id);
            $stmt->execute();
            $result = $stmt->get_result();
            if ($result->num_rows > 0) {
                return $result->fetch_assoc();
            } else {
                return null;
            }
            $stmt->close();
        }
    }

    function change_status($table, $id_field, $id_valye, $status_field, $new_status, $updated_time_field) {
        global $con;

        // Build update statement and execute safely
        $stmt = $con->prepare("UPDATE $table SET $status_field = ?, $updated_time_field = NOW() WHERE $id_field = ?");
        if (!$stmt) {
            return false;
        }
        $stmt->bind_param("si", $new_status, $id_valye);
        $ok = $stmt->execute();
        $stmt->close();
        return $ok;
    }

    // MEMBERS FUNCTIONS
    function fetch_members($display_type) {
        global $con;

        if (empty($display_type) || $display_type == NULL) {
            echo "
                <tr class='table-empty'>
                    <td class='text-center text-muted'>—</td>
                    <td class='text-muted'>Invalid display type.</td>
                    <td class='text-muted'>&nbsp;</td>
                    <td class='text-muted'>&nbsp;</td>
                    <td class='text-muted'>&nbsp;</td>
                    <td class='text-muted'>&nbsp;</td>
                    <td class='text-muted'>&nbsp;</td>
                    <td class='text-muted'>&nbsp;</td>
                </tr>
            ";
        }

        if ($display_type === 'members-management') {
            $query = "SELECT m.*, om.* FROM members m
                LEFT JOIN office_members om ON m.member_added_by = om.office_member_unique_id
                WHERE m.member_email != 'demo.member@gmail.com' AND m.member_status != 'deleted' ORDER BY m.member_block ASC, m.member_flat_number ASC";

            $stmt = mysqli_prepare($con, $query);
            mysqli_stmt_execute($stmt);
            $result = mysqli_stmt_get_result($stmt);

            if (mysqli_num_rows($result) <= 0) {
                echo "
                    <tr class='table-empty'>
                        <td class='text-center text-muted'>—</td>
                        <td class='text-muted'>No members found.</td>
                        <td class='text-muted'>&nbsp;</td>
                        <td class='text-muted'>&nbsp;</td>
                        <td class='text-muted'>&nbsp;</td>
                        <td class='text-muted'>&nbsp;</td>
                        <td class='text-muted'>&nbsp;</td>
                        <td class='text-muted'>&nbsp;</td>
                    </tr>
                ";
            } else {
                $i = 0;
                while ($member = mysqli_fetch_assoc($result)) {
                    $i++;
                    $member_id = $member['member_id'];
                    $member_unique_id = htmlspecialchars($member['member_unique_id']);
                        $member_unique_id_display = '...' . substr($member_unique_id, -5);

                    $member_block = htmlspecialchars($member['member_block']);
                    $member_flat_number = htmlspecialchars($member['member_flat_number']);
                    $member_salutation = ucwords(strtolower(htmlspecialchars($member['member_salutation'])));
                    $member_fullname = ucwords(strtolower(htmlspecialchars($member['member_fullname'])));
                        $member_fullname_display = $member_salutation . ' ' . $member_fullname;
                            if (strlen($member_fullname_display) > 30) {
                                $member_fullname_display_table = substr($member_fullname_display, 0, 27) . '...';
                            } else {
                                $member_fullname_display_table = $member_fullname_display;
                            }
                    
                    $member_status = htmlspecialchars($member['member_status']);
                        if ($member_status === 'active') {
                            $member_status_badge = "
                                <button class='bg-success-focus text-success-main px-24 py-4 rounded-pill fw-medium text-sm' onclick=\"confirmStatusChange('members', 'member_id', $member_id, 'member_status', 'inactive', 'member_updated_on')\"> " . ucwords(strtolower($member_status)) . "</button>
                            ";
                        } elseif ($member_status === 'inactive') {
                            $member_status_badge = "
                                <button class='bg-warning-focus text-warning-main px-24 py-4 rounded-pill fw-medium text-sm' onclick=\"confirmStatusChange('members', 'member_id', $member_id, 'member_status', 'active', 'member_updated_on')\"> " . ucwords(strtolower($member_status)) . "</button>
                            ";
                        }
                    
                    $member_added_by_id = htmlspecialchars($member['member_added_by']);
                    $member_added_by_salutation = ucwords(strtolower($member['office_member_salutation']));
                    $member_added_by_fullname = ucwords(strtolower($member['office_member_fullname']));
                    $member_added_by_name = $member_added_by_salutation . ' ' . $member_added_by_fullname;

                    $member_added_on = date('d M, Y h:i A', strtotime($member['member_added_on']));
                    $member_email = strtolower(htmlspecialchars($member['member_email']));
                    $member_phone_number = htmlspecialchars($member['member_phone_number']);
                    $member_type = ucwords(strtolower(htmlspecialchars($member['member_type'])));

                    $member_updated_on = $member['member_updated_on'];
                        if (!empty($member_updated_on) || $member_updated_on !== NULL) {
                            $member_updated_on = date('d M, Y h:i A', strtotime($member['member_updated_on']));
                        } else {
                            $member_updated_on = 'N/A';
                        }
                    
                    $member_image = htmlspecialchars($member['member_image']);
                        if (empty($member_image) || $member_image === NULL) {
                            $member_image_url = get_site_option('dashboard_url') . "assets/uploads/images/members/default-member.png";
                        } else {
                            $member_image_url = get_site_option('dashboard_url') . "assets/uploads/images/members/" . $member_image;
                        }

                    echo "
                        <tr>
                            <td class='text-center'>
                                $i
                            </td>
                            <td>
                                <a href='javascript:void(0)' class='text-primary-600' data-bs-toggle='modal' data-bs-target='#viewMemberModal$member_id'>
                                    $member_unique_id_display
                                </a>
                            </td>
                            <td>$member_block-$member_flat_number</td>
                            <td>
                                <div class='d-flex align-items-center'>
                                    <img src='$member_image_url' alt='$member_fullname_display_table Image' class='flex-shrink-0 me-12 radius-8' width='40px' height='40px'>
                                    <h6 class='text-md mb-0 fw-medium flex-grow-1'>$member_fullname_display_table</h6>
                                </div>
                            </td>
                            <td>
                                <a href='mailto:$member_email'>$member_email</a>
                            </td>
                            <td>
                                <a href='tel:$member_phone_number'>$member_phone_number</a>
                            </td>
                            <td>$member_status_badge</td>
                            <td>
                                <a href='javascript:void(0)' class='w-32-px h-32-px bg-primary-light text-primary-600 rounded-circle d-inline-flex align-items-center justify-content-center' data-bs-toggle='modal' data-bs-target='#viewMemberModal$member_id'>
                                    <iconify-icon icon='iconamoon:eye-light'></iconify-icon>
                                </a>

                                <!--- View Member Modal -->
                                <div class='modal fade' id='viewMemberModal$member_id' tabindex='-1' aria-labelledby='viewMemberModalLabel$member_id' aria-hidden='true'>
                                    <div class='modal-dialog modal-lg modal-dialog-centered'>
                                        <div class='modal-content'>
                                            <div class='modal-header'>
                                                <h5 class='modal-title' id='viewMemberModalLabel$member_id'>Member Details</h5>
                                                <button type='button' class='btn-close' data-bs-dismiss='modal' aria-label='Close'></button>
                                            </div>
                                            <div class='modal-body'>
                                                <div class='row'>
                                                    <div class='col-md-2'>
                                                        <div class='mb-3'>
                                                            <label for='memberID' class='form-label'>ID:</label>
                                                            <input type='text' readonly value='$member_id' class='form-control' />
                                                        </div>
                                                    </div>
                                                    <div class='col-md-6'>
                                                        <div class='mb-3'>
                                                            <label for='memberAddedBy' class='form-label'>Added By:</label>
                                                            <input type='text' readonly value='$member_added_by_name ($member_added_by_id)' class='form-control' />
                                                        </div>
                                                    </div>
                                                    <div class='col-md-4'>
                                                        <div class='mb-3'>
                                                            <label for='memberAddedOn' class='form-label'>Added On:</label>
                                                            <input type='text' readonly value='$member_added_on' class='form-control' />
                                                        </div>
                                                    </div>
                                                    <div class='col-md-8'>
                                                        <div class='mb-3'>
                                                            <label for='memberFullname' class='form-label'>Fullname:</label>
                                                            <input type='text' readonly value='$member_fullname_display' class='form-control' />
                                                        </div>
                                                    </div>
                                                    <div class='col-md-4'>
                                                        <div class='mb-3'>
                                                            <label for='memberUniqueId' class='form-label'>Unique ID:</label>
                                                            <input type='text' readonly value='$member_unique_id' class='form-control' />
                                                        </div>
                                                    </div>
                                                    <div class='col-md-2'>
                                                        <div class='mb-3'>
                                                            <label for='memberFlat' class='form-label'>Flat:</label>
                                                            <input type='text' readonly value='$member_block-$member_flat_number' class='form-control' />
                                                        </div>
                                                    </div>
                                                    <div class='col-md-6'>
                                                        <div class='mb-3'>
                                                            <label for='memberEmail' class='form-label'>Email:</label>
                                                            <input type='text' readonly value='$member_email' class='form-control' />
                                                        </div>
                                                    </div>
                                                    <div class='col-md-4'>
                                                        <div class='mb-3'>
                                                            <label for='memberPhoneNumber' class='form-label'>Phone Number:</label>
                                                            <input type='text' readonly value='$member_phone_number' class='form-control' />
                                                        </div>
                                                    </div>
                                                    <div class='col-md-3'>
                                                        <div class='mb-3'>
                                                            <label for='memberType' class='form-label'>Member Type:</label>
                                                            <input type='text' readonly value='$member_type' class='form-control' />
                                                        </div>
                                                    </div>
                                                    <div class='col-md-3'>
                                                        <div class='mb-3'>
                                                            <label for='memberStatus' class='form-label'>Status:</label>
                                                            <input type='text' readonly value='" . ucwords($member_status) . "' class='form-control' />
                                                        </div>
                                                    </div>
                                                    <div class='col-md-3'>
                                                        <div class='mb-3'>
                                                            <label for='memberUpdatedOn' class='form-label'>Updated On:</label>
                                                            <input type='text' readonly value='$member_updated_on' class='form-control' />
                                                        </div>
                                                    </div>
                                                    <div class='col-md-3'>
                                                        <div class='mb-3'>
                                                            <label for='memberImage' class='form-label'>Image:</label>
                                                            <br>
                                                            <img width='100%' src='$member_image_url' alt='$member_fullname_display Member Image' class='img-fluid rounded'>
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>
                                            <div class='modal-footer d-flex justify-content-between'>
                                                <div>";
                                                    if ($member_status === 'active') {
                                                        echo "
                                                            <button type='button' class='btn btn-warning' onclick=\"confirmStatusChange('members', 'member_id', $member_id, 'member_status', 'inactive', 'member_updated_on')\">
                                                                <i class='ri-draft-line'></i> Mark as Draft
                                                            </button>
                                                        ";
                                                    } elseif ($member_status === 'inactive') {
                                                        echo "
                                                            <button type='button' class='btn btn-success' onclick=\"confirmStatusChange('members', 'member_id', $member_id, 'member_status', 'active', 'member_updated_on')\">
                                                                <i class='ri-checkbox-circle-line'></i> Mark as Published
                                                            </button>
                                                        ";
                                                    }
                                                    echo "
                                                    <button type='button' class='btn btn-danger' onclick=\"confirmStatusChange('members', 'member_id', $member_id, 'member_status', 'deleted', 'member_updated_on')\">
                                                        <i class='ri-delete-bin-line'></i> Delete
                                                    </button>
                                                </div>
                                                <div>
                                                    <button type='button' class='btn btn-outline-primary' onclick='resendPassword(\"$member_email\")'>
                                                        Resend Password Email
                                                    </button>
                                                    <button type='button' class='btn btn-outline-secondary' data-bs-dismiss='modal'>Close</button>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                                

                                <a href='" . get_site_option('dashboard_url') . "?page=edit-member&member_id=$member_id' class='w-32-px h-32-px bg-success-focus text-success-main rounded-circle d-inline-flex align-items-center justify-content-center'>
                                    <iconify-icon icon='lucide:edit'></iconify-icon>
                                </a>

                                <a href='javascript:void(0);' class='w-32-px h-32-px bg-danger-focus text-danger-main rounded-circle d-inline-flex align-items-center justify-content-center' onclick=\"confirmStatusChange('members', 'member_id', $member_id, 'member_status', 'deleted', 'member_updated_on')\">
                                    <iconify-icon icon='mingcute:delete-2-line'></iconify-icon>
                                </a>
                            </td>
                        </tr>
                    ";
                }
            }
        }
    }

    function add_new_member($member_salutation, $member_fullname, $member_block, $member_flat_number, $member_email, 
                           $member_phone_number, $member_type, $member_unique_id, $member_image = NULL, 
                           $added_by, $added_on) {
        global $con;

        $stmt = $con->prepare("
            INSERT INTO members (
                member_unique_id, 
                member_salutation, 
                member_fullname, 
                member_block, 
                member_flat_number, 
                member_email, 
                member_phone_number, 
                member_type, 
                member_image, 
                member_added_by, 
                member_added_on, 
                member_status
            ) VALUES (?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, 'active')
        ");

        if (!$stmt) {
            return false;
        }

        $stmt->bind_param(
            "sssssssssss",
            $member_unique_id,
            $member_salutation,
            $member_fullname,
            $member_block,
            $member_flat_number,
            $member_email,
            $member_phone_number,
            $member_type,
            $member_image,
            $added_by,
            $added_on
        );

        $result = $stmt->execute();
        $stmt->close();

        return $result;
    }

    function get_member_details($member_id = null, $member_unique_id = null, $member_email = null) {
        global $con;

        if ($member_id === null && $member_unique_id === null && $member_email === null) {
            return null;
        } elseif ($member_id !== null && $member_unique_id === null && $member_email === null) {
            $stmt = $con->prepare("SELECT m.*, om.* FROM members m
                LEFT JOIN office_members om ON m.member_added_by = om.office_member_unique_id
                WHERE member_id = ? AND member_status != 'deleted' LIMIT 0,1");
            if (!$stmt) {
                return null;
            }
            $stmt->bind_param("i", $member_id);
        } elseif ($member_id === null && $member_unique_id !== null && $member_email === null) {
            $stmt = $con->prepare("SELECT m.*, om.* FROM members m
                LEFT JOIN office_members om ON m.member_added_by = om.office_member_unique_id
                WHERE member_unique_id = ? AND member_status != 'deleted' LIMIT 0,1");
            if (!$stmt) {
                return null;
            }
            $stmt->bind_param("s", $member_unique_id);
        } elseif ($member_id === null && $member_unique_id === null && $member_email !== null) {
            $stmt = $con->prepare("SELECT m.*, om.* FROM members m
                LEFT JOIN office_members om ON m.member_added_by = om.office_member_unique_id
                WHERE member_email = ? AND member_status != 'deleted' LIMIT 0,1");
            if (!$stmt) {
                return null;
            }
            $stmt->bind_param("s", $member_email);
        } elseif ($member_id !== null && $member_unique_id !== null && $member_email !== null) {
            $stmt = $con->prepare("SELECT m.*, om.* FROM members m
                LEFT JOIN office_members om ON m.member_added_by = om.office_member_unique_id
                WHERE member_id = ? OR member_unique_id = ? OR member_email = ? AND member_status != 'deleted' LIMIT 0,1");
        }

        $stmt->execute();
        $result = $stmt->get_result();
        if ($result->num_rows > 0) {
            $member = $result->fetch_assoc();
            $stmt->close();
            return $member;
        } else {
            $stmt->close();
            return null;
        }
    }

    function edit_member() {
        // Edit member logic
    }

    // ANNOUNCEMENTS FUNCTIONS
    function add_new_announcement($content, $expiry_date) {
        global $con;

        $stmt = $con->prepare("INSERT INTO announcements (announcement_content, announcement_expiry_on, announcement_added_by) VALUES (?, ?, ?)");
        if (!$stmt) {
            return false;
        }
        $stmt->bind_param("sss", $content, $expiry_date, $_SESSION['office_member_unique_id']);
        $ok = $stmt->execute();
        $stmt->close();
        return $ok;
    }

    function get_announcement_details($announcement_id) {
        global $con;

        $stmt = $con->prepare("SELECT * FROM announcements WHERE announcement_id = ? AND announcement_status != 'deleted' LIMIT 0,1");
        if (!$stmt) {
            return null;
        }
        $stmt->bind_param("i", $announcement_id);
        $stmt->execute();
        $result = $stmt->get_result();
        if ($result->num_rows > 0) {
            $announcement = $result->fetch_assoc();
            $stmt->close();
            return $announcement;
        } else {
            $stmt->close();
            return null;
        }
    }

    function edit_announcement($announcement_id, $content, $expiry_date) {
        global $con;

        $stmt = $con->prepare("UPDATE announcements SET announcement_content = ?, announcement_expiry_on = ?, announcement_updated_on = NOW() WHERE announcement_id = ?");
        if (!$stmt) {
            return false;
        }
        $stmt->bind_param("ssi", $content, $expiry_date, $announcement_id);
        $ok = $stmt->execute();
        $stmt->close();
        return $ok;
    }

    function load_email_logs($display_type, $email_status = null, $order_by = null, $order_dir = null) {
        global $con;

        if ($display_type === 'emails_management') {
            // Set defaults for ordering if not provided
            $order_by = !empty($order_by) ? $order_by : 'email_log_id';
            $order_dir = !empty($order_dir) ? $order_dir : 'DESC';

            $stmt = $con->prepare("SELECT * FROM email_logs WHERE email_status != 'deleted' ORDER BY $order_by $order_dir");
            mysqli_stmt_execute($stmt);
            $result = $stmt->get_result();
            if (mysqli_num_rows($result) <= 0) {
                echo "
                    <tr class='table-empty'>
                        <td class='text-center text-muted'>—</td>
                        <td class='text-muted'>No email logs found.</td>
                        <td class='text-muted'>&nbsp;</td>
                        <td class='text-muted'>&nbsp;</td>
                        <td class='text-muted'>&nbsp;</td>
                        <td class='text-muted'>&nbsp;</td>
                    </tr>
                ";
            } else {
                $i = 0;
                while ($email = mysqli_fetch_assoc($result)) {
                    $i++;
                    $email_id = $email['email_log_id'];
                    $email_sent_to = htmlspecialchars($email['email_sent_to']);
                    $email_purpose = htmlspecialchars($email['email_purpose']);
                        $email_purpose_display = ucwords(str_replace('_', ' ', $email_purpose));
                    
                    $email_status = htmlspecialchars($email['email_status']);
                        if ($email_status === 'sent') {
                            $email_status_badge = "
                                <button class='bg-success-focus text-success-main px-24 py-4 rounded-pill fw-medium text-sm'> " . ucwords(strtolower($email_status)) . "</button>
                            ";
                        } elseif ($email_status === 'failed') {
                            $email_status_badge = "
                                <span class='bg-danger-light text-danger-main px-24 py-4 rounded-pill fw-medium text-sm'>Failed</span>
                                <button class='btn btn-sm btn-outline-danger ms-2' title='Resend Email' onclick=\"sendEmail($email_id)\">
                                    <iconify-icon icon='mage:refresh'></iconify-icon>
                                </button>
                            ";
                        } elseif ($email_status === 'pending') {
                            $email_status_badge = "
                                <span class='badge bg-warning-light text-warning-main px-24 py-4 rounded-pill fw-medium text-sm'>Pending
                                    <button class='btn btn-sm btn-outline-warning ms-2' title='Send Now' onclick=\"sendEmail($email_id)\">
                                        <iconify-icon icon='iconamoon:send-light'></iconify-icon>
                                    </button>
                                </span>
                            ";
                        }

                    echo "
                        <tr>
                            <td class='text-center'>
                                $i
                            </td>
                            <td>$email_sent_to</td>
                            <td>$email_purpose_display</td>
                            <td>
                                <button class='btn btn-sm btn-outline-primary' title='View Email Content' data-bs-toggle='modal' data-bs-target='#emailViewModal$email_id'>
                                    <iconify-icon icon='mdi:email-search-outline'></iconify-icon>
                                </button>

                                <!-- Email Content Modal -->
                                <div class='modal fade' id='emailViewModal$email_id' tabindex='-1' aria-labelledby='emailViewModalLabel$email_id' aria-hidden='true'>
                                    <div class='modal-dialog modal-dialog-scrollable modal-lg modal-dialog-centered'>
                                        <div class='modal-content'>
                                            <div class='modal-header'>
                                                <h5 class='modal-title' id='emailViewModalLabel$email_id'>Email Preview</h5>
                                                <button type='button' class='btn-close' data-bs-dismiss='modal' aria-label='Close'></button>
                                            </div>
                                            <div class='modal-body' style='padding: 0; background: #f5f5f5;'>
                                                <div style='padding: 20px; background: #fff; margin: 20px; border-radius: 8px; box-shadow: 0 2px 8px rgba(0,0,0,0.1);'>
                                                    <iframe id='emailFrame$email_id' src='" . get_site_option('dashboard_url') . "assets/email-templates/$email_purpose.php' style='width: 100%; min-height: 400px; border: none; background: #fff;'>
                                                    </iframe>
                                                </div>
                                            </div>
                                            <div class='modal-footer'>
                                                <button type='button' class='btn btn-outline-secondary' data-bs-dismiss='modal'>Close</button>
                                            </div>
                                        </div>
                                    </div>
                                </div>

                            </td>
                            <td>$email_status_badge</td>
                            <td>
                                <a href='javascript:void(0)' class='w-32-px h-32-px bg-primary-light text-primary-600 rounded-circle d-inline-flex align-items-center justify-content-center' data-bs-toggle='modal' data-bs-target='#viewEmailModal$email_id'>
                                    <iconify-icon icon='iconamoon:eye-light'></iconify-icon>
                                </a>

                                <!--- View Email Modal -->
                                <div class='modal fade' id='viewEmailModal$email_id' tabindex='-1' aria-labelledby='viewEmailModalLabel$email_id' aria-hidden='true'>
                                    <div class='modal-dialog modal-lg modal-dialog-centered'>
                                        <div class='modal-content'>
                                            <div class='modal-header'>
                                                <h5 class='modal-title' id='viewEmailModalLabel$email_id'>Email Details</h5>
                                                <button type='button' class='btn-close' data-bs-dismiss='modal' aria-label='Close'></button>
                                            </div>
                                            <div class='modal-body'>
                                                <div class='row'>
                                                    <div class='col-md-2'>
                                                        <div class='mb-3'>
                                                            <label for='emailID' class='form-label'>ID:</label>
                                                            <input type='text' readonly value='$email_id' class='form-control' />
                                                        </div>
                                                    </div>
                                                    <div class='col-md-6'>
                                                        
                                                    </div>
                                                    <div class='col-md-4'>
                                                        <div class='mb-3'>
                                                            
                                                        </div>
                                                    </div>
                                                    <div class='col-md-12'>
                                                        <div class='mb-3'>
                                                            
                                                        </div>
                                                    </div>
                                                    <div class='col-md-3'>
                                                        <div class='mb-3'>
                                                            
                                                        </div>
                                                    </div>
                                                    <div class='col-md-5'>
                                                        <div class='mb-3'>
                                                            
                                                        </div>
                                                    </div>
                                                    <div class='col-md-4'>
                                                        <div class='mb-3'>
                                                            
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>
                                            <div class='modal-footer d-flex justify-content-between'>
                                                <div>";
                                                    if ($email_status === 'pending') {
                                                        echo "
                                                            <button type='button' class='btn btn-primary' onclick=\"sendEmail($email_id)\">
                                                                <iconify-icon icon='iconamoon:send-light'></iconify-icon> Send Now
                                                            </button>
                                                        ";
                                                    } elseif ($email_status === 'failed') {
                                                        echo "
                                                            <button type='button' class='btn btn-warning-light' onclick=\"sendEmail($email_id)\">
                                                                <iconify-icon icon='mage:refresh'></iconify-icon> Resend
                                                            </button>
                                                        ";
                                                    }
                                                    echo "
                                                    <button type='button' class='btn btn-danger' onclick=\"confirmStatusChange('email_logs', 'email_id', $email_id, 'email_status', 'deleted', 'email_updated_on')\">
                                                        <iconify-icon icon='mingcute:delete-2-line'></iconify-icon> Delete
                                                    </button>
                                                </div>
                                                <button type='button' class='btn btn-outline-secondary' data-bs-dismiss='modal'>Close</button>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                                
                                <a href='" . get_site_option('dashboard_url') . "?page=edit-email&email_id=$email_id' class='w-32-px h-32-px bg-success-focus text-success-main rounded-circle d-inline-flex align-items-center justify-content-center'>
                                    <iconify-icon icon='lucide:edit'></iconify-icon>
                                </a>

                                <a href='javascript:void(0);' class='w-32-px h-32-px bg-danger-focus text-danger-main rounded-circle d-inline-flex align-items-center justify-content-center' onclick=\"confirmStatusChange('email_logs', 'email_id', $email_id, 'email_status', 'deleted', 'email_updated_on')\">
                                    <iconify-icon icon='mingcute:delete-2-line'></iconify-icon>
                                </a>
                            </td>
                        </tr>
                    ";
                }
            }

        } else {
            return;
        }
    }

    function get_notice_categories_select_box($display_type, $current_parent_id = null) {
        global $con;

        if ($display_type === 'add-notice') {
            // Fetch parents first (alphabetical)
            $parentsStmt = $con->prepare("SELECT notice_category_id, notice_category_name FROM notice_categories WHERE (notice_parent_category_id IS NULL OR notice_parent_category_id = 0) AND notice_category_status = 'active' ORDER BY notice_category_name ASC");
            if (!$parentsStmt) {
                echo "<option disabled selected>Error Loading Categories</option>";
                return;
            }
            $parentsStmt->execute();
            $parentsResult = $parentsStmt->get_result();

            if ($parentsResult->num_rows <= 0) {
                echo "<option disabled selected>No Categories Found</option>";
                $parentsStmt->close();
                return;
            }

            // Prepare child statement once
            $childrenStmt = $con->prepare("SELECT notice_category_id, notice_category_name FROM notice_categories WHERE notice_parent_category_id = ? AND notice_category_status = 'active' ORDER BY notice_category_name ASC");
            if (!$childrenStmt) {
                echo "<option disabled selected>Error loading categories</option>";
                $parentsStmt->close();
                return;
            }

            echo "<option disabled selected>None</option>";

            while ($parent = $parentsResult->fetch_assoc()) {
                $parent_id = (int) $parent['notice_category_id'];
                $parent_name = ucwords(strtolower(htmlspecialchars($parent['notice_category_name'])));

                // Show parent as a non-selectable separator
                echo "<option disabled>-- $parent_name --</option>";

                $childrenStmt->bind_param('i', $parent_id);
                $childrenStmt->execute();
                $childrenResult = $childrenStmt->get_result();

                if ($childrenResult->num_rows > 0) {
                    while ($child = $childrenResult->fetch_assoc()) {
                        $child_id = (int) $child['notice_category_id'];
                        $child_name = htmlspecialchars($child['notice_category_name']);
                        echo "<option value='$child_id'>$child_name</option>";
                    }
                } else {
                    // Optional: indicate no children
                    echo "<option disabled class='text-muted'>&nbsp;&nbsp;No sub-categories</option>";
                }
            }

            $childrenStmt->close();
            $parentsStmt->close();
        }

        if ($display_type === 'add-new-category') {
            // Build a hierarchy similar to the table view (Parent, then children with '-' prefix)
            $allStmt = $con->prepare("SELECT notice_category_id, notice_category_name, COALESCE(notice_parent_category_id, 0) AS parent_id FROM notice_categories WHERE notice_category_status = 'active' ORDER BY notice_category_name ASC");
            if (!$allStmt) {
                echo "<option disabled selected>Error Loading Categories</option>";
                return;
            }

            $allStmt->execute();
            $allResult = $allStmt->get_result();
            if ($allResult->num_rows <= 0) {
                echo "<option disabled selected>No Categories Found</option>";
                $allStmt->close();
                return;
            }

            // Group by parent for quick lookup
            $byParent = [];
            while ($row = $allResult->fetch_assoc()) {
                $pid = (int)$row['parent_id'];
                $byParent[$pid][] = $row;
            }
            $allStmt->close();

            echo "<option value='NULL' selected>None</option>";

            // Recursive renderer to mirror table indentation style
            $renderOptions = function($parentId, $level) use (&$renderOptions, $byParent) {
                if (!isset($byParent[$parentId])) {
                    return;
                }
                foreach ($byParent[$parentId] as $cat) {
                    $id = (int)$cat['notice_category_id'];
                    $name = htmlspecialchars($cat['notice_category_name']);
                    $prefix = $level > 0 ? str_repeat('-', $level) . ' ' : '';
                    echo "<option value='$id'>{$prefix}$name</option>";
                    $renderOptions($id, $level + 1);
                }
            };

            // Start from root categories (parent_id = 0 / NULL collapsed to 0)
            $renderOptions(0, 0);
        }

        if ($display_type === 'edit-category') {
            // Build a hierarchy similar to the table view (Parent, then children with '-' prefix)
            $allStmt = $con->prepare("SELECT notice_category_id, notice_category_name, COALESCE(notice_parent_category_id, 0) AS parent_id FROM notice_categories WHERE notice_category_status = 'active' ORDER BY notice_category_name ASC");
            if (!$allStmt) {
                echo "<option disabled selected>Error Loading Categories</option>";
                return;
            }

            $allStmt->execute();
            $allResult = $allStmt->get_result();
            if ($allResult->num_rows <= 0) {
                echo "<option disabled selected>No Categories Found</option>";
                $allStmt->close();
                return;
            }

            // Group by parent for quick lookup
            $byParent = [];
            while ($row = $allResult->fetch_assoc()) {
                $pid = (int)$row['parent_id'];
                $byParent[$pid][] = $row;
            }
            $allStmt->close();

            // Determine if NULL should be selected
            $nullSelected = (is_null($current_parent_id) || $current_parent_id === 0 || $current_parent_id === '0') ? 'selected' : '';
            echo "<option value='NULL' $nullSelected>None</option>";

            // Recursive renderer to mirror table indentation style
            $renderOptions = function($parentId, $level) use (&$renderOptions, $byParent, $current_parent_id) {
                if (!isset($byParent[$parentId])) {
                    return;
                }
                foreach ($byParent[$parentId] as $cat) {
                    $id = (int)$cat['notice_category_id'];
                    $name = htmlspecialchars($cat['notice_category_name']);
                    $prefix = $level > 0 ? str_repeat('-', $level) . ' ' : '';
                    $selected = ($current_parent_id == $id) ? 'selected' : '';
                    echo "<option value='$id' $selected>{$prefix}$name</option>";
                    $renderOptions($id, $level + 1);
                }
            };

            // Start from root categories (parent_id = 0 / NULL collapsed to 0)
            $renderOptions(0, 0);
        }

        if ($display_type === 'edit-notice') {
            // Fetch parents first (alphabetical)
            $parentsStmt = $con->prepare("SELECT notice_category_id, notice_category_name FROM notice_categories WHERE (notice_parent_category_id IS NULL OR notice_parent_category_id = 0) AND notice_category_status = 'active' ORDER BY notice_category_name ASC");
            if (!$parentsStmt) {
                echo "<option disabled selected>Error Loading Categories</option>";
                return;
            }
            $parentsStmt->execute();
            $parentsResult = $parentsStmt->get_result();

            if ($parentsResult->num_rows <= 0) {
                echo "<option disabled selected>No Categories Found</option>";
                $parentsStmt->close();
                return;
            }

            // Prepare child statement once
            $childrenStmt = $con->prepare("SELECT notice_category_id, notice_category_name FROM notice_categories WHERE notice_parent_category_id = ? AND notice_category_status = 'active' ORDER BY notice_category_name ASC");
            if (!$childrenStmt) {
                echo "<option disabled selected>Error loading categories</option>";
                $parentsStmt->close();
                return;
            }

            // Only select "None" if no category is currently assigned
            $noneSelected = (is_null($current_parent_id) || empty($current_parent_id)) ? 'selected' : '';
            echo "<option disabled $noneSelected>None</option>";

            while ($parent = $parentsResult->fetch_assoc()) {
                $parent_id = (int) $parent['notice_category_id'];
                $parent_name = ucwords(strtolower(htmlspecialchars($parent['notice_category_name'])));

                // Show parent as disabled (top-level categories remain disabled)
                echo "<option disabled>-- $parent_name --</option>";

                $childrenStmt->bind_param('i', $parent_id);
                $childrenStmt->execute();
                $childrenResult = $childrenStmt->get_result();

                if ($childrenResult->num_rows > 0) {
                    while ($child = $childrenResult->fetch_assoc()) {
                        $child_id = (int) $child['notice_category_id'];
                        $child_name = htmlspecialchars($child['notice_category_name']);
                        // Check if this child is the currently selected category
                        $selected = ($current_parent_id == $child_id) ? 'selected' : '';
                        echo "<option value='$child_id' $selected>$child_name</option>";
                    }
                } else {
                    // Optional: indicate no children
                    echo "<option disabled class='text-muted'>&nbsp;&nbsp;No sub-categories</option>";
                }
            }

            $childrenStmt->close();
            $parentsStmt->close();
        }
    }

    function add_new_notice($number, $title, $single_line, $category, $badge, $excerpt, $content, $material_title = null, $material_filename = null, $posted_by, $posted_on) {
        global $con;

        $stmt = $con->prepare("INSERT INTO notices (notice_number, notice_title, notice_single_line, notice_category, notice_badge, notice_excerpt, notice_content, notice_material_title, notice_material, notice_posted_by, notice_posted_on) VALUES (?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?)");
        if (!$stmt) {
            throw new Exception('Database error: ' . $con->error);
        }
        $stmt->bind_param("sssssssssss", $number, $title, $single_line, $category, $badge, $excerpt, $content, $material_title, $material_filename, $posted_by, $posted_on);
        $ok = $stmt->execute();
        if (!$ok) {
            throw new Exception('Database error: ' . $stmt->error);
        }
        $stmt->close();
        return $ok;

    }

    function add_new_notice_category($category_name, $parent_category_id, $category_slug, $added_by, $added_on) {
        global $con;

        $stmt = $con->prepare("INSERT INTO notice_categories (notice_category_name, notice_parent_category_id, notice_category_slug, notice_category_added_by, notice_category_added_on) VALUES (?, ?, ?, ?, ?)");
        if (!$stmt) {
            throw new Exception('Database error: ' . $con->error);
        }
        $stmt->bind_param("sisss", $category_name, $parent_category_id, $category_slug, $added_by, $added_on);
        $ok = $stmt->execute();
        if (!$ok) {
            throw new Exception('Database error: ' . $stmt->error);
        }
        $stmt->close();
        return $ok;
    }

    // Function to get All the members into an Select Box
    function get_all_members_select_box() {
        global $con;

        $stmt = $con->prepare("SELECT member_id, member_unique_id, member_salutation, member_fullname, member_block, member_flat_number FROM members WHERE member_status = 'active' ORDER BY member_fullname ASC");
        $stmt->execute();
        $result = $stmt->get_result();

        if (mysqli_num_rows($result) <= 0) {
            echo "<option disabled>No members found</option>";
        } else {
            while ($member = mysqli_fetch_assoc($result)) {
                $member_id = htmlspecialchars($member['member_id']);
                $member_unique_id = htmlspecialchars($member['member_unique_id']);
                $member_salutation = htmlspecialchars($member['member_salutation']);
                $member_fullname = htmlspecialchars($member['member_fullname']);
                $member_block = htmlspecialchars($member['member_block']);
                $member_flat_number = htmlspecialchars($member['member_flat_number']);
                $member_flat_display = !empty($member_block) ? "$member_block-$member_flat_number" : $member_flat_number;

                echo "<option value='$member_unique_id'>($member_flat_display) $member_salutation $member_fullname</option>";
            }
        }
    }

    function get_member_by_unique_id($member_unique_id) {
        global $con;

        $stmt = $con->prepare("SELECT * FROM members WHERE member_unique_id = ? AND member_status = 'active' LIMIT 0,1");
        if (!$stmt) {
            return null;
        }
        $stmt->bind_param("s", $member_unique_id);
        $stmt->execute();
        $result = $stmt->get_result();
        if ($result->num_rows > 0) {
            $member = $result->fetch_assoc();
            $stmt->close();
            return $member;
        } else {
            $stmt->close();
            return null;
        }
    }

    function add_new_bill($member_unique_id, $bill_for_month, $bill_due_date, $bill_file_path) {
        global $con;

        $stmt = $con->prepare("INSERT INTO bills (bill_for_member, bill_file, bill_for_month, bill_due_on, bill_added_by) VALUES (?, ?, ?, ?, ?)");
        if (!$stmt) {
            return false;
        }
        $stmt->bind_param("sssss", $member_unique_id, $bill_file_path, $bill_for_month, $bill_due_date, $_SESSION['office_member_unique_id']);
        $ok = $stmt->execute();
        $stmt->close();
        return $ok;
    }

    function get_bill_details($bill_id) {
        global $con;

        $stmt = $con->prepare("SELECT b.*, m.*, om.* FROM bills b
            JOIN members m ON b.bill_for_member = m.member_unique_id
            JOIN office_members om ON b.bill_added_by = om.office_member_unique_id
            WHERE bill_id = ? AND bill_status != 'deleted' LIMIT 0,1");

        if (!$stmt) {
            return null;
        }
        $stmt->bind_param("i", $bill_id);
        $stmt->execute();
        $result = $stmt->get_result();
        if ($result->num_rows > 0) {
            $bill = $result->fetch_assoc();
            $stmt->close();
            return $bill;
        } else {
            $stmt->close();
            return null;
        }
    }

    function edit_bill($bill_id, $bill_for_month, $bill_due_date, $new_file_name = null) {
        global $con;

        if ($new_file_name) {
            $stmt = $con->prepare("UPDATE bills SET bill_for_month = ?, bill_due_on = ?, bill_file = ?, bill_updated_on = NOW() WHERE bill_id = ? AND bill_status != 'deleted' LIMIT 1");
            if (!$stmt) {
                return false;
            }
            $stmt->bind_param("sssi", $bill_for_month, $bill_due_date, $new_file_name, $bill_id);
        } else {
            $stmt = $con->prepare("UPDATE bills SET bill_for_month = ?, bill_due_on = ?, bill_updated_on = NOW() WHERE bill_id = ? AND bill_status != 'deleted' LIMIT 1");
            if (!$stmt) {
                return false;
            }
            $stmt->bind_param("ssi", $bill_for_month, $bill_due_date, $bill_id);
        }

        $ok = $stmt->execute();
        $stmt->close();
        return $ok;
    }

    function add_new_agbm($agbm_number, $agbm_title, $agbm_single_line, $agbm_excerpt, $agbm_content, $agbm_video_link, $agbm_material_title = null, $agbm_material_filename = null, $added_by, $added_on) {
        global $con;

        $stmt = $con->prepare("INSERT INTO agbms (agbm_number, agbm_title, agbm_single_line, agbm_excerpt, agbm_content, agbm_video_link, agbm_material_title, agbm_material, agbm_posted_by, agbm_posted_on) VALUES (?, ?, ?, ?, ?, ?, ?, ?, ?, ?)");
        if (!$stmt) {
            throw new Exception('Database error: ' . $con->error);
        }
        $stmt->bind_param("ssssssssss", $agbm_number, $agbm_title, $agbm_single_line, $agbm_excerpt, $agbm_content, $agbm_video_link, $agbm_material_title, $agbm_material_filename, $added_by, $added_on);
        $ok = $stmt->execute();
        if (!$ok) {
            throw new Exception('Database error: ' . $stmt->error);
        }
        $stmt->close();
        return $ok;
    }

    function get_agbm_details($agbm_id) {
        global $con;

        $stmt = $con->prepare("SELECT * FROM agbms WHERE agbm_id = ? AND agbm_status != 'deleted' LIMIT 0,1");
        if (!$stmt) {
            return null;
        }
        $stmt->bind_param("i", $agbm_id);
        $stmt->execute();
        $result = $stmt->get_result();
        if ($result->num_rows > 0) {
            $agbm = $result->fetch_assoc();
            $stmt->close();
            return $agbm;
        } else {
            $stmt->close();
            return null;
        }
    }

    function edit_agbm($agbm_id, $agbm_number, $agbm_title, $agbm_single_line, $agbm_excerpt, $agbm_content, $agbm_video_link, $agbm_material_title, $new_material_name = null) {
        global $con;

        if ($new_material_name) {
            $stmt = $con->prepare("UPDATE agbms SET agbm_number = ?, agbm_title = ?, agbm_single_line = ?, agbm_excerpt = ?, agbm_content = ?, agbm_video_link = ?, agbm_material_title = ?, agbm_material = ?, agbm_updated_on = NOW() WHERE agbm_id = ? AND agbm_status != 'deleted' LIMIT 1");
            if (!$stmt) {
                return false;
            }
            $stmt->bind_param("ssssssssi", $agbm_number, $agbm_title, $agbm_single_line, $agbm_excerpt, $agbm_content, $agbm_video_link, $agbm_material_title, $new_material_name, $agbm_id);
        } else {
            $stmt = $con->prepare("UPDATE agbms SET agbm_number = ?, agbm_title = ?, agbm_single_line = ?, agbm_excerpt = ?, agbm_content = ?, agbm_video_link = ?, agbm_material_title = ?, agbm_updated_on = NOW() WHERE agbm_id = ? AND agbm_status != 'deleted' LIMIT 1");
            if (!$stmt) {
                return false;
            }
            $stmt->bind_param("sssssssi", $agbm_number, $agbm_title, $agbm_single_line, $agbm_excerpt, $agbm_content, $agbm_video_link, $agbm_material_title, $agbm_id);
        }

        $ok = $stmt->execute();
        $stmt->close();
        return $ok;
    }

    function fetch_notice_categories($display_type, $status = null, $order_by = null, $order_dir = null) {
        global $con;

        if ($display_type === 'notice-categories') {
            // Helper function to recursively display categories
            $display_category_hierarchy = function($parent_id, $level, &$counter) use ($con, $status, &$display_category_hierarchy) {
                // Fetch categories for this parent level
                if ($parent_id === null) {
                    // Root level categories (parent_id IS NULL or 0)
                    if ($status) {
                        $stmt = $con->prepare("SELECT nc.*, om.* FROM notice_categories nc LEFT JOIN office_members om ON nc.notice_category_added_by = om.office_member_unique_id WHERE (nc.notice_parent_category_id IS NULL OR nc.notice_parent_category_id = 0) AND nc.notice_category_status = ? ORDER BY nc.notice_category_name ASC");
                        $stmt->bind_param("s", $status);
                    } else {
                        $stmt = $con->prepare("SELECT nc.*, om.* FROM notice_categories nc LEFT JOIN office_members om ON nc.notice_category_added_by = om.office_member_unique_id WHERE (nc.notice_parent_category_id IS NULL OR nc.notice_parent_category_id = 0) ORDER BY nc.notice_category_name ASC");
                    }
                } else {
                    // Child categories
                    if ($status) {
                        $stmt = $con->prepare("SELECT nc.*, om.* FROM notice_categories nc LEFT JOIN office_members om ON nc.notice_category_added_by = om.office_member_unique_id WHERE nc.notice_parent_category_id = ? AND nc.notice_category_status = ? ORDER BY nc.notice_category_name ASC");
                        $stmt->bind_param("is", $parent_id, $status);
                    } else {
                        $stmt = $con->prepare("SELECT nc.*, om.* FROM notice_categories nc LEFT JOIN office_members om ON nc.notice_category_added_by = om.office_member_unique_id WHERE nc.notice_parent_category_id = ? ORDER BY nc.notice_category_name ASC");
                        $stmt->bind_param("i", $parent_id);
                    }
                }
                
                $stmt->execute();
                $result = $stmt->get_result();
                
                while ($category = mysqli_fetch_assoc($result)) {
                    $counter++;
                    $category_id = (int) $category['notice_category_id'];
                    $category_name = htmlspecialchars($category['notice_category_name']);
                    $category_slug = isset($category['notice_category_slug']) ? htmlspecialchars($category['notice_category_slug']) : '';
                    $category_status = htmlspecialchars($category['notice_category_status']);
                        if ($category_status === 'active') {
                            $category_status_badge = "
                                <button class='bg-success-focus text-success-main px-24 py-4 rounded-pill fw-medium text-sm' onclick=\"confirmStatusChange('notice_categories', 'notice_category_id', $category_id, 'notice_category_status', 'inactive', 'notice_category_updated_on')\"> " . ucwords(strtolower($category_status)) . "</button>
                            ";
                        } elseif ($category_status === 'inactive') {
                            $category_status_badge = "
                                <button class='bg-warning-focus text-warning-main px-24 py-4 rounded-pill fw-medium text-sm' onclick=\"confirmStatusChange('notice_categories', 'notice_category_id', $category_id, 'notice_category_status', 'active', 'notice_category_updated_on')\"> " . ucwords(strtolower($category_status)) . "</button>
                            ";
                        }
                    
                    // Add indentation based on level
                    $indent = str_repeat('-', $level);
                    $display_name = $level > 0 ? $indent . ' ' . $category_name : $category_name;

                    $notice_category_added_by_id = htmlspecialchars($category['notice_category_added_by']);
                    $notice_category_added_by_salutation = ucwords(strtolower(htmlspecialchars($category['office_member_salutation'])));
                    $notice_category_added_by_fullname = ucwords(strtolower(htmlspecialchars($category['office_member_fullname'])));
                    $notice_category_added_by_name = $notice_category_added_by_salutation . ' ' . $notice_category_added_by_fullname;
                    $notice_category_added_on = date('d M, Y h:i A', strtotime($category['notice_category_added_on']));

                    // Build hierarchical modal name: Parent > Sub > This Category
                    $notice_category_modal_name = $category_name;
                    $parent_stmt = $con->prepare("SELECT notice_category_name, notice_parent_category_id FROM notice_categories WHERE notice_category_id = ? LIMIT 1");
                    if ($parent_stmt) {
                        $parts = [];
                        $ancestor_id = isset($category['notice_parent_category_id']) ? (int)$category['notice_parent_category_id'] : 0;
                        while ($ancestor_id && $ancestor_id !== 0) {
                            $parent_stmt->bind_param('i', $ancestor_id);
                            $parent_stmt->execute();
                            $parent_res = $parent_stmt->get_result();
                            if ($parent_res && $parent_res->num_rows > 0) {
                                $prow = $parent_res->fetch_assoc();
                                $parts[] = ucwords(strtolower(htmlspecialchars($prow['notice_category_name'])));
                                $ancestor_id = isset($prow['notice_parent_category_id']) ? (int)$prow['notice_parent_category_id'] : 0;
                            } else {
                                break;
                            }
                        }
                        if (!empty($parts)) {
                            $notice_category_modal_name = implode(' > ', array_reverse($parts)) . ' > ' . $category_name;
                        }
                        $parent_stmt->close();
                    }

                    $category_updated_on = $category['notice_category_updated_on'] ? date('d M, Y h:i A', strtotime($category['notice_category_updated_on'])) : 'N/A';

                    echo "
                        <tr>
                            <td class='text-center'>$counter</td>
                            <td>$display_name</td>
                            <td>$category_slug</td>
                            <td>$category_status_badge</td>
                            <td>
                                <a href='javascript:void(0)' class='w-32-px h-32-px bg-primary-light text-primary-600 rounded-circle d-inline-flex align-items-center justify-content-center' data-bs-toggle='modal' data-bs-target='#viewNoticeCategoryModal$category_id'>
                                    <iconify-icon icon='iconamoon:eye-light'></iconify-icon>
                                </a>

                                <!--- View Notice Category Modal -->
                                <div class='modal fade' id='viewNoticeCategoryModal$category_id' tabindex='-1' aria-labelledby='viewNoticeCategoryModalLabel$category_id' aria-hidden='true'>
                                    <div class='modal-dialog modal-lg modal-dialog-centered'>
                                        <div class='modal-content'>
                                            <div class='modal-header'>
                                                <h5 class='modal-title' id='viewNoticeCategoryModalLabel$category_id'>Notice Category Details</h5>
                                                <button type='button' class='btn-close' data-bs-dismiss='modal' aria-label='Close'></button>
                                            </div>
                                            <div class='modal-body'>
                                                <div class='row'>
                                                    <div class='col-md-2'>
                                                        <div class='mb-3'>
                                                            <label for='noticeCategoryID' class='form-label'>ID:</label>
                                                            <input type='text' readonly value='$category_id' class='form-control' />
                                                        </div>
                                                    </div>
                                                    <div class='col-md-6'>
                                                        <div class='mb-3'>
                                                            <label for='noticeCategoryAddedBy' class='form-label'>Added By:</label>
                                                            <input type='text' readonly value='$notice_category_added_by_name ($notice_category_added_by_id)' class='form-control' />
                                                        </div>
                                                    </div>
                                                    <div class='col-md-4'>
                                                        <div class='mb-3'>
                                                            <label for='noticeCategoryAddedOn' class='form-label'>Added On:</label>
                                                            <input type='text' readonly value='$notice_category_added_on' class='form-control' />
                                                        </div>
                                                    </div>
                                                    <div class='col-md-12'>
                                                        <div class='mb-3'>
                                                            <label for='noticeCategoryName' class='form-label'>Name:</label>
                                                            <input type='text' readonly value='$notice_category_modal_name' class='form-control' />
                                                        </div>
                                                    </div>
                                                    <div class='col-md-4'>
                                                        <div class='mb-3'>
                                                            <label for='noticeCategorySlug' class='form-label'>Slug:</label>
                                                            <input type='text' readonly value='$category_slug' class='form-control' />
                                                        </div>
                                                    </div>
                                                    <div class='col-md-4'>
                                                        <div class='mb-3'>
                                                            <label for='noticeCategoryStatus' class='form-label'>Status:</label>
                                                            <input type='text' readonly value='" . ucwords(strtolower($category_status)) . "' class='form-control' />
                                                        </div>
                                                    </div>
                                                    <div class='col-md-4'>
                                                        <div class='mb-3'>
                                                            <label for='noticeCategoryUpdatedOn' class='form-label'>Updated On:</label>
                                                            <input type='text' readonly value='$category_updated_on' class='form-control' />
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>
                                            <div class='modal-footer d-flex justify-content-between'>
                                                <div>";
                                                    if ($category_status === 'active') {
                                                        echo "
                                                            <button type='button' class='btn btn-warning' onclick=\"confirmStatusChange('notice-categories', 'notice_category_id', $category_id, 'notice_category_status', 'inactive', 'notice_category_updated_on')\">
                                                                <i class='ri-eye-off-line'></i> Mark as Inactive
                                                            </button>
                                                        ";
                                                    } elseif ($category_status === 'inactive') {
                                                        echo "
                                                            <button type='button' class='btn btn-success' onclick=\"confirmStatusChange('notice-categories', 'notice_category_id', $category_id, 'notice_category_status', 'active', 'notice_category_updated_on')\">
                                                                <i class='ri-eye-line'></i> Mark as Active
                                                            </button>
                                                        ";
                                                    }
                                                    echo "
                                                    <button type='button' class='btn btn-danger' onclick=\"confirmStatusChange('notice-categories', 'notice_category_id', $category_id, 'notice_category_status', 'deleted', 'notice_category_updated_on')\">
                                                        <i class='ri-delete-bin-line'></i> Delete
                                                    </button>
                                                    <button type='button' class='btn btn-danger' onclick=\"confirmStatusChange('notice-categories', 'notice_category_id', $category_id, 'notice_category_status', 'deleted', 'notice_category_updated_on')\">
                                                        <i class='ri-delete-bin-line'></i> Delete
                                                    </button>
                                                </div>
                                                <button type='button' class='btn btn-outline-secondary' data-bs-dismiss='modal'>Close</button>
                                            </div>
                                        </div>
                                    </div>
                                </div>

                                <a href='" . get_site_option('dashboard_url') . "?page=edit-notice-category&notice_category_id=$category_id' class='w-32-px h-32-px bg-success-focus text-success-main rounded-circle d-inline-flex align-items-center justify-content-center'>
                                    <iconify-icon icon='lucide:edit'></iconify-icon>
                                </a>

                                <a href='javascript:void(0);' class='w-32-px h-32-px bg-danger-focus text-danger-main rounded-circle d-inline-flex align-items-center justify-content-center' onclick=\"confirmStatusChange('notice-categories', 'notice_category_id', $category_id, 'notice_category_status', 'deleted', 'notice_category_updated_on')\">
                                    <iconify-icon icon='mingcute:delete-2-line'></iconify-icon>
                                </a>
                            </td>
                        </tr>
                    ";
                    
                    // Recursively display children
                    $display_category_hierarchy($category_id, $level + 1, $counter);
                }
                
                $stmt->close();
            };

            // Start with parent categories (NULL or 0)
            $counter = 0;
            
            // Check if there are any categories
            if ($status) {
                $checkStmt = $con->prepare("SELECT COUNT(*) as total FROM notice_categories WHERE notice_category_status = ?");
                $checkStmt->bind_param("s", $status);
            } else {
                $checkStmt = $con->prepare("SELECT COUNT(*) as total FROM notice_categories WHERE notice_category_status != 'deleted'");
            }
            
            $checkStmt->execute();
            $checkResult = $checkStmt->get_result();
            $row = $checkResult->fetch_assoc();
            $total = $row['total'];
            $checkStmt->close();
            
            if ($total <= 0) {
                echo "
                    <tr class='table-empty'>
                        <td class='text-center text-muted'>—</td>
                        <td class='text-muted'>No notice categories found.</td>
                        <td class='text-muted'>&nbsp;</td>
                        <td class='text-muted'>&nbsp;</td>
                        <td class='text-muted'>&nbsp;</td>
                    </tr>
                ";
            } else {
                // Display hierarchy starting from parent categories (parent_id = NULL or 0)
                $display_category_hierarchy(null, 0, $counter);
            }

        } else {
            return;
        }
    }

    function get_notice_category_details($category_id) {
        global $con;

        $stmt = $con->prepare("SELECT nc.*, om.* FROM notice_categories nc
            LEFT JOIN office_members om ON nc.notice_category_added_by = om.office_member_unique_id
            WHERE notice_category_id = ? AND notice_category_status != 'deleted' LIMIT 0,1");
        if (!$stmt) {
            return null;
        }
        $stmt->bind_param("i", $category_id);
        $stmt->execute();
        $result = $stmt->get_result();
        if ($result->num_rows > 0) {
            $category = $result->fetch_assoc();
            $stmt->close();
            return $category;
        } else {
            $stmt->close();
            return null;
        }
    }

    function edit_notice_category($category_id, $category_name, $parent_category_id, $category_slug) {
        global $con;

        $stmt = $con->prepare("UPDATE notice_categories SET notice_category_name = ?, notice_parent_category_id = ?, notice_category_slug = ?, notice_category_updated_on = NOW() WHERE notice_category_id = ? AND notice_category_status != 'deleted' LIMIT 1");
        if (!$stmt) {
            throw new Exception('Database error: ' . $con->error);
        }
        $stmt->bind_param("sisi", $category_name, $parent_category_id, $category_slug, $category_id);
        $ok = $stmt->execute();
        if (!$ok) {
            throw new Exception('Database error: ' . $stmt->error);
        }
        $stmt->close();
        return $ok;
    }

    function edit_notice($notice_id, $notice_number, $notice_title, $notice_single_line, $notice_category, $notice_badge, $notice_excerpt, $notice_content, $notice_material_title, $new_material_name = null) {
        global $con;

        if ($new_material_name) {
            $stmt = $con->prepare("UPDATE notices SET notice_number = ?, notice_title = ?, notice_single_line = ?, notice_category = ?, notice_badge = ?, notice_excerpt = ?, notice_content = ?, notice_material_title = ?, notice_material = ?, notice_updated_on = NOW() WHERE notice_id = ? AND notice_status != 'deleted' LIMIT 1");
            if (!$stmt) {
                return false;
            }
            $stmt->bind_param("sssssssssi", $notice_number, $notice_title, $notice_single_line, $notice_category, $notice_badge, $notice_excerpt, $notice_content, $notice_material_title, $new_material_name, $notice_id);
        } else {
            $stmt = $con->prepare("UPDATE notices SET notice_number = ?, notice_title = ?, notice_single_line = ?, notice_category = ?, notice_badge = ?, notice_excerpt = ?, notice_content = ?, notice_material_title = ?, notice_updated_on = NOW() WHERE notice_id = ? AND notice_status != 'deleted' LIMIT 1");
            if (!$stmt) {
                return false;
            }
            $stmt->bind_param("ssssssssi", $notice_number, $notice_title, $notice_single_line, $notice_category, $notice_badge, $notice_excerpt, $notice_content, $notice_material_title, $notice_id);
        }

        $ok = $stmt->execute();
        $stmt->close();
        return $ok;
    }

    function get_notice_details($notice_id) {
        global $con;

        $stmt = $con->prepare("SELECT * FROM notices WHERE notice_id = ? AND notice_status != 'deleted' LIMIT 0,1");
        if (!$stmt) {
            return null;
        }
        $stmt->bind_param("i", $notice_id);
        $stmt->execute();
        $result = $stmt->get_result();
        if ($result->num_rows > 0) {
            $notice = $result->fetch_assoc();
            $stmt->close();
            return $notice;
        } else {
            $stmt->close();
            return null;
        }
    }

    function load_phone_codes($this_country_code = null) {
        $selected_code = empty($this_country_code) ? '+91' : $this_country_code;
        
        echo "
            <option data-countryCode='IN' value='+91' " . ($selected_code == '+91' ? 'selected' : '') . ">+91</option>
            <option disabled>--------</option>
            <option data-countryCode='DZ' value='+213' " . ($selected_code == '+213' ? 'selected' : '') . ">+213</option>
            <option data-countryCode='AD' value='+376' " . ($selected_code == '+376' ? 'selected' : '') . ">+376</option>
            <option data-countryCode='AO' value='+244' " . ($selected_code == '+244' ? 'selected' : '') . ">+244</option>
            <option data-countryCode='AI' value='+1264' " . ($selected_code == '+1264' ? 'selected' : '') . ">+1264</option>
            <option data-countryCode='AG' value='+1268' " . ($selected_code == '+1268' ? 'selected' : '') . ">+1268</option>
            <option data-countryCode='AR' value='+54' " . ($selected_code == '+54' ? 'selected' : '') . ">+54</option>
            <option data-countryCode='AM' value='+374' " . ($selected_code == '+374' ? 'selected' : '') . ">+374</option>
            <option data-countryCode='AW' value='+297' " . ($selected_code == '+297' ? 'selected' : '') . ">+297</option>
            <option data-countryCode='AU' value='+61' " . ($selected_code == '+61' ? 'selected' : '') . ">+61</option>
            <option data-countryCode='AT' value='+43' " . ($selected_code == '+43' ? 'selected' : '') . ">+43</option>
            <option data-countryCode='AZ' value='+994' " . ($selected_code == '+994' ? 'selected' : '') . ">+994</option>
            <option data-countryCode='BS' value='+1242' " . ($selected_code == '+1242' ? 'selected' : '') . ">+1242</option>
            <option data-countryCode='BH' value='+973' " . ($selected_code == '+973' ? 'selected' : '') . ">+973</option>
            <option data-countryCode='BD' value='+880' " . ($selected_code == '+880' ? 'selected' : '') . ">+880</option>
            <option data-countryCode='BB' value='+1246' " . ($selected_code == '+1246' ? 'selected' : '') . ">+1246</option>
            <option data-countryCode='BY' value='+375' " . ($selected_code == '+375' ? 'selected' : '') . ">+375</option>
            <option data-countryCode='BE' value='+32' " . ($selected_code == '+32' ? 'selected' : '') . ">+32</option>
            <option data-countryCode='BZ' value='+501' " . ($selected_code == '+501' ? 'selected' : '') . ">+501</option>
            <option data-countryCode='BJ' value='+229' " . ($selected_code == '+229' ? 'selected' : '') . ">+229</option>
            <option data-countryCode='BM' value='+1441' " . ($selected_code == '+1441' ? 'selected' : '') . ">+1441</option>
            <option data-countryCode='BT' value='+975' " . ($selected_code == '+975' ? 'selected' : '') . ">+975</option>
            <option data-countryCode='BO' value='+591' " . ($selected_code == '+591' ? 'selected' : '') . ">+591</option>
            <option data-countryCode='BA' value='+387' " . ($selected_code == '+387' ? 'selected' : '') . ">+387</option>
            <option data-countryCode='BW' value='+267' " . ($selected_code == '+267' ? 'selected' : '') . ">+267</option>
            <option data-countryCode='BR' value='+55' " . ($selected_code == '+55' ? 'selected' : '') . ">+55</option>
            <option data-countryCode='BN' value='+673' " . ($selected_code == '+673' ? 'selected' : '') . ">+673</option>
            <option data-countryCode='BG' value='+359' " . ($selected_code == '+359' ? 'selected' : '') . ">+359</option>
            <option data-countryCode='BF' value='+226' " . ($selected_code == '+226' ? 'selected' : '') . ">+226</option>
            <option data-countryCode='BI' value='+257' " . ($selected_code == '+257' ? 'selected' : '') . ">+257</option>
            <option data-countryCode='KH' value='+855' " . ($selected_code == '+855' ? 'selected' : '') . ">+855</option>
            <option data-countryCode='CM' value='+237' " . ($selected_code == '+237' ? 'selected' : '') . ">+237</option>
            <option data-countryCode='CA' value='+1' " . ($selected_code == '+1' ? 'selected' : '') . ">+1</option>
            <option data-countryCode='CV' value='+238' " . ($selected_code == '+238' ? 'selected' : '') . ">+238</option>
            <option data-countryCode='KY' value='+1345' " . ($selected_code == '+1345' ? 'selected' : '') . ">+1345</option>
            <option data-countryCode='CF' value='+236' " . ($selected_code == '+236' ? 'selected' : '') . ">+236</option>
            <option data-countryCode='CL' value='+56' " . ($selected_code == '+56' ? 'selected' : '') . ">+56</option>
            <option data-countryCode='CN' value='+86' " . ($selected_code == '+86' ? 'selected' : '') . ">+86</option>
            <option data-countryCode='CO' value='+57' " . ($selected_code == '+57' ? 'selected' : '') . ">+57</option>
            <option data-countryCode='KM' value='+269' " . ($selected_code == '+269' ? 'selected' : '') . ">+269</option>
            <option data-countryCode='CG' value='+242' " . ($selected_code == '+242' ? 'selected' : '') . ">+242</option>
            <option data-countryCode='CK' value='+682' " . ($selected_code == '+682' ? 'selected' : '') . ">+682</option>
            <option data-countryCode='CR' value='+506' " . ($selected_code == '+506' ? 'selected' : '') . ">+506</option>
            <option data-countryCode='HR' value='+385' " . ($selected_code == '+385' ? 'selected' : '') . ">+385</option>
            <option data-countryCode='CU' value='+53' " . ($selected_code == '+53' ? 'selected' : '') . ">+53</option>
            <option data-countryCode='CY' value='+90392' " . ($selected_code == '+90392' ? 'selected' : '') . ">+90392</option>
            <option data-countryCode='CY' value='+357' " . ($selected_code == '+357' ? 'selected' : '') . ">+357</option>
            <option data-countryCode='CZ' value='+42' " . ($selected_code == '+42' ? 'selected' : '') . ">+42</option>
            <option data-countryCode='DK' value='+45' " . ($selected_code == '+45' ? 'selected' : '') . ">+45</option>
            <option data-countryCode='DJ' value='+253' " . ($selected_code == '+253' ? 'selected' : '') . ">+253</option>
            <option data-countryCode='DM' value='+1809' " . ($selected_code == '+1809' ? 'selected' : '') . ">+1809</option>
            <option data-countryCode='DO' value='+1809' " . ($selected_code == '+1809' ? 'selected' : '') . ">+1809</option>
            <option data-countryCode='EC' value='+593' " . ($selected_code == '+593' ? 'selected' : '') . ">+593</option>
            <option data-countryCode='EG' value='+20' " . ($selected_code == '+20' ? 'selected' : '') . ">+20</option>
            <option data-countryCode='SV' value='+503' " . ($selected_code == '+503' ? 'selected' : '') . ">+503</option>
            <option data-countryCode='GQ' value='+240' " . ($selected_code == '+240' ? 'selected' : '') . ">+240</option>
            <option data-countryCode='ER' value='+291' " . ($selected_code == '+291' ? 'selected' : '') . ">+291</option>
            <option data-countryCode='EE' value='+372' " . ($selected_code == '+372' ? 'selected' : '') . ">+372</option>
            <option data-countryCode='ET' value='+251' " . ($selected_code == '+251' ? 'selected' : '') . ">+251</option>
            <option data-countryCode='FK' value='+500' " . ($selected_code == '+500' ? 'selected' : '') . ">+500</option>
            <option data-countryCode='FO' value='+298' " . ($selected_code == '+298' ? 'selected' : '') . ">+298</option>
            <option data-countryCode='FJ' value='+679' " . ($selected_code == '+679' ? 'selected' : '') . ">+679</option>
            <option data-countryCode='FI' value='+358' " . ($selected_code == '+358' ? 'selected' : '') . ">+358</option>
            <option data-countryCode='FR' value='+33' " . ($selected_code == '+33' ? 'selected' : '') . ">+33</option>
            <option data-countryCode='GF' value='+594' " . ($selected_code == '+594' ? 'selected' : '') . ">+594</option>
            <option data-countryCode='PF' value='+689' " . ($selected_code == '+689' ? 'selected' : '') . ">+689</option>
            <option data-countryCode='GA' value='+241' " . ($selected_code == '+241' ? 'selected' : '') . ">+241</option>
            <option data-countryCode='GM' value='+220' " . ($selected_code == '+220' ? 'selected' : '') . ">+220</option>
            <option data-countryCode='GE' value='+7880' " . ($selected_code == '+7880' ? 'selected' : '') . ">+7880</option>
            <option data-countryCode='DE' value='+49' " . ($selected_code == '+49' ? 'selected' : '') . ">+49</option>
            <option data-countryCode='GH' value='+233' " . ($selected_code == '+233' ? 'selected' : '') . ">+233</option>
            <option data-countryCode='GI' value='+350' " . ($selected_code == '+350' ? 'selected' : '') . ">+350</option>
            <option data-countryCode='GR' value='+30' " . ($selected_code == '+30' ? 'selected' : '') . ">+30</option>
            <option data-countryCode='GL' value='+299' " . ($selected_code == '+299' ? 'selected' : '') . ">+299</option>
            <option data-countryCode='GD' value='+1473' " . ($selected_code == '+1473' ? 'selected' : '') . ">+1473</option>
            <option data-countryCode='GP' value='+590' " . ($selected_code == '+590' ? 'selected' : '') . ">+590</option>
            <option data-countryCode='GU' value='+671' " . ($selected_code == '+671' ? 'selected' : '') . ">+671</option>
            <option data-countryCode='GT' value='+502' " . ($selected_code == '+502' ? 'selected' : '') . ">+502</option>
            <option data-countryCode='GN' value='+224' " . ($selected_code == '+224' ? 'selected' : '') . ">+224</option>
            <option data-countryCode='GW' value='+245' " . ($selected_code == '+245' ? 'selected' : '') . ">+245</option>
            <option data-countryCode='GY' value='+592' " . ($selected_code == '+592' ? 'selected' : '') . ">+592</option>
            <option data-countryCode='HT' value='+509' " . ($selected_code == '+509' ? 'selected' : '') . ">+509</option>
            <option data-countryCode='HN' value='+504' " . ($selected_code == '+504' ? 'selected' : '') . ">+504</option>
            <option data-countryCode='HK' value='+852' " . ($selected_code == '+852' ? 'selected' : '') . ">+852</option>
            <option data-countryCode='HU' value='+36' " . ($selected_code == '+36' ? 'selected' : '') . ">+36</option>
            <option data-countryCode='IS' value='+354' " . ($selected_code == '+354' ? 'selected' : '') . ">+354</option>
            <option data-countryCode='ID' value='+62' " . ($selected_code == '+62' ? 'selected' : '') . ">+62</option>
            <option data-countryCode='IR' value='+98' " . ($selected_code == '+98' ? 'selected' : '') . ">+98</option>
            <option data-countryCode='IQ' value='+964' " . ($selected_code == '+964' ? 'selected' : '') . ">+964</option>
            <option data-countryCode='IE' value='+353' " . ($selected_code == '+353' ? 'selected' : '') . ">+353</option>
            <option data-countryCode='IL' value='+972' " . ($selected_code == '+972' ? 'selected' : '') . ">+972</option>
            <option data-countryCode='IT' value='+39' " . ($selected_code == '+39' ? 'selected' : '') . ">+39</option>
            <option data-countryCode='JM' value='+1876' " . ($selected_code == '+1876' ? 'selected' : '') . ">+1876</option>
            <option data-countryCode='JP' value='+81' " . ($selected_code == '+81' ? 'selected' : '') . ">+81</option>
            <option data-countryCode='JO' value='+962' " . ($selected_code == '+962' ? 'selected' : '') . ">+962</option>
            <option data-countryCode='KZ' value='+7' " . ($selected_code == '+7' ? 'selected' : '') . ">+7</option>
            <option data-countryCode='KE' value='+254' " . ($selected_code == '+254' ? 'selected' : '') . ">+254</option>
            <option data-countryCode='KI' value='+686' " . ($selected_code == '+686' ? 'selected' : '') . ">+686</option>
            <option data-countryCode='KP' value='+850' " . ($selected_code == '+850' ? 'selected' : '') . ">+850</option>
            <option data-countryCode='KR' value='+82' " . ($selected_code == '+82' ? 'selected' : '') . ">+82</option>
            <option data-countryCode='KW' value='+965' " . ($selected_code == '+965' ? 'selected' : '') . ">+965</option>
            <option data-countryCode='KG' value='+996' " . ($selected_code == '+996' ? 'selected' : '') . ">+996</option>
            <option data-countryCode='LA' value='+856' " . ($selected_code == '+856' ? 'selected' : '') . ">+856</option>
            <option data-countryCode='LV' value='+371' " . ($selected_code == '+371' ? 'selected' : '') . ">+371</option>
            <option data-countryCode='LB' value='+961' " . ($selected_code == '+961' ? 'selected' : '') . ">+961</option>
            <option data-countryCode='LS' value='+266' " . ($selected_code == '+266' ? 'selected' : '') . ">+266</option>
            <option data-countryCode='LR' value='+231' " . ($selected_code == '+231' ? 'selected' : '') . ">+231</option>
            <option data-countryCode='LY' value='+218' " . ($selected_code == '+218' ? 'selected' : '') . ">+218</option>
            <option data-countryCode='LI' value='+417' " . ($selected_code == '+417' ? 'selected' : '') . ">+417</option>
            <option data-countryCode='LT' value='+370' " . ($selected_code == '+370' ? 'selected' : '') . ">+370</option>
            <option data-countryCode='LU' value='+352' " . ($selected_code == '+352' ? 'selected' : '') . ">+352</option>
            <option data-countryCode='MO' value='+853' " . ($selected_code == '+853' ? 'selected' : '') . ">+853</option>
            <option data-countryCode='MK' value='+389' " . ($selected_code == '+389' ? 'selected' : '') . ">+389</option>
            <option data-countryCode='MG' value='+261' " . ($selected_code == '+261' ? 'selected' : '') . ">+261</option>
            <option data-countryCode='MW' value='+265' " . ($selected_code == '+265' ? 'selected' : '') . ">+265</option>
            <option data-countryCode='MY' value='+60' " . ($selected_code == '+60' ? 'selected' : '') . ">+60</option>
            <option data-countryCode='MV' value='+960' " . ($selected_code == '+960' ? 'selected' : '') . ">+960</option>
            <option data-countryCode='ML' value='+223' " . ($selected_code == '+223' ? 'selected' : '') . ">+223</option>
            <option data-countryCode='MT' value='+356' " . ($selected_code == '+356' ? 'selected' : '') . ">+356</option>
            <option data-countryCode='MH' value='+692' " . ($selected_code == '+692' ? 'selected' : '') . ">+692</option>
            <option data-countryCode='MQ' value='+596' " . ($selected_code == '+596' ? 'selected' : '') . ">+596</option>
            <option data-countryCode='MR' value='+222' " . ($selected_code == '+222' ? 'selected' : '') . ">+222</option>
            <option data-countryCode='YT' value='+269' " . ($selected_code == '+269' ? 'selected' : '') . ">+269</option>
            <option data-countryCode='MX' value='+52' " . ($selected_code == '+52' ? 'selected' : '') . ">+52</option>
            <option data-countryCode='FM' value='+691' " . ($selected_code == '+691' ? 'selected' : '') . ">+691</option>
            <option data-countryCode='MD' value='+373' " . ($selected_code == '+373' ? 'selected' : '') . ">+373</option>
            <option data-countryCode='MC' value='+377' " . ($selected_code == '+377' ? 'selected' : '') . ">+377</option>
            <option data-countryCode='MN' value='+976' " . ($selected_code == '+976' ? 'selected' : '') . ">+976</option>
            <option data-countryCode='MS' value='+1664' " . ($selected_code == '+1664' ? 'selected' : '') . ">+1664</option>
            <option data-countryCode='MA' value='+212' " . ($selected_code == '+212' ? 'selected' : '') . ">+212</option>
            <option data-countryCode='MZ' value='+258' " . ($selected_code == '+258' ? 'selected' : '') . ">+258</option>
            <option data-countryCode='MN' value='+95' " . ($selected_code == '+95' ? 'selected' : '') . ">+95</option>
            <option data-countryCode='NA' value='+264' " . ($selected_code == '+264' ? 'selected' : '') . ">+264</option>
            <option data-countryCode='NR' value='+674' " . ($selected_code == '+674' ? 'selected' : '') . ">+674</option>
            <option data-countryCode='NP' value='+977' " . ($selected_code == '+977' ? 'selected' : '') . ">+977</option>
            <option data-countryCode='NL' value='+31' " . ($selected_code == '+31' ? 'selected' : '') . ">+31</option>
            <option data-countryCode='NC' value='+687' " . ($selected_code == '+687' ? 'selected' : '') . ">+687</option>
            <option data-countryCode='NZ' value='+64' " . ($selected_code == '+64' ? 'selected' : '') . ">+64</option>
            <option data-countryCode='NI' value='+505' " . ($selected_code == '+505' ? 'selected' : '') . ">+505</option>
            <option data-countryCode='NE' value='+227' " . ($selected_code == '+227' ? 'selected' : '') . ">+227</option>
            <option data-countryCode='NG' value='+234' " . ($selected_code == '+234' ? 'selected' : '') . ">+234</option>
            <option data-countryCode='NU' value='+683' " . ($selected_code == '+683' ? 'selected' : '') . ">+683</option>
            <option data-countryCode='NF' value='+672' " . ($selected_code == '+672' ? 'selected' : '') . ">+672</option>
            <option data-countryCode='NP' value='+670' " . ($selected_code == '+670' ? 'selected' : '') . ">+670</option>
            <option data-countryCode='NO' value='+47' " . ($selected_code == '+47' ? 'selected' : '') . ">+47</option>
            <option data-countryCode='OM' value='+968' " . ($selected_code == '+968' ? 'selected' : '') . ">+968</option>
            <option data-countryCode='PW' value='+680' " . ($selected_code == '+680' ? 'selected' : '') . ">+680</option>
            <option data-countryCode='PA' value='+507' " . ($selected_code == '+507' ? 'selected' : '') . ">+507</option>
            <option data-countryCode='PG' value='+675' " . ($selected_code == '+675' ? 'selected' : '') . ">+675</option>
            <option data-countryCode='PY' value='+595' " . ($selected_code == '+595' ? 'selected' : '') . ">+595</option>
            <option data-countryCode='PE' value='+51' " . ($selected_code == '+51' ? 'selected' : '') . ">+51</option>
            <option data-countryCode='PH' value='+63' " . ($selected_code == '+63' ? 'selected' : '') . ">+63</option>
            <option data-countryCode='PL' value='+48' " . ($selected_code == '+48' ? 'selected' : '') . ">+48</option>
            <option data-countryCode='PT' value='+351' " . ($selected_code == '+351' ? 'selected' : '') . ">+351</option>
            <option data-countryCode='PR' value='+1787' " . ($selected_code == '+1787' ? 'selected' : '') . ">+1787</option>
            <option data-countryCode='QA' value='+974' " . ($selected_code == '+974' ? 'selected' : '') . ">+974</option>
            <option data-countryCode='RE' value='+262' " . ($selected_code == '+262' ? 'selected' : '') . ">+262</option>
            <option data-countryCode='RO' value='+40' " . ($selected_code == '+40' ? 'selected' : '') . ">+40</option>
            <option data-countryCode='RU' value='+7' " . ($selected_code == '+7' ? 'selected' : '') . ">+7</option>
            <option data-countryCode='RW' value='+250' " . ($selected_code == '+250' ? 'selected' : '') . ">+250</option>
            <option data-countryCode='SM' value='+378' " . ($selected_code == '+378' ? 'selected' : '') . ">+378</option>
            <option data-countryCode='ST' value='+239' " . ($selected_code == '+239' ? 'selected' : '') . ">+239</option>
            <option data-countryCode='SA' value='+966' " . ($selected_code == '+966' ? 'selected' : '') . ">+966</option>
            <option data-countryCode='SN' value='+221' " . ($selected_code == '+221' ? 'selected' : '') . ">+221</option>
            <option data-countryCode='CS' value='+381' " . ($selected_code == '+381' ? 'selected' : '') . ">+381</option>
            <option data-countryCode='SC' value='+248' " . ($selected_code == '+248' ? 'selected' : '') . ">+248</option>
            <option data-countryCode='SL' value='+232' " . ($selected_code == '+232' ? 'selected' : '') . ">+232</option>
            <option data-countryCode='SG' value='+65' " . ($selected_code == '+65' ? 'selected' : '') . ">+65</option>
            <option data-countryCode='SK' value='+421' " . ($selected_code == '+421' ? 'selected' : '') . ">+421</option>
            <option data-countryCode='SI' value='+386' " . ($selected_code == '+386' ? 'selected' : '') . ">+386</option>
            <option data-countryCode='SB' value='+677' " . ($selected_code == '+677' ? 'selected' : '') . ">+677</option>
            <option data-countryCode='SO' value='+252' " . ($selected_code == '+252' ? 'selected' : '') . ">+252</option>
            <option data-countryCode='ZA' value='+27' " . ($selected_code == '+27' ? 'selected' : '') . ">+27</option>
            <option data-countryCode='ES' value='+34' " . ($selected_code == '+34' ? 'selected' : '') . ">+34</option>
            <option data-countryCode='LK' value='+94' " . ($selected_code == '+94' ? 'selected' : '') . ">+94</option>
            <option data-countryCode='SH' value='+290' " . ($selected_code == '+290' ? 'selected' : '') . ">+290</option>
            <option data-countryCode='KN' value='+1869' " . ($selected_code == '+1869' ? 'selected' : '') . ">+1869</option>
            <option data-countryCode='SC' value='+1758' " . ($selected_code == '+1758' ? 'selected' : '') . ">+1758</option>
            <option data-countryCode='SD' value='+249' " . ($selected_code == '+249' ? 'selected' : '') . ">+249</option>
            <option data-countryCode='SR' value='+597' " . ($selected_code == '+597' ? 'selected' : '') . ">+597</option>
            <option data-countryCode='SZ' value='+268' " . ($selected_code == '+268' ? 'selected' : '') . ">+268</option>
            <option data-countryCode='SE' value='+46' " . ($selected_code == '+46' ? 'selected' : '') . ">+46</option>
            <option data-countryCode='CH' value='+41' " . ($selected_code == '+41' ? 'selected' : '') . ">+41</option>
            <option data-countryCode='SI' value='+963' " . ($selected_code == '+963' ? 'selected' : '') . ">+963</option>
            <option data-countryCode='TW' value='+886' " . ($selected_code == '+886' ? 'selected' : '') . ">+886</option>
            <option data-countryCode='TJ' value='+7' " . ($selected_code == '+7' ? 'selected' : '') . ">+7</option>
            <option data-countryCode='TH' value='+66' " . ($selected_code == '+66' ? 'selected' : '') . ">+66</option>
            <option data-countryCode='TG' value='+228' " . ($selected_code == '+228' ? 'selected' : '') . ">+228</option>
            <option data-countryCode='TO' value='+676' " . ($selected_code == '+676' ? 'selected' : '') . ">+676</option>
            <option data-countryCode='TT' value='+1868' " . ($selected_code == '+1868' ? 'selected' : '') . ">+1868</option>
            <option data-countryCode='TN' value='+216' " . ($selected_code == '+216' ? 'selected' : '') . ">+216</option>
            <option data-countryCode='TR' value='+90' " . ($selected_code == '+90' ? 'selected' : '') . ">+90</option>
            <option data-countryCode='TM' value='+7' " . ($selected_code == '+7' ? 'selected' : '') . ">+7</option>
            <option data-countryCode='TM' value='+993' " . ($selected_code == '+993' ? 'selected' : '') . ">+993</option>
            <option data-countryCode='TC' value='+1649' " . ($selected_code == '+1649' ? 'selected' : '') . ">+1649</option>
            <option data-countryCode='TV' value='+688' " . ($selected_code == '+688' ? 'selected' : '') . ">+688</option>
            <option data-countryCode='UG' value='+256' " . ($selected_code == '+256' ? 'selected' : '') . ">+256</option>
            <option data-countryCode='GB' value='+44' " . ($selected_code == '+44' ? 'selected' : '') . ">+44</option>
            <option data-countryCode='UA' value='+380' " . ($selected_code == '+380' ? 'selected' : '') . ">+380</option>
            <option data-countryCode='AE' value='+971' " . ($selected_code == '+971' ? 'selected' : '') . ">+971</option>
            <option data-countryCode='UY' value='+598' " . ($selected_code == '+598' ? 'selected' : '') . ">+598</option>
            <option data-countryCode='US' value='+1' " . ($selected_code == '+1' ? 'selected' : '') . ">+1</option>
            <option data-countryCode='UZ' value='+7' " . ($selected_code == '+7' ? 'selected' : '') . ">+7</option>
            <option data-countryCode='VU' value='+678' " . ($selected_code == '+678' ? 'selected' : '') . ">+678</option>
            <option data-countryCode='VA' value='+379' " . ($selected_code == '+379' ? 'selected' : '') . ">+379</option>
            <option data-countryCode='VE' value='+58' " . ($selected_code == '+58' ? 'selected' : '') . ">+58</option>
            <option data-countryCode='VN' value='+84' " . ($selected_code == '+84' ? 'selected' : '') . ">+84</option>
            <option data-countryCode='VG' value='+84' " . ($selected_code == '+84' ? 'selected' : '') . ">+84</option>
            <option data-countryCode='VI' value='+84' " . ($selected_code == '+84' ? 'selected' : '') . ">+84</option>
            <option data-countryCode='WF' value='+681' " . ($selected_code == '+681' ? 'selected' : '') . ">+681</option>
            <option data-countryCode='YE' value='+969' " . ($selected_code == '+969' ? 'selected' : '') . ">+969</option>
            <option data-countryCode='YE' value='+967' " . ($selected_code == '+967' ? 'selected' : '') . ">+967</option>
            <option data-countryCode='ZM' value='+260' " . ($selected_code == '+260' ? 'selected' : '') . ">+260</option>
            <option data-countryCode='ZW' value='+263' " . ($selected_code == '+263' ? 'selected' : '') . ">+263</option>
        ";
    }
?>

