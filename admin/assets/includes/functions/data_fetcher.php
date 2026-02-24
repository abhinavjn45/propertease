<?php
    function load_announcements($position, $announcement_status = null, $current_time = null, $order_by = null, $order_dir = null) {
        global $con;
        
        if ($position === 'topbar') {
            $get_announcements = "SELECT * FROM announcements WHERE announcement_status = '$announcement_status' AND announcement_expiry_on > '$current_time' ORDER BY $order_by $order_dir";
            $run_announcements = mysqli_query($con, $get_announcements);
            $count_announcements = mysqli_num_rows($run_announcements);
            if ($count_announcements <= 0) {
                echo "
                    <span class='top-bar-item' style='animation: ticker 10s linear infinite !important;'>
                        <span class='top-bar-dot'></span> No announcements available at the moment.
                    </span>
                ";
            } else {
                if ($count_announcements == 1) {
                    while ($row_announcements = mysqli_fetch_array($run_announcements)) {
                        $announcement_content = $row_announcements['announcement_content'];
                        for ($i = 0; $i < 3; $i++) { 
                            echo "
                                <span class='top-bar-item'>
                                    <span class='top-bar-dot'></span> $announcement_content
                                </span>
                            ";
                        }
                    }
                } elseif ($count_announcements == 2) {
                    while ($row_announcements = mysqli_fetch_array($run_announcements)) {
                        $announcement_content = $row_announcements['announcement_content'];
                        echo "
                            <span class='top-bar-item'>
                                <span class='top-bar-dot'></span> $announcement_content
                            </span>
                        ";
                    }
                    // Reset pointer and loop again for duplication
                    mysqli_data_seek($run_announcements, 0);
                    while ($row_announcements = mysqli_fetch_array($run_announcements)) {
                        $announcement_content = $row_announcements['announcement_content'];
                        echo "
                            <span class='top-bar-item'>
                                <span class='top-bar-dot'></span> $announcement_content
                            </span>
                        ";
                    }
                } elseif ($count_announcements >= 3) {
                    while ($row_announcements = mysqli_fetch_array($run_announcements)) {
                        $announcement_content = $row_announcements['announcement_content'];
                        echo "
                            <span class='top-bar-item'>
                                <span class='top-bar-dot'></span> $announcement_content
                            </span>
                        ";
                    }
                }
            }
        }
        
        if ($position === 'announcements-management') {
            // Set defaults for ordering if not provided
            $order_by = !empty($order_by) ? $order_by : 'announcement_id';
            $order_dir = !empty($order_dir) ? $order_dir : 'DESC';
            
            $stmt = mysqli_prepare($con, "SELECT a.*, om.office_member_salutation, om.office_member_fullname FROM announcements a LEFT JOIN office_members om ON a.announcement_added_by = om.office_member_unique_id WHERE a.announcement_status != 'deleted' ORDER BY $order_by $order_dir");
            mysqli_stmt_execute($stmt);
            $result = mysqli_stmt_get_result($stmt);
            if (mysqli_num_rows($result) <= 0) {
                echo "
                    <tr class='table-empty'>
                        <td class='text-center text-muted'>—</td>
                        <td class='text-muted'>No announcements found.</td>
                        <td class='text-muted'>&nbsp;</td>
                        <td class='text-muted'>&nbsp;</td>
                        <td class='text-muted'>&nbsp;</td>
                    </tr>
                ";
            } else {
                $i = 0;
                while ($announcement = mysqli_fetch_assoc($result)) {
                    $i++;
                    $announcement_id = $announcement['announcement_id'];
                    $announcement_content = htmlspecialchars($announcement['announcement_content']);
                        if (strlen($announcement_content) > 50) {
                            $announcement_content_display = substr($announcement_content, 0, 50) . "...";
                        } else {
                            $announcement_content_display = $announcement_content;
                        }
                    $announcement_expiry = date("d M, Y", strtotime($announcement['announcement_expiry_on']));
                    $announcement_status = htmlspecialchars($announcement['announcement_status']);
                        if ($announcement_status === 'active') {
                            $announcement_status_badge = "
                                <button class='bg-success-focus text-success-main px-24 py-4 rounded-pill fw-medium text-sm' onclick=\"confirmStatusChange('announcements', 'announcement_id', $announcement_id, 'announcement_status', 'inactive', 'announcement_updated_on')\"> " . ucwords(strtolower($announcement_status)) . "</button>
                            ";
                        } elseif ($announcement_status === 'inactive') {
                            $announcement_status_badge = "
                                <button class='bg-warning-focus text-warning-main px-24 py-4 rounded-pill fw-medium text-sm' onclick=\"confirmStatusChange('announcements', 'announcement_id', $announcement_id, 'announcement_status', 'active', 'announcement_updated_on')\"> " . ucwords(strtolower($announcement_status)) . "</button>
                            ";
                        }

                    $announcement_added_by_id = htmlspecialchars($announcement['announcement_added_by']);
                    $announcement_added_by_salutation = ucwords(strtolower($announcement['office_member_salutation']));
                    $announcement_added_by_fullname = ucwords(strtolower($announcement['office_member_fullname']));
                    $announcement_added_by_name = $announcement_added_by_salutation . ' ' . $announcement_added_by_fullname;
                    $announcement_added_on = !empty($announcement['announcement_added_on']) ? date("d M, Y h:i:s A", strtotime($announcement['announcement_added_on'])) : 'N/A';
                    $announcement_updated = !empty($announcement['announcement_updated_on']) ? date("d M, Y h:i:s A", strtotime($announcement['announcement_updated_on'])) : 'N/A';

                    echo "
                        <tr>
                            <td class='text-center'>
                                $i
                            </td>
                            <td>$announcement_content_display</td>
                            <td>$announcement_expiry</td>
                            <td>$announcement_status_badge</td>
                            <td>
                                <a href='javascript:void(0)' class='w-32-px h-32-px bg-primary-light text-primary-600 rounded-circle d-inline-flex align-items-center justify-content-center' data-bs-toggle='modal' data-bs-target='#viewAnnouncementModal$announcement_id'>
                                    <iconify-icon icon='iconamoon:eye-light'></iconify-icon>
                                </a>

                                <!--- View Announcement Modal -->
                                <div class='modal fade' id='viewAnnouncementModal$announcement_id' tabindex='-1' aria-labelledby='viewAnnouncementModalLabel$announcement_id' aria-hidden='true'>
                                    <div class='modal-dialog modal-lg modal-dialog-centered'>
                                        <div class='modal-content'>
                                            <div class='modal-header'>
                                                <h5 class='modal-title' id='viewAnnouncementModalLabel$announcement_id'>Announcement Details</h5>
                                                <button type='button' class='btn-close' data-bs-dismiss='modal' aria-label='Close'></button>
                                            </div>
                                            <div class='modal-body'>
                                                <div class='row'>
                                                    <div class='col-md-2'>
                                                        <div class='mb-3'>
                                                            <label for='announcementID' class='form-label'>ID:</label>
                                                            <input type='text' readonly value='$announcement_id' class='form-control' />
                                                        </div>
                                                    </div>
                                                    <div class='col-md-6'>
                                                        <div class='mb-3'>
                                                            <label for='announcementAddedBy' class='form-label'>Added By:</label>
                                                            <input type='text' readonly value='$announcement_added_by_name ($announcement_added_by_id)' class='form-control' />
                                                        </div>
                                                    </div>
                                                    <div class='col-md-4'>
                                                        <div class='mb-3'>
                                                            <label for='announcementAddedBy' class='form-label'>Added On:</label>
                                                            <input type='text' readonly value='$announcement_added_on' class='form-control' />
                                                        </div>
                                                    </div>
                                                    <div class='col-md-12'>
                                                        <div class='mb-3'>
                                                            <label for='announcementContent' class='form-label'>Content:</label>
                                                            <textarea id='announcementContent' class='form-control' rows='4' readonly style='resize: none;'>$announcement_content</textarea>
                                                        </div>
                                                    </div>
                                                    <div class='col-md-3'>
                                                        <div class='mb-3'>
                                                            <label for='announcementAddedBy' class='form-label'>Status:</label>
                                                            <input type='text' readonly value='" . ucwords(strtolower($announcement_status)) . "' class='form-control' />
                                                        </div>
                                                    </div>
                                                    <div class='col-md-5'>
                                                        <div class='mb-3'>
                                                            <label for='announcementAddedBy' class='form-label'>Expiry On:</label>
                                                            <input type='text' readonly value='$announcement_expiry' class='form-control' />
                                                        </div>
                                                    </div>
                                                    <div class='col-md-4'>
                                                        <div class='mb-3'>
                                                            <label for='announcementAddedBy' class='form-label'>Updated On:</label>
                                                            <input type='text' readonly value='$announcement_updated' class='form-control' />
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>
                                            <div class='modal-footer d-flex justify-content-between'>
                                                <div>";
                                                    if ($announcement_status === 'active') {
                                                        echo "
                                                            <button type='button' class='btn btn-warning' onclick=\"confirmStatusChange('announcements', 'announcement_id', $announcement_id, 'announcement_status', 'inactive', 'announcement_updated_on')\">
                                                                <i class='ri-eye-off-line'></i> Mark as Inactive
                                                            </button>
                                                        ";
                                                    } elseif ($announcement_status === 'inactive') {
                                                        echo "
                                                            <button type='button' class='btn btn-success' onclick=\"confirmStatusChange('announcements', 'announcement_id', $announcement_id, 'announcement_status', 'active', 'announcement_updated_on')\">
                                                                <i class='ri-eye-line'></i> Mark as Active
                                                            </button>
                                                        ";
                                                    }
                                                    echo "
                                                    <button type='button' class='btn btn-danger' onclick=\"confirmStatusChange('announcements', 'announcement_id', $announcement_id, 'announcement_status', 'deleted', 'announcement_updated_on')\">
                                                        <i class='ri-delete-bin-line'></i> Delete
                                                    </button>
                                                </div>
                                                <button type='button' class='btn btn-outline-secondary' data-bs-dismiss='modal'>Close</button>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                                
                                <a href='" . get_site_option('dashboard_url') . "?page=edit-announcement&announcement_id=$announcement_id' class='w-32-px h-32-px bg-success-focus text-success-main rounded-circle d-inline-flex align-items-center justify-content-center'>
                                    <iconify-icon icon='lucide:edit'></iconify-icon>
                                </a>

                                <a href='javascript:void(0);' class='w-32-px h-32-px bg-danger-focus text-danger-main rounded-circle d-inline-flex align-items-center justify-content-center' onclick=\"confirmStatusChange('announcements', 'announcement_id', $announcement_id, 'announcement_status', 'deleted', 'announcement_updated_on')\">
                                    <iconify-icon icon='mingcute:delete-2-line'></iconify-icon>
                                </a>
                            </td>
                        </tr>
                    ";
                }
            }
        }
    }

    function get_site_option($option_name, $skip_replacement = false) {
        global $con;
        
        $stmt = mysqli_prepare($con, "SELECT option_value FROM site_options WHERE option_key = ? LIMIT 1");
        mysqli_stmt_bind_param($stmt, 's', $option_name);
        mysqli_stmt_execute($stmt);
        $result = mysqli_stmt_get_result($stmt);
        $row = mysqli_fetch_assoc($result);
        
        if (!$row) {
            return null;
        }
        
        $value = $row['option_value'];
        
        // Skip replacement for nested options to prevent infinite recursion
        if ($skip_replacement) {
            return $value;
        }
        
        // Fetch nested options first (with skip_replacement=true to prevent recursion)
        $site_fullname = get_site_option('site_fullname', true);
        $site_title = get_site_option('site_title', true);
        $site_url = get_site_option('site_url', true);
        $admin_email = get_site_option('admin_email', true);
        
        // Replace placeholders
        $replacements = [
            '{year}' => date('Y'),
            '{month}' => date('F'),
            '{date}' => date('Y-m-d'),
            '{time}' => date('H:i:s'),
            '{day}' => date('d'),
            '{site_fullname}' => $site_fullname,
            '{site_title}' => $site_title,
            '{site_url}' => $site_url,
            '{admin_email}' => $admin_email,
            '{current_user}' => isset($_SESSION['member_email']) ? $_SESSION['member_email'] : 'Guest'
        ];
        
        foreach ($replacements as $placeholder => $replacement) {
            if ($replacement !== null) {
                $value = str_replace($placeholder, $replacement, $value);
            }
        }
        
        return $value;
    }

    function load_header_data() {
        global $con;

        echo "
            <img src='" . get_site_option('site_url') . "/assets/images/logos/" . htmlspecialchars(get_site_option('logo')) . "' alt='" . htmlspecialchars(get_site_option('site_title')) . " Logo' class='brand-logo' onclick='window.location.href=\"" . get_site_option('site_url') . "\"' style='cursor: pointer;'>
            <div class='brand-text'>
        ";

        if (get_site_option('show_site_topheading') === 'on') {
            echo "
                <div class='brand-ministry'>
                    " . htmlspecialchars(get_site_option('site_topheading')) . "
                </div>
            ";
        }

        echo "
            <h1 class='brand-title mb-0' id='site-title' onclick='window.location.href=\"" . get_site_option('site_url') . "\"' style='cursor: pointer;'>" . htmlspecialchars(get_site_option('site_fullname')) . "</h1>
        ";

        if (get_site_option('show_site_tagline') === 'on') {
            echo "
                <p class='brand-tagline mb-0' id='site-tagline' style='font-weight: bold; font-size: 20px;'>" . htmlspecialchars(get_site_option('site_tagline')) . "</p>
            ";
        }

        echo "
            </div>
        ";
    }

    function get_hero_section_data($hero_content_key) {
        global $con;
        
        $stmt = mysqli_prepare($con, "SELECT hero_content_value FROM hero_section WHERE hero_content_key = ? LIMIT 1");
        mysqli_stmt_bind_param($stmt, 's', $hero_content_key);
        mysqli_stmt_execute($stmt);
        $result = mysqli_stmt_get_result($stmt);
        $row = mysqli_fetch_assoc($result);
        
        if (!$row) {
            return null;
        }
        
        $value = $row['hero_content_value'];
        
        // Fetch nested options first (with skip_replacement=true to prevent recursion)
        $site_fullname = get_site_option('site_fullname', true);
        $site_title = get_site_option('site_title', true);
        $site_url = get_site_option('site_url', true);
        $admin_email = get_site_option('admin_email', true);
        
        // Replace placeholders
        $replacements = [
            '{year}' => date('Y'),
            '{month}' => date('F'),
            '{date}' => date('Y-m-d'),
            '{time}' => date('H:i:s'),
            '{day}' => date('d'),
            '{site_fullname}' => $site_fullname,
            '{site_title}' => $site_title,
            '{site_url}' => $site_url,
            '{admin_email}' => $admin_email,
            '{current_user}' => isset($_SESSION['member_email']) ? $_SESSION['member_email'] : 'Guest'
        ];
        
        foreach ($replacements as $placeholder => $replacement) {
            if ($replacement !== null) {
                $value = str_replace($placeholder, $replacement, $value);
            }
        }
        
        return $value;
    }

    function get_office_details($office_detail_key) {
        global $con;
        
        $stmt = mysqli_prepare($con, "SELECT office_detail_value FROM office_details WHERE office_detail_key = ? LIMIT 1");
        mysqli_stmt_bind_param($stmt, 's', $office_detail_key);
        mysqli_stmt_execute($stmt);
        $result = mysqli_stmt_get_result($stmt);
        $row = mysqli_fetch_assoc($result);

        if (!$row) {
            return null;
        }
        
        return $row['office_detail_value'];
    }

    function get_office_address() {
        $full_office_address = get_office_details('office_complete_address');
        
        if (empty($full_office_address)) {
            return '';
        }
        
        $office_address_parts = explode(',', $full_office_address);
        $office_address_parts = array_map('trim', $office_address_parts);
        
        $formatted_lines = [];
        
        // Add first part on its own line
        $formatted_lines[] = $office_address_parts[0];
        
        // Process remaining parts in pairs (2-2)
        for ($i = 1; $i < count($office_address_parts); $i += 2) {
            $line = $office_address_parts[$i];
            
            // Add the next part if it exists
            if (isset($office_address_parts[$i + 1])) {
                $line .= ', ' . $office_address_parts[$i + 1];
            }
            
            $formatted_lines[] = $line;
        }
        
        return implode(',<br>', $formatted_lines);
    }

    function get_office_hours() {
        $days = ['Monday', 'Tuesday', 'Wednesday', 'Thursday', 'Friday', 'Saturday', 'Sunday'];
        $office_hours = [];
        
        // Fetch hours for each day
        foreach ($days as $day) {
            $day_lower = strtolower($day);
            $open_hours = get_office_details('office_' . $day_lower . '_open_hours');
            $close_hours = get_office_details('office_' . $day_lower . '_close_hours');
            
            if (!empty($open_hours) && !empty($close_hours)) {
                $office_hours[$day] = [
                    'open' => $open_hours,
                    'close' => $close_hours,
                    'status' => 'open'
                ];
            } else {
                $office_hours[$day] = [
                    'open' => null,
                    'close' => null,
                    'status' => 'closed'
                ];
            }
        }
        
        $formatted_hours = [];
        $i = 0;
        
        while ($i < count($days)) {
            $current_day = $days[$i];
            $current_hours = $office_hours[$current_day];
            
            $start_day = $current_day;
            $end_day = $current_day;
            $j = $i + 1;
            
            // Group consecutive days with same status and hours
            while ($j < count($days)) {
                $next_day = $days[$j];
                $next_hours = $office_hours[$next_day];
                
                // Check if next day has same status and hours
                $same_status = $next_hours['status'] === $current_hours['status'];
                $same_hours = ($next_hours['open'] === $current_hours['open'] && 
                              $next_hours['close'] === $current_hours['close']);
                
                if ($same_status && $same_hours) {
                    $end_day = $next_day;
                    $j++;
                } else {
                    break;
                }
            }
            
            // Format the day range
            if ($start_day === $end_day) {
                $day_range = $start_day;
            } else {
                $day_range = $start_day . ' - ' . $end_day;
            }
            
            // Format the hours
            if ($current_hours['status'] === 'closed') {
                $formatted_hours[] = $day_range . ': <span style="color: red;">Office Remains Closed</span>';
            } else {
                $formatted_hours[] = $day_range . ': ' . $current_hours['open'] . ' - ' . $current_hours['close'];
            }
            
            $i = $j;
        }
        
        if (empty($formatted_hours)) {
            return '<div class="info-value"><p>Office hours not available</p></div>';
        }
        
        return implode('<br>', $formatted_hours);
    }

    function get_maps_embed_code() {
        $map_iframe = get_office_details('map_iframe');
        $latitude = get_office_details('map_latitude');
        $longitude = get_office_details('map_longitude');

        if (empty($map_iframe)) {
            if (empty($latitude) || empty($longitude)) {
                return '<p>Map location not available</p>';
            }

            // Construct simple Google Maps embed URL with coordinates
            // Format: https://maps.google.com/maps?q={latitude},{longitude}&z=15&output=embed
            $embed_url = "https://maps.google.com/maps?q=" . urlencode($latitude) . "," . urlencode($longitude) . "&z=15&output=embed";
            
            $iframe = '<iframe class="map-embed" src="' . htmlspecialchars($embed_url) . '" allowfullscreen="" loading="lazy" referrerpolicy="no-referrer-when-downgrade" title="Society location map"></iframe>';
        } else {
            // Extract the src URL from stored iframe code
            preg_match('/src="([^"]+)"/', $map_iframe, $matches);
            
            if (!empty($matches[1])) {
                $embed_url = $matches[1];
                $iframe = '<iframe class="map-embed" src="' . htmlspecialchars($embed_url) . '" allowfullscreen="" loading="lazy" referrerpolicy="no-referrer-when-downgrade" title="Society location map"></iframe>';
            } else {
                // If can't extract URL, return the original iframe as-is
                $iframe = $map_iframe;
            }
        }
        
        return $iframe;
    }


    // FETCHING COMMITTEE MEMBERS FUNCTIONS
    function fetch_committee_members($display_type = null, $limit = null) {
        global $con;
        
        if (empty($display_type) || $display_type == NULL) {
            echo '<p class="text-muted">Display type is required in Function Call.</p>';
            return;
        }

        if ($display_type === 'homepage') {
            $query = " SELECT * FROM managing_committee 
                WHERE committee_member_status = 'active' 
                ORDER BY committee_member_id DESC
            ";

            if ($limit !== null && is_numeric($limit)) {
                $query .= " LIMIT ?";
            }

            $stmt = mysqli_prepare($con, $query);

            if ($limit !== NULL && is_numeric($limit)) {
                mysqli_stmt_bind_param($stmt, 'i', $limit);
            }

            mysqli_stmt_execute($stmt);
            $result = mysqli_stmt_get_result($stmt);

            if (mysqli_num_rows($result) == 0) {
                echo '<p class="text-muted">No committee members found.</p>';
                return;
            }

            while ($committee_member = mysqli_fetch_assoc($result)) {
                $fullname = htmlspecialchars($committee_member['committee_member_fullname']);
                $salutation = htmlspecialchars($committee_member['committee_member_salutation']);
                $role = htmlspecialchars($committee_member['committee_member_role']);
                $image = htmlspecialchars($committee_member['committee_member_image']);
                
                // Handle image or initial
                if (empty($image) || $image == NULL) {
                    $image_content = strtoupper(substr($fullname, 0, 1));
                } else {
                    $image_content = '<img src="' . get_site_option('dashboard_url') . 'assets/uploads/images/committee_members/' . $image . '" alt="' . $fullname . '" class="team-member-photo-img">';
                }

                $fullname_with_salutation = $salutation . ' ' . $fullname;
                
                echo '
                    <div class="team-member">
                        <div class="team-member-photo">
                            ' . $image_content . '
                        </div>
                        <div class="team-member-name">' . $fullname_with_salutation . '</div>
                        <div class="team-member-position">' . $role . '</div>
                    </div>
                ';
            }
        }

        if ($display_type === 'detailed_grid') {
            $query = " SELECT * FROM managing_committee 
                WHERE committee_member_status = 'active' 
                ORDER BY committee_member_id DESC
            ";

            if ($limit !== null && is_numeric($limit)) {
                $query .= " LIMIT ?";
            }

            $stmt = mysqli_prepare($con, $query);

            if ($limit !== NULL && is_numeric($limit)) {
                mysqli_stmt_bind_param($stmt, 'i', $limit);
            }

            mysqli_stmt_execute($stmt);
            $result = mysqli_stmt_get_result($stmt);

            if (mysqli_num_rows($result) == 0) {
                echo '<p class="text-muted">No committee members found.</p>';
                return;
            }

            while ($committee_member = mysqli_fetch_assoc($result)) {
                $fullname = htmlspecialchars($committee_member['committee_member_fullname']);
                $salutation = htmlspecialchars($committee_member['committee_member_salutation']);
                $role = htmlspecialchars($committee_member['committee_member_role']);
                $image = htmlspecialchars($committee_member['committee_member_image']);
                
                // Handle image or initial
                if (empty($image) || $image == NULL) {
                    $image_content = strtoupper(substr($fullname, 0, 1));
                } else {
                    $image_content = '<img src="' . get_site_option('site_url') . 'assets/images/committee_members/' . $image . '" alt="' . $fullname . '" class="team-member-photo-img">';
                }

                $flat = !empty($committee_member['committee_member_flat']) ? htmlspecialchars($committee_member['committee_member_flat']) : '';
                $phone = !empty($committee_member['committee_member_phone_number']) ? htmlspecialchars($committee_member['committee_member_phone_number']) : '';
                $email = !empty($committee_member['committee_member_email_address']) ? htmlspecialchars($committee_member['committee_member_email_address']) : '';
                $term = !empty($committee_member['committee_member_term']) ? htmlspecialchars(substr($committee_member['committee_member_term'], 0, 4) . " - " . substr($committee_member['committee_member_term'], 9, 2)) : '';
                
                // Extract wing from flat (e.g., "A" from "A-101")
                $wing = '';
                if (!empty($flat) && preg_match('/^([A-Z])-/', $flat, $matches)) {
                    $wing = $matches[1];
                }
                
                // Get initials for avatar
                $name_parts = explode(' ', $fullname);
                $initials = '';
                foreach ($name_parts as $part) {
                    if (!empty($part)) {
                        $initials .= strtoupper(substr($part, 0, 1));
                    }
                }
                $initials = substr($initials, 0, 2);
                
                $fullname_with_salutation = $salutation . ' ' . $fullname;
                
                echo '
                    <div class="member-card">
                        <div class="member-header">
                            <div class="member-avatar" aria-hidden="true">' . $initials . '</div>
                            <div class="member-info">
                                <div class="member-name">' . $fullname_with_salutation . '</div>';
                
                // Only show flat if it exists
                if (!empty($flat)) {
                    echo '<div class="member-flat">Flat ' . $flat . '</div>';
                }
                
                echo '
                            </div>
                        </div>
                        <div class="member-position">' . $role . '</div>
                        <div class="member-details">';
                
                // Only show phone if it exists
                if (!empty($phone)) {
                    echo '
                            <div class="member-detail-item">
                                <span class="member-detail-icon"><i class="fas fa-phone"></i></span>
                                <span>' . $phone . '</span>
                            </div>';
                }
                
                // Only show email if it exists
                if (!empty($email)) {
                    echo '
                            <div class="member-detail-item">
                                <span class="member-detail-icon"><i class="fas fa-envelope"></i></span>
                                <span>' . $email . '</span>
                            </div>';
                }
                
                // Only show wing if it exists
                if (!empty($wing)) {
                    echo '
                            <div class="member-detail-item">
                                <span class="member-detail-icon"><i class="fas fa-building"></i></span>
                                <span>Block ' . $wing . '</span>
                            </div>';
                }
                
                echo '
                        </div>
                        <div class="member-badges">';
                
                // Only show term badge if term exists
                if (!empty($term)) {
                    echo '<span class="member-badge badge-term">Term ' . $term . '</span>';
                }
                
                echo '
                            <span class="member-badge badge-active">Active</span>
                        </div>
                    </div>
                ';
            }
        }

        if ($display_type === 'aboutpage') {
            $query = " SELECT * FROM managing_committee 
                WHERE committee_member_status = 'active' 
                ORDER BY committee_member_id DESC
            ";

            if ($limit !== null && is_numeric($limit)) {
                $query .= " LIMIT ?";
            }

            $stmt = mysqli_prepare($con, $query);

            if ($limit !== NULL && is_numeric($limit)) {
                mysqli_stmt_bind_param($stmt, 'i', $limit);
            }

            mysqli_stmt_execute($stmt);
            $result = mysqli_stmt_get_result($stmt);

            if (mysqli_num_rows($result) == 0) {
                echo '<p class="text-muted">No committee members found.</p>';
                return;
            }

            while ($committee_member = mysqli_fetch_assoc($result)) {
                $fullname = htmlspecialchars($committee_member['committee_member_fullname']);
                $salutation = htmlspecialchars($committee_member['committee_member_salutation']);
                $role = htmlspecialchars($committee_member['committee_member_role']);
                $image = htmlspecialchars($committee_member['committee_member_image']);
                
                // Handle image or initial
                if (empty($image) || $image == NULL) {
                    $image_content = strtoupper(substr($fullname, 0, 1));
                } else {
                    $image_content = '<img src="' . get_site_option('site_url') . 'assets/images/committee_members/' . $image . '" alt="' . $fullname . '" class="team-member-photo-img">';
                }

                $fullname_with_salutation = $salutation . ' ' . $fullname;

                $flat = !empty($committee_member['committee_member_flat']) ? htmlspecialchars($committee_member['committee_member_flat']) : '';
                $phone = !empty($committee_member['committee_member_phone_number']) ? htmlspecialchars($committee_member['committee_member_phone_number']) : '';
                $email = !empty($committee_member['committee_member_email_address']) ? htmlspecialchars($committee_member['committee_member_email_address']) : '';
                $term = !empty($committee_member['committee_member_term']) ? htmlspecialchars(substr($committee_member['committee_member_term'], 0, 4) . " - " . substr($committee_member['committee_member_term'], 9, 2)) : '';
                
                // Extract wing from flat (e.g., "A" from "A-101")
                $wing = '';
                if (!empty($flat) && preg_match('/^([A-Z])-/', $flat, $matches)) {
                    $wing = $matches[1];
                }
                
                echo '
                    <div class="committee-member">
                        <div class="member-avatar" aria-hidden="true">
                            ' . $image_content . '
                        </div>
                        <div class="member-info">
                            <div class="member-name" id="chairman-name">
                                ' . $fullname_with_salutation . '
                            </div>
                            <div class="member-role" id="chairman-role">
                                ' . $role . '
                            </div>';
                    if (!empty($flat)) {
                        echo '
                            <div class="member-contact">
                                Flat No. ' . $flat . ' |
                        ';
                    }
                    echo '
                                Term: ' . $term . '
                            </div>
                        </div>
                    </div>  
                ';
            }
        }


        while ($committee_member = mysqli_fetch_assoc($result)) {
            $fullname = htmlspecialchars($committee_member['committee_member_fullname']);
            $salutation = htmlspecialchars($committee_member['committee_member_salutation']);
            $role = htmlspecialchars($committee_member['committee_member_role']);
            $image = htmlspecialchars($committee_member['committee_member_image']);
            
            // Handle image or initial
            if (empty($image) || $image == NULL) {
                $image_content = strtoupper(substr($fullname, 0, 1));
            } else {
                $image_content = '<img src="' . get_site_option('site_url') . 'assets/images/committee_members/' . $image . '" alt="' . $fullname . '" class="team-member-photo-img">';
            }

            switch ($display_type) {
                case 'detailed_grid':
                    // For committee members page
                    $flat = !empty($committee_member['committee_member_flat']) ? htmlspecialchars($committee_member['committee_member_flat']) : '';
                    $phone = !empty($committee_member['committee_member_phone_number']) ? htmlspecialchars($committee_member['committee_member_phone_number']) : '';
                    $email = !empty($committee_member['committee_member_email_address']) ? htmlspecialchars($committee_member['committee_member_email_address']) : '';
                    $term = !empty($committee_member['committee_member_term']) ? htmlspecialchars(substr($committee_member['committee_member_term'], 0, 4) . " - " . substr($committee_member['committee_member_term'], 9, 2)) : '';
                    
                    // Extract wing from flat (e.g., "A" from "A-101")
                    $wing = '';
                    if (!empty($flat) && preg_match('/^([A-Z])-/', $flat, $matches)) {
                        $wing = $matches[1];
                    }
                    
                    // Get initials for avatar
                    $name_parts = explode(' ', $fullname);
                    $initials = '';
                    foreach ($name_parts as $part) {
                        if (!empty($part)) {
                            $initials .= strtoupper(substr($part, 0, 1));
                        }
                    }
                    $initials = substr($initials, 0, 2);
                    
                    $fullname_with_salutation = $salutation . ' ' . $fullname;
                    
                    echo '
                        <div class="member-card">
                            <div class="member-header">
                                <div class="member-avatar" aria-hidden="true">' . $initials . '</div>
                                <div class="member-info">
                                    <div class="member-name">' . $fullname_with_salutation . '</div>';
                    
                    // Only show flat if it exists
                    if (!empty($flat)) {
                        echo '<div class="member-flat">Flat ' . $flat . '</div>';
                    }
                    
                    echo '
                                </div>
                            </div>
                            <div class="member-position">' . $role . '</div>
                            <div class="member-details">';
                    
                    // Only show phone if it exists
                    if (!empty($phone)) {
                        echo '
                                <div class="member-detail-item">
                                    <span class="member-detail-icon"><i class="fas fa-phone"></i></span>
                                    <span>' . $phone . '</span>
                                </div>';
                    }
                    
                    // Only show email if it exists
                    if (!empty($email)) {
                        echo '
                                <div class="member-detail-item">
                                    <span class="member-detail-icon"><i class="fas fa-envelope"></i></span>
                                    <span>' . $email . '</span>
                                </div>';
                    }
                    
                    // Only show wing if it exists
                    if (!empty($wing)) {
                        echo '
                                <div class="member-detail-item">
                                    <span class="member-detail-icon"><i class="fas fa-building"></i></span>
                                    <span>Block ' . $wing . '</span>
                                </div>';
                    }
                    
                    echo '
                            </div>
                            <div class="member-badges">';
                    
                    // Only show term badge if term exists
                    if (!empty($term)) {
                        echo '<span class="member-badge badge-term">Term ' . $term . '</span>';
                    }
                    
                    echo '
                                <span class="member-badge badge-active">Active</span>
                            </div>
                        </div>
                    ';
                    break;
                
                default:
                    echo '<p class="text-muted">Invalid display type specified.</p>';
                    break;
            }
        }
    }

    // Get unique wings for filter dropdown
    function get_unique_wings($status = 'active') {
        global $con;
        
        $query = "SELECT DISTINCT committee_member_flat 
                  FROM managing_committee 
                  WHERE committee_member_status = ? 
                  AND committee_member_flat IS NOT NULL 
                  AND committee_member_flat != ''
                  ORDER BY committee_member_flat ASC";
        
        $stmt = mysqli_prepare($con, $query);
        mysqli_stmt_bind_param($stmt, 's', $status);
        mysqli_stmt_execute($stmt);
        $result = mysqli_stmt_get_result($stmt);
        
        $wings = [];
        while ($row = mysqli_fetch_assoc($result)) {
            $flat = $row['committee_member_flat'];
            // Extract wing letter (e.g., "A" from "A-101")
            if (preg_match('/^([A-Z])-/', $flat, $matches)) {
                $wing = $matches[1];
                if (!in_array($wing, $wings)) {
                    $wings[] = $wing;
                }
            }
        }
        
        sort($wings);
        return $wings;
    }

    function get_total_numbers($table_name, $status_column = null, $status_value = null) {
        global $con;

        $query = "SELECT COUNT(*) AS total FROM $table_name";

        if ($status_column !== null && $status_value !== null) {
            // Check if status_value is an array (multiple values)
            if (is_array($status_value)) {
                $placeholders = implode(',', array_fill(0, count($status_value), '?'));
                $query .= " WHERE $status_column IN ($placeholders)";
                $stmt = mysqli_prepare($con, $query);
                
                // Dynamically bind parameters
                $types = str_repeat('s', count($status_value));
                mysqli_stmt_bind_param($stmt, $types, ...$status_value);
            } else {
                // Single value
                $query .= " WHERE $status_column = ?";
                $stmt = mysqli_prepare($con, $query);
                mysqli_stmt_bind_param($stmt, 's', $status_value);
            }
        } else {
            $stmt = mysqli_prepare($con, $query);
        }

        mysqli_stmt_execute($stmt);
        $result = mysqli_stmt_get_result($stmt);
        $row = mysqli_fetch_assoc($result);

        return $row['total'];
    }



    // FETCHING NOTICES/ANNOUNCEMENTS/CIRCULARS/ETC. FUNCTIONS
    function fetch_notice($display_type = null, $status = 'published', $order_by = 'notice_id', $sorting = 'DESC', $limit = null, $archive_only = false) {
        global $con;
        
        if (empty($display_type) || $display_type == NULL) {
            echo '<p class="text-muted">Display type is required in Function Call.</p>';
        }

        if ($display_type === 'homepage') {
            $query = "SELECT n.*, nc.notice_category_name AS notice_category_name FROM notices n
                INNER JOIN notice_categories nc ON n.notice_category = nc.notice_category_id
                WHERE n.notice_status = ? AND nc.notice_category_status = 'active'";

            if ($archive_only === true) {
                $query .= " AND n.notice_posted_on < DATE_SUB(NOW(), INTERVAL 30 DAY)";
            } else {
                $query .= " AND n.notice_posted_on >= DATE_SUB(NOW(), INTERVAL 30 DAY)";
            }

            $query .= " ORDER BY $order_by $sorting";
            
            if ($limit !== null && is_numeric($limit)) {
                $query .= " LIMIT ?";
            }

            $stmt = mysqli_prepare($con, $query);

            if ($limit !== null && is_numeric($limit)) {
                mysqli_stmt_bind_param($stmt, 'si', $status, $limit);
            } else {
                mysqli_stmt_bind_param($stmt, 's', $status);
            }

            mysqli_stmt_execute($stmt);
            $result = mysqli_stmt_get_result($stmt);

            if (mysqli_num_rows($result) == 0) {
                echo '<p class="text-muted">No notices found.</p>';
            }

            while ($notice = mysqli_fetch_assoc($result)) {
                $notice_id = $notice['notice_id'];
                $notice_number = htmlspecialchars($notice['notice_number']);
                $notice_title = htmlspecialchars($notice['notice_title']);
                $notice_category = htmlspecialchars($notice['notice_category_name']);
                $notice_badge = htmlspecialchars($notice['notice_badge']);
                $notice_date = date('d M, Y', strtotime($notice['notice_posted_on']));
                $notice_single_line = htmlspecialchars($notice['notice_single_line']);
                $notice_excerpt = nl2br(htmlspecialchars($notice['notice_excerpt']));
                $notice_file = htmlspecialchars($notice['notice_material']);
                    if (!empty($notice_file) && $notice_file != NULL) {
                        $download_url = get_site_option('dashboard_url') . 'assets/uploads/documents/notices/' . $notice_file;
                        $have_file = "<a href='$download_url' class='announcement-btn' download>Download</a>";
                    } else {
                        $download_url = 'javascript:void(0);';
                        $have_file = "";
                    }

                echo "
                    <li class='announcement-item'>
                        <div class='announcement-header'>
                            <div class='announcement-main'>
                                <div class='announcement-title'>
                                    $notice_title
                                </div>
                                <div class='announcement-meta'>
                                    Published on $notice_date • $notice_single_line
                                </div>
                            </div>
                            <span class='announcement-badge'>$notice_category</span>
                        </div>
                        <div class='announcement-actions'>
                            <a href='./notice-details/?notice_id=$notice_id' class='announcement-btn'>Read More</a>
                            $have_file
                        </div>
                    </li>
                ";
            }
        }

        if ($display_type === 'list_view') {
            $query = "SELECT n.*, nc.notice_category_name AS notice_category_name FROM notices n
                INNER JOIN notice_categories nc ON n.notice_category = nc.notice_category_id
                WHERE n.notice_status = ? AND nc.notice_category_status = 'active'";

            if ($archive_only === true) {
                $query .= " AND n.notice_posted_on < DATE_SUB(NOW(), INTERVAL 30 DAY)";
            } else {
                $query .= " AND n.notice_posted_on >= DATE_SUB(NOW(), INTERVAL 30 DAY)";
            }

            $query .= " ORDER BY $order_by $sorting";
            
            if ($limit !== null && is_numeric($limit)) {
                $query .= " LIMIT ?";
            }

            $stmt = mysqli_prepare($con, $query);

            if ($limit !== null && is_numeric($limit)) {
                mysqli_stmt_bind_param($stmt, 'si', $status, $limit);
            } else {
                mysqli_stmt_bind_param($stmt, 's', $status);
            }

            mysqli_stmt_execute($stmt);
            $result = mysqli_stmt_get_result($stmt);

            if (mysqli_num_rows($result) == 0) {
                echo '<p class="text-muted">No notices found.</p>';
            }

            while ($notice = mysqli_fetch_assoc($result)) {
                $notice_id = $notice['notice_id'];
                $notice_number = htmlspecialchars($notice['notice_number']);
                $notice_title = htmlspecialchars($notice['notice_title']);
                $notice_category = htmlspecialchars($notice['notice_category_name']);
                $notice_badge = htmlspecialchars($notice['notice_badge']);
                $notice_date = date('d M, Y', strtotime($notice['notice_posted_on']));
                $notice_single_line = htmlspecialchars($notice['notice_single_line']);
                $notice_excerpt = nl2br(htmlspecialchars($notice['notice_excerpt']));
                $notice_file = htmlspecialchars($notice['notice_material']);
                    if (!empty($notice_file) && $notice_file != NULL) {
                        $download_url = get_site_option('dashboard_url') . 'assets/uploads/documents/notices/' . $notice_file;
                        $have_file = "<a href='$download_url' class='notice-btn' role='button' download><i class='fas fa-download'></i> Download PDF</a>";
                    } else {
                        $download_url = 'javascript:void(0);';
                        $have_file = "";
                    }
                $download_link_html = !empty($download_url) ? "<a href='$download_url' class='announcement-btn' download>Download</a>" : '';

                echo "
                    <article class='notice-card' data-category='" . strtolower($notice_category) . "' data-keywords='$notice_title $notice_single_line $notice_excerpt $notice_number $notice_date $notice_category'>
                        <div class='notice-header'>
                            <div class='notice-title-group'>
                                <a href='" . get_site_option('site_url') . "notice-details/?notice_id=$notice_id' class='notice-title-link' style='text-decoration:none;'><h4 class='notice-title' id='notice-1-title' style='cursor:pointer;'>$notice_title</h4></a>
                                <div class='notice-meta'>
                                    <span class='notice-meta-item'><i class='fas fa-calendar-alt'></i> Published: $notice_date</span>
                                    <span class='notice-meta-item'><i class='fas fa-user'></i> Issued by: Managing Committee</span>
                                    <span class='notice-meta-item'><i class='fas fa-file-alt'></i> Notice No: $notice_number</span>
                                </div>
                            </div>
                            <div class='notice-badges'>
                                <span class='notice-badge badge-meeting'>$notice_category</span>
                                ";
                                if ($notice_badge !== null && !empty($notice_badge)) {
                                    echo "
                                        <span class='notice-badge'>$notice_badge</span>
                                    ";
                                }
                                echo "
                            </div>
                        </div>
                        <div class='notice-content'>
                            $notice_excerpt
                        </div>
                        <div class='notice-actions'>
                            <a href='" . get_site_option('site_url') . "notice-details/?notice_id=$notice_id' class='notice-btn' role='button'><i class='fas fa-clipboard-list'></i> View Full Details</a>
                            $have_file
                        </div>
                    </article>
                ";
            }
        }

        if ($display_type === 'notices-management') {
            $query = "SELECT n.*, nc.notice_category_name AS notice_category_name, om.office_member_salutation, om.office_member_fullname FROM notices n
                INNER JOIN notice_categories nc ON n.notice_category = nc.notice_category_id
                LEFT JOIN office_members om ON n.notice_posted_by = om.office_member_unique_id
                WHERE n.notice_status != 'deleted' ORDER BY $order_by $sorting";

            $stmt = mysqli_prepare($con, $query);
            mysqli_stmt_execute($stmt);
            $result = mysqli_stmt_get_result($stmt);

            if (mysqli_num_rows($result) <= 0) {
                echo "
                    <tr class='table-empty'>
                        <td class='text-center text-muted'>—</td>
                        <td class='text-muted'>No notices found.</td>
                        <td class='text-muted'>&nbsp;</td>
                        <td class='text-muted'>&nbsp;</td>
                        <td class='text-muted'>&nbsp;</td>
                        <td class='text-muted'>&nbsp;</td>
                    </tr>
                ";
            } else {
                $i = 0;
                while ($notice = mysqli_fetch_assoc($result)) {
                    $i++;
                    $notice_id = $notice['notice_id'];
                    $notice_number = htmlspecialchars($notice['notice_number']);
                        if (strlen($notice_number) > 15) {
                            $notice_number_display = '...' . substr($notice_number, -12);
                        } else {
                            $notice_number_display = $notice_number;
                        }
                    $notice_title = htmlspecialchars($notice['notice_title']);
                        if (strlen($notice_title) > 50) {
                            $notice_title_display = substr($notice_title, 0, 47) . '...';
                        } else {
                            $notice_title_display = $notice_title;
                        }
                    $notice_category = htmlspecialchars($notice['notice_category_name']);
                    $notice_badge = !empty(htmlspecialchars($notice['notice_badge'])) ? htmlspecialchars($notice['notice_badge']) : 'N/A';
                    $notice_status = htmlspecialchars($notice['notice_status']);
                        if ($notice_status === 'published') {
                            $notice_status_badge = "
                                <button class='bg-success-focus text-success-main px-24 py-4 rounded-pill fw-medium text-sm' onclick=\"confirmStatusChange('notices', 'notice_id', $notice_id, 'notice_status', 'draft', 'notice_updated_on')\"> " . ucwords(strtolower($notice_status)) . "</button>
                            ";
                        } elseif ($notice_status === 'draft') {
                            $notice_status_badge = "
                                <button class='bg-warning-focus text-warning-main px-24 py-4 rounded-pill fw-medium text-sm' onclick=\"confirmStatusChange('notices', 'notice_id', $notice_id, 'notice_status', 'published', 'notice_updated_on')\"> " . ucwords(strtolower($notice_status)) . "</button>
                            ";
                        }
                    
                    $notice_posted_by_id = htmlspecialchars($notice['notice_posted_by']);
                    $notice_posted_by_salutation = ucwords(strtolower($notice['office_member_salutation']));
                    $notice_posted_by_fullname = ucwords(strtolower($notice['office_member_fullname']));
                    $notice_posted_by_name = $notice_posted_by_salutation . ' ' . $notice_posted_by_fullname;

                    $notice_posted_on = date('d M, Y h:i A', strtotime($notice['notice_posted_on']));
                    $notice_single_line = htmlspecialchars($notice['notice_single_line']);
                    $notice_content = $notice['notice_content'];
                    $notice_excerpt = htmlspecialchars($notice['notice_excerpt']);
                    $notice_updated_on = $notice['notice_updated_on'];
                        if (!empty($notice_updated_on) || $notice_updated_on !== NULL) {
                            $notice_updated_on = date('d M, Y h:i A', strtotime($notice['notice_updated_on']));
                        } else {
                            $notice_updated_on = 'N/A';
                        }

                    $notice_material_title = htmlspecialchars($notice['notice_material_title']);
                    $notice_material = htmlspecialchars($notice['notice_material']);

                    echo "
                        <tr>
                            <td class='text-center'>
                                $i
                            </td>
                            <td>$notice_number_display</td>
                            <td>$notice_title_display</td>
                            <td>$notice_category</td>
                            <td>$notice_status_badge</td>
                            <td>
                                <a href='javascript:void(0)' class='w-32-px h-32-px bg-primary-light text-primary-600 rounded-circle d-inline-flex align-items-center justify-content-center' data-bs-toggle='modal' data-bs-target='#viewNoticeModal$notice_id'>
                                    <iconify-icon icon='iconamoon:eye-light'></iconify-icon>
                                </a>

                                <!--- View Notice Modal -->
                                <div class='modal fade' id='viewNoticeModal$notice_id' tabindex='-1' aria-labelledby='viewNoticeModalLabel$notice_id' aria-hidden='true'>
                                    <div class='modal-dialog modal-lg modal-dialog-centered'>
                                        <div class='modal-content'>
                                            <div class='modal-header'>
                                                <h5 class='modal-title' id='viewNoticeModalLabel$notice_id'>Notice Details</h5>
                                                <button type='button' class='btn-close' data-bs-dismiss='modal' aria-label='Close'></button>
                                            </div>
                                            <div class='modal-body'>
                                                <div class='row'>
                                                    <div class='col-md-2'>
                                                        <div class='mb-3'>
                                                            <label for='noticeID' class='form-label'>ID:</label>
                                                            <input type='text' readonly value='$notice_id' class='form-control' />
                                                        </div>
                                                    </div>
                                                    <div class='col-md-6'>
                                                        <div class='mb-3'>
                                                            <label for='noticePostedBy' class='form-label'>Posted By:</label>
                                                            <input type='text' readonly value='$notice_posted_by_name ($notice_posted_by_id)' class='form-control' />
                                                        </div>
                                                    </div>
                                                    <div class='col-md-4'>
                                                        <div class='mb-3'>
                                                            <label for='noticePostedOn' class='form-label'>Posted On:</label>
                                                            <input type='text' readonly value='$notice_posted_on' class='form-control' />
                                                        </div>
                                                    </div>
                                                    <div class='col-md-6'>
                                                        <div class='mb-3'>
                                                            <label for='noticeTitle' class='form-label'>Title:</label>
                                                            <textarea id='noticeTitle' class='form-control' rows='2' readonly style='resize: none;'>$notice_title</textarea>
                                                        </div>
                                                    </div>
                                                    <div class='col-md-6'>
                                                        <div class='mb-3'>
                                                            <label for='noticeSingleLine' class='form-label'>Single Line:</label>
                                                            <textarea id='noticeSingleLine' class='form-control' rows='2' readonly style='resize: none;'>$notice_single_line</textarea>
                                                        </div>
                                                    </div>
                                                    <div class='col-md-12'>
                                                        <div class='mb-3'>
                                                            <label for='noticeContent' class='form-label'>Content:</label>
                                                            <textarea id='noticeContent' class='form-control tinymce-editor' readonly>$notice_content</textarea>
                                                        </div>
                                                    </div>
                                                    <div class='col-md-12'>
                                                        <div class='mb-3'>
                                                            <label for='noticeExcerpt' class='form-label'>Excerpt:</label>
                                                            <textarea id='noticeExcerpt' class='form-control' rows='2' readonly style='resize: none;'>$notice_excerpt</textarea>
                                                        </div>
                                                    </div>
                                                    <div class='col-md-3'>
                                                        <div class='mb-3'>
                                                            <label for='noticeCategory' class='form-label'>Category:</label>
                                                            <input type='text' readonly value='$notice_category' class='form-control' />
                                                        </div>
                                                    </div>
                                                    <div class='col-md-4'>
                                                        <div class='mb-3'>
                                                            <label for='noticeBadge' class='form-label'>Badge:</label>
                                                            <input type='text' readonly value='$notice_badge' class='form-control' />
                                                        </div>
                                                    </div>
                                                    <div class='col-md-5'>
                                                        <div class='mb-3'>
                                                            <label for='noticeNumber' class='form-label'>Number:</label>
                                                            <input type='text' readonly value='$notice_number' class='form-control' />
                                                        </div>
                                                    </div>
                                                    <div class='col-md-3'>
                                                        <div class='mb-3'>
                                                            <label for='noticeUpdatedOn' class='form-label'>Updated On:</label>
                                                            <input type='text' readonly value='$notice_updated_on' class='form-control' />
                                                        </div>
                                                    </div>
                                                    <div class='col-md-3'>
                                                        <div class='mb-3'>
                                                            <label for='noticeStatus' class='form-label'>Status:</label>
                                                            <input type='text' readonly value='" . ucwords($notice_status) . "' class='form-control' />
                                                        </div>
                                                    </div>
                                                    <div class='col-md-3'>
                                                        <div class='mb-3'>
                                                            <label for='noticeMaterialTitle' class='form-label'>Material Title:</label>
                                                            <input type='text' readonly value='$notice_material_title' class='form-control' />
                                                        </div>
                                                    </div>
                                                    <div class='col-md-3'>
                                                        <div class='mb-3'>
                                                            <label for='noticeMaterial' class='form-label'>Material:</label>
                                                            <br>
                                                            <a href='" . get_site_option('dashboard_url') . "assets/uploads/documents/notices/$notice_material' target='_blank' class='btn btn-primary'>
                                                                View Document
                                                            </a>
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>
                                            <div class='modal-footer d-flex justify-content-between'>
                                                <div>";
                                                    if ($notice_status === 'published') {
                                                        echo "
                                                            <button type='button' class='btn btn-warning' onclick=\"confirmStatusChange('notices', 'notice_id', $notice_id, 'notice_status', 'draft', 'notice_updated_on')\">
                                                                <i class='ri-draft-line'></i> Mark as Draft
                                                            </button>
                                                        ";
                                                    } elseif ($notice_status === 'draft') {
                                                        echo "
                                                            <button type='button' class='btn btn-success' onclick=\"confirmStatusChange('notices', 'notice_id', $notice_id, 'notice_status', 'published', 'notice_updated_on')\">
                                                                <i class='ri-checkbox-circle-line'></i> Mark as Published
                                                            </button>
                                                        ";
                                                    }
                                                    echo "
                                                    <button type='button' class='btn btn-danger' onclick=\"confirmStatusChange('notices', 'notice_id', $notice_id, 'notice_status', 'deleted', 'notice_updated_on')\">
                                                        <i class='ri-delete-bin-line'></i> Delete
                                                    </button>
                                                </div>
                                                <button type='button' class='btn btn-outline-secondary' data-bs-dismiss='modal'>Close</button>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                                

                                <a href='" . get_site_option('dashboard_url') . "?page=edit-notice&notice_id=$notice_id' class='w-32-px h-32-px bg-success-focus text-success-main rounded-circle d-inline-flex align-items-center justify-content-center'>
                                    <iconify-icon icon='lucide:edit'></iconify-icon>
                                </a>

                                <a href='javascript:void(0);' class='w-32-px h-32-px bg-danger-focus text-danger-main rounded-circle d-inline-flex align-items-center justify-content-center' onclick=\"confirmStatusChange('notices', 'notice_id', $notice_id, 'notice_status', 'deleted', 'notice_updated_on')\">
                                    <iconify-icon icon='mingcute:delete-2-line'></iconify-icon>
                                </a>
                            </td>
                        </tr>
                    ";
                }
            }
        }
    }

    // Fetch single notice details
    function fetch_single_notice($notice_id) {
        global $con;

        $stmt = mysqli_prepare($con, "SELECT n.*, nc.notice_category_name AS notice_category_name FROM notices n
            INNER JOIN notice_categories nc ON n.notice_category = nc.notice_category_id
            WHERE n.notice_id = ? AND n.notice_status = 'published' AND nc.notice_category_status = 'active' LIMIT 1");
        mysqli_stmt_bind_param($stmt, 'i', $notice_id);
        mysqli_stmt_execute($stmt);
        $result = mysqli_stmt_get_result($stmt);
        $notice = mysqli_fetch_assoc($result);

        if (!$notice) {
            return null;
        }

        return $notice;
    }

    // Fetch Additional Attachments for a Notice
    function fetch_additional_attachments($type, $notice_id) {
        global $con;

        $type = "add_attachment_" . strtolower($type) . "_id";

        $stmt = mysqli_prepare($con, "SELECT * FROM additional_attachments WHERE $type = ?");
        mysqli_stmt_bind_param($stmt, 'i', $notice_id);
        mysqli_stmt_execute($stmt);
        $result = mysqli_stmt_get_result($stmt);

        if (mysqli_num_rows($result) > 0) {
            while ($attachment = mysqli_fetch_assoc($result)) {
                $attachment_id = $attachment['add_attachment_id'];
                $attachment_title = htmlspecialchars($attachment['add_attachment_title']);
                $attachment_material = htmlspecialchars($attachment['add_attachment_material']);
                $attachment_download_url = !empty($attachment_material) ? get_site_option('site_url') . 'assets/documents/' . $attachment_material : '';

                echo "
                    <a href='$attachment_download_url' class='btn-action btn-secondary' download>
                        <span><i class='fas fa-file-alt'></i></span>
                        <span>$attachment_title</span>
                    </a>
                ";
            }
        }
    }

    // Related notices
    function fetch_related_notices($current_notice_id, $limit = 3) {
        global $con;

        $stmt = mysqli_prepare($con, "SELECT n.*, nc.notice_category_name AS notice_category_name FROM notices n
            INNER JOIN notice_categories nc ON n.notice_category = nc.notice_category_id
            WHERE n.notice_status = 'published' AND n.notice_category = ? AND n.notice_id != ?
            ORDER BY n.notice_posted_on DESC LIMIT ?");
        mysqli_stmt_bind_param($stmt, 'iii', $category_id, $current_notice_id, $limit);
        mysqli_stmt_execute($stmt);
        $result = mysqli_stmt_get_result($stmt);

        if (mysqli_num_rows($result) == 0) {
            return '<p class="text-muted">No related notices found.</p>';
        }

        while ($notice = mysqli_fetch_assoc($result)) {
            $notice_id = $notice['notice_id'];
            $notice_title = htmlspecialchars($notice['notice_title']);

            echo "
                <li class='related-item'>
                    <a href='" . get_site_option('site_url') . "notice-details/?notice_id=$notice_id' class='related-link'>
                        <span class='related-icon'><i class='fas fa-clipboard-check'></i></span>
                        <span class='related-text'>$notice_title</span>
                        <span class='related-arrow'><i class='fas fa-arrow-right'></i></span>
                    </a>
                </li>
            ";
        }
    }



    // FETCHING AGBMS FUNCTIONS
    function fetch_agbm($display_type = null, $status = 'published', $order_by = 'agbm_id', $sorting = 'DESC', $limit = null, $archive_only = false) {
        global $con;
        
        if (empty($display_type) || $display_type == NULL) {
            echo '<p class="text-muted">Display type is required in Function Call.</p>';
        }

        if ($display_type === 'homepage') {
            $query = "SELECT * FROM agbms WHERE agbm_status = ?";

            if ($archive_only === true) {
                $query .= " AND agbm_posted_on < DATE_SUB(NOW(), INTERVAL 1 YEAR)";
            } else {
                $query .= " AND agbm_posted_on >= DATE_SUB(NOW(), INTERVAL 1 YEAR)";
            }

            $query .= " ORDER BY $order_by $sorting";
            
            if ($limit !== null && is_numeric($limit)) {
                $query .= " LIMIT ?";
            }

            $stmt = mysqli_prepare($con, $query);

            if ($limit !== null && is_numeric($limit)) {
                mysqli_stmt_bind_param($stmt, 'si', $status, $limit);
            } else {
                mysqli_stmt_bind_param($stmt, 's', $status);
            }

            mysqli_stmt_execute($stmt);
            $result = mysqli_stmt_get_result($stmt);

            if (mysqli_num_rows($result) == 0) {
                echo '<p class="text-muted">No AGBMs found.</p>';
            }

            while ($agbm = mysqli_fetch_assoc($result)) {
                $agbm_id = $agbm['agbm_id'];
                $agbm_number = htmlspecialchars($agbm['agbm_number']);
                $agbm_title = htmlspecialchars($agbm['agbm_title']);
                $agbm_date = date('d M, Y', strtotime($agbm['agbm_posted_on']));
                $agbm_single_line = htmlspecialchars($agbm['agbm_single_line']);
                $agbm_excerpt = nl2br(htmlspecialchars($agbm['agbm_excerpt']));
                $agbm_file = htmlspecialchars($agbm['agbm_material']);
                    if (!empty($agbm_file) || $agbm_file !== NULL) {
                        $download_url = get_site_option('dashboard_url') . 'assets/uploads/documents/agbms/' . $agbm_file;
                        $have_material = "<a href='$download_url' class='notice-btn' role='button' download><i class='fas fa-download'></i> Download PDF</a>";
                    } else {
                        $download_url = 'javascript:void(0);';
                        $have_material = "";
                    }
                
                echo "
                    <li class='announcement-item'>
                        <div class='announcement-header'>
                            <div class='announcement-main'>
                                <div class='announcement-title'>
                                    $agbm_title
                                </div>
                                <div class='announcement-meta'>
                                    Published on $agbm_date • $agbm_single_line
                                </div>
                            </div>
                        </div>
                        <div class='announcement-actions'>
                            <a href='./notice-details/?notice_id=$agbm_id' class='announcement-btn'>Read More</a>
                            $have_material
                        </div>
                    </li>
                ";
            }
        }

        if ($display_type === 'list_view') {
            $query = "SELECT * FROM agbms WHERE agbm_status = ?";

            if ($archive_only === true) {
                $query .= " AND agbm_posted_on < DATE_SUB(NOW(), INTERVAL 1 YEAR)";
            } else {
                $query .= " AND agbm_posted_on >= DATE_SUB(NOW(), INTERVAL 1 YEAR)";
            }

            $query .= " ORDER BY $order_by $sorting";
            
            if ($limit !== null && is_numeric($limit)) {
                $query .= " LIMIT ?";
            }

            $stmt = mysqli_prepare($con, $query);

            if ($limit !== null && is_numeric($limit)) {
                mysqli_stmt_bind_param($stmt, 'si', $status, $limit);
            } else {
                mysqli_stmt_bind_param($stmt, 's', $status);
            }

            mysqli_stmt_execute($stmt);
            $result = mysqli_stmt_get_result($stmt);

            if (mysqli_num_rows($result) == 0) {
                echo '<p class="text-muted">No AGBMs found.</p>';
            }

            while ($agbm = mysqli_fetch_assoc($result)) {
                $agbm_id = $agbm['agbm_id'];
                $agbm_number = htmlspecialchars($agbm['agbm_number']);
                $agbm_title = htmlspecialchars($agbm['agbm_title']);
                $agbm_date = date('d M, Y', strtotime($agbm['agbm_posted_on']));
                $agbm_single_line = htmlspecialchars($agbm['agbm_single_line']);
                $agbm_excerpt = nl2br(htmlspecialchars($agbm['agbm_excerpt']));
                $agbm_file = htmlspecialchars($agbm['agbm_material']);
                    if (!empty($agbm_file) || $agbm_file !== NULL) {
                        $download_url = get_site_option('dashboard_url') . 'assets/uploads/documents/agbms/' . $agbm_file;
                        $have_material = "<a href='$download_url' class='notice-btn' role='button' download><i class='fas fa-download'></i> Download PDF</a>";
                    } else {
                        $download_url = 'javascript:void(0);';
                        $have_material = "";
                    }
                echo "
                    <article class='notice-card' data-keywords='$agbm_title $agbm_single_line $agbm_excerpt $agbm_number $agbm_date'>
                        <div class='notice-header'>
                            <div class='notice-title-group'>
                                <a href='" . get_site_option('site_url') . "agbm-details/?agbm_id=$agbm_id' class='notice-title-link' style='text-decoration:none;'><h4 class='notice-title' id='notice-1-title' style='cursor:pointer;'>$agbm_title</h4></a>
                                <div class='notice-meta'>
                                    <span class='notice-meta-item'><i class='fas fa-calendar-alt'></i> Published: $agbm_date</span>
                                    <span class='notice-meta-item'><i class='fas fa-user'></i> Issued by: Managing Committee</span>
                                    <span class='notice-meta-item'><i class='fas fa-file-alt'></i> Notice No: $agbm_number</span>
                                </div>
                            </div>
                        </div>
                        <div class='notice-content'>
                            $agbm_excerpt
                        </div>
                        <div class='notice-actions'>
                            <a href='" . get_site_option('site_url') . "agbm-details/?agbm_id=$agbm_id' class='notice-btn' role='button'><i class='fas fa-clipboard-list'></i> View Full Details</a>
                            $have_material
                        </div>
                    </article>
                ";
            }
        }

        if ($display_type === 'agbms-management') {
            $query = "SELECT a.*, om.* FROM agbms a
                LEFT JOIN office_members om ON a.agbm_posted_by = om.office_member_unique_id
                WHERE a.agbm_status != 'deleted' ORDER BY $order_by $sorting";

            $stmt = mysqli_prepare($con, $query);
            mysqli_stmt_execute($stmt);
            $result = mysqli_stmt_get_result($stmt);

            if (mysqli_num_rows($result) <= 0) {
                echo "
                    <tr class='table-empty'>
                        <td class='text-center text-muted'>—</td>
                        <td class='text-muted'>No AGBMs found.</td>
                        <td class='text-muted'>&nbsp;</td>
                        <td class='text-muted'>&nbsp;</td>
                        <td class='text-muted'>&nbsp;</td>
                        <td class='text-muted'>&nbsp;</td>
                    </tr>
                ";
            } else {
                $i = 0;
                while($agbm = mysqli_fetch_assoc($result)) {
                    $i++;
                    $agbm_id = $agbm['agbm_id'];
                    $agbm_number = htmlspecialchars($agbm['agbm_number']);
                        if (strlen($agbm_number) > 15) {
                            $agbm_number_display = '...' . substr($agbm_number, -12);
                        } else {
                            $agbm_number_display = $agbm_number;
                        }

                    $agbm_title = htmlspecialchars($agbm['agbm_title']);
                        if (strlen($agbm_title) > 50) {
                            $notice_title_display = substr($agbm_title, 0, 47) . '...';
                        } else {
                            $notice_title_display = $agbm_title;
                        }

                    $agbm_material = htmlspecialchars($agbm['agbm_material']);
                        if (!empty($agbm_material) || $agbm_material !== NULL) {
                            $agbm_material_display = "
                                <a href='" . get_site_option('dashboard_url') . "assets/uploads/documents/agbms/$agbm_material' class='btn btn-primary btn-sm' target='_blank'>
                                    <iconify-icon icon='clarity:pop-out-line'></iconify-icon>
                                </a>
                            ";
                        } else {
                            $agbm_material_display = "N/A";
                        }
                    
                    $agbm_status = htmlspecialchars($agbm['agbm_status']);
                        if ($agbm_status === 'published') {
                            $agbm_status_badge = "
                                <button class='bg-success-focus text-success-main px-24 py-4 rounded-pill fw-medium text-sm' onclick=\"confirmStatusChange('agbms', 'agbm_id', $agbm_id, 'agbm_status', 'draft', 'agbm_updated_on')\"> " . ucwords(strtolower($agbm_status)) . "</button>
                            ";
                        } elseif ($agbm_status === 'draft') {
                            $agbm_status_badge = "
                                <button class='bg-warning-focus text-warning-main px-24 py-4 rounded-pill fw-medium text-sm' onclick=\"confirmStatusChange('agbms', 'agbm_id', $agbm_id, 'agbm_status', 'published', 'agbm_updated_on')\"> " . ucwords(strtolower($agbm_status)) . "</button>
                            ";
                        }

                    $agbm_posted_by_id = htmlspecialchars($agbm['agbm_posted_by']);
                    $agbm_posted_by_salutation = ucwords(strtolower($agbm['office_member_salutation']));
                    $agbm_posted_by_fullname = ucwords(strtolower($agbm['office_member_fullname']));
                    $agbm_posted_by_name = $agbm_posted_by_salutation . ' ' . $agbm_posted_by_fullname;

                    $agbm_posted_on = date('d M, Y h:i A', strtotime($agbm['agbm_posted_on']));
                    $agbm_single_line = htmlspecialchars($agbm['agbm_single_line']);
                    $agbm_video_link = htmlspecialchars($agbm['agbm_video_link']);
                    $agbm_content = $agbm['agbm_content'];
                    $agbm_excerpt = htmlspecialchars($agbm['agbm_excerpt']);
                    $agbm_material_title = htmlspecialchars($agbm['agbm_material_title']);
                    $agbm_updated_on = $agbm['agbm_updated_on'];
                        if (!empty($agbm_updated_on) || $agbm_updated_on !== NULL) {
                            $agbm_updated_on = date('d M, Y h:i A', strtotime($agbm['agbm_updated_on']));
                        } else {
                            $agbm_updated_on = 'N/A';
                        }

                    echo "
                        <tr>
                            <td class='text-center'>
                                $i
                            </td>
                            <td>$agbm_number_display</td>
                            <td>$notice_title_display</td>
                            <td>$agbm_material_display</td>
                            <td>$agbm_status_badge</td>
                            <td>
                                <a href='javascript:void(0)' class='w-32-px h-32-px bg-primary-light text-primary-600 rounded-circle d-inline-flex align-items-center justify-content-center' data-bs-toggle='modal' data-bs-target='#viewAgbmModal$agbm_id'>
                                    <iconify-icon icon='iconamoon:eye-light'></iconify-icon>
                                </a>

                                <!--- View Notice Modal -->
                                <div class='modal fade' id='viewAgbmModal$agbm_id' tabindex='-1' aria-labelledby='viewAgbmModalLabel$agbm_id' aria-hidden='true'>
                                    <div class='modal-dialog modal-lg modal-dialog-centered'>
                                        <div class='modal-content'>
                                            <div class='modal-header'>
                                                <h5 class='modal-title' id='viewAgbmModalLabel$agbm_id'>Annual General Body Meeting Details</h5>
                                                <button type='button' class='btn-close' data-bs-dismiss='modal' aria-label='Close'></button>
                                            </div>
                                            <div class='modal-body'>
                                                <div class='row'>
                                                    <div class='col-md-2'>
                                                        <div class='mb-3'>
                                                            <label for='agbmID' class='form-label'>ID:</label>
                                                            <input type='text' readonly value='$agbm_id' class='form-control' />
                                                        </div>
                                                    </div>
                                                    <div class='col-md-6'>
                                                        <div class='mb-3'>
                                                            <label for='agbmPostedBy' class='form-label'>Posted By:</label>
                                                            <input type='text' readonly value='$agbm_posted_by_name ($agbm_posted_by_id)' class='form-control' />
                                                        </div>
                                                    </div>
                                                    <div class='col-md-4'>
                                                        <div class='mb-3'>
                                                            <label for='agbmPostedOn' class='form-label'>Posted On:</label>
                                                            <input type='text' readonly value='$agbm_posted_on' class='form-control' />
                                                        </div>
                                                    </div>
                                                    <div class='col-md-6'>
                                                        <div class='mb-3'>
                                                            <label for='agbmTitle' class='form-label'>Title:</label>
                                                            <textarea id='agbmTitle' class='form-control' rows='2' readonly style='resize: none;'>$agbm_title</textarea>
                                                        </div>
                                                    </div>
                                                    <div class='col-md-6'>
                                                        <div class='mb-3'>
                                                            <label for='agbmSingleLine' class='form-label'>Single Line:</label>
                                                            <textarea id='agbmSingleLine' class='form-control' rows='2' readonly style='resize: none;'>$agbm_single_line</textarea>
                                                        </div>
                                                    </div>
                                                    <div class='col-md-12'>
                                                        <div class='mb-3'>
                                                            <label for='agbmVideo' class='form-label'>Video:</label>
                                                            <iframe src='$agbm_video_link' width='100%' height='480' allow='autoplay' allowfullscreen='' style='border: 1px solid #ddd; border-radius: 4px;'>
                                                            </iframe>
                                                        </div>
                                                    </div>
                                                    <div class='col-md-12'>
                                                        <div class='mb-3'>
                                                            <label for='agbmContent' class='form-label'>Content:</label>
                                                            <textarea id='agbmContent' class='form-control tinymce-editor' readonly>$agbm_content</textarea>
                                                        </div>
                                                    </div>
                                                    <div class='col-md-12'>
                                                        <div class='mb-3'>
                                                            <label for='agbmExcerpt' class='form-label'>Excerpt:</label>
                                                            <textarea id='agbmExcerpt' class='form-control' rows='2' readonly style='resize: none;'>$agbm_excerpt</textarea>
                                                        </div>
                                                    </div>
                                                    <div class='col-md-6'>
                                                        <div class='mb-3'>
                                                            <label for='agbmMaterialTitle' class='form-label'>Material Title:</label>
                                                            <input type='text' readonly value='$agbm_material_title' class='form-control' />
                                                        </div>
                                                    </div>
                                                    <div class='col-md-3'>
                                                        <div class='mb-3'>
                                                            <label for='agbmMaterial' class='form-label'>Material:</label>
                                                            <br>
                                                            <a href='" . get_site_option('dashboard_url') . "assets/uploads/documents/notices/$agbm_material' target='_blank' class='btn btn-primary'>
                                                                View Document
                                                            </a>
                                                        </div>
                                                    </div>
                                                    <div class='col-md-3'>
                                                        <div class='mb-3'>
                                                            <label for='agbmStatus' class='form-label'>Status:</label>
                                                            <input type='text' readonly value='" . ucwords($agbm_status) . "' class='form-control' />
                                                        </div>
                                                    </div>
                                                    <div class='col-md-6'>
                                                        <div class='mb-3'>
                                                            <label for='agbmNumber' class='form-label'>Number:</label>
                                                            <input type='text' readonly value='$agbm_number' class='form-control' />
                                                        </div>
                                                    </div>
                                                    <div class='col-md-6'>
                                                        <div class='mb-3'>
                                                            <label for='agbmUpdatedOn' class='form-label'>Updated On:</label>
                                                            <input type='text' readonly value='$agbm_updated_on' class='form-control' />
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>
                                            <div class='modal-footer d-flex justify-content-between'>
                                                <div>";
                                                    if ($agbm_status === 'published') {
                                                        echo "
                                                            <button type='button' class='btn btn-warning' onclick=\"confirmStatusChange('agbms', 'agbm_id', $agbm_id, 'agbm_status', 'draft', 'agbm_updated_on')\">
                                                                <i class='ri-draft-line'></i> Mark as Draft
                                                            </button>
                                                        ";
                                                    } elseif ($agbm_status === 'draft') {
                                                        echo "
                                                            <button type='button' class='btn btn-success' onclick=\"confirmStatusChange('agbms', 'agbm_id', $agbm_id, 'agbm_status', 'published', 'agbm_updated_on')\">
                                                                <i class='ri-checkbox-circle-line'></i> Mark as Published
                                                            </button>
                                                        ";
                                                    }
                                                    echo "
                                                    <button type='button' class='btn btn-danger' onclick=\"confirmStatusChange('agbms', 'agbm_id', $agbm_id, 'agbm_status', 'deleted', 'agbm_updated_on')\">
                                                        <i class='ri-delete-bin-line'></i> Delete
                                                    </button>
                                                </div>
                                                <button type='button' class='btn btn-outline-secondary' data-bs-dismiss='modal'>Close</button>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                                

                                <a href='" . get_site_option('dashboard_url') . "?page=edit-agbm&agbm_id=$agbm_id' class='w-32-px h-32-px bg-success-focus text-success-main rounded-circle d-inline-flex align-items-center justify-content-center'>
                                    <iconify-icon icon='lucide:edit'></iconify-icon>
                                </a>

                                <a href='javascript:void(0);' class='w-32-px h-32-px bg-danger-focus text-danger-main rounded-circle d-inline-flex align-items-center justify-content-center' onclick=\"confirmStatusChange('agbms', 'agbm_id', $agbm_id, 'agbm_status', 'deleted', 'agbm_updated_on')\">
                                    <iconify-icon icon='mingcute:delete-2-line'></iconify-icon>
                                </a>
                            </td>
                        </tr>
                    ";
                }
            }
        }
    }

    // Fetch single agbm details
    function fetch_single_agbm($agbm_id) {
        global $con;

        $stmt = mysqli_prepare($con, "SELECT * FROM agbms WHERE agbm_id = ? AND agbm_status = 'published' LIMIT 1");
        mysqli_stmt_bind_param($stmt, 'i', $agbm_id);
        mysqli_stmt_execute($stmt);
        $result = mysqli_stmt_get_result($stmt);
        $agbm = mysqli_fetch_assoc($result);
        if (!$agbm) {
            return null;
        }

        return $agbm;
    }
    
    // Fetch single Member details
    function fetch_single_member($member_email) {
        global $con;

        $stmt = mysqli_prepare($con, "SELECT * FROM members WHERE member_email = ? AND member_status = 'active' LIMIT 0, 1");
        mysqli_stmt_bind_param($stmt, 's', $member_email);
        mysqli_stmt_execute($stmt);
        $result = mysqli_stmt_get_result($stmt);
        $member = mysqli_fetch_assoc($result);
        if (!$member) {
            return null;
        }

        return $member;
    }

    // Format Block and Floor of Member
    function format_block_floor_label($block, $flat) {
        $block = trim((string) $block);
        $flat = trim((string) $flat);

        $ordinal = function (int $n): string {
            $mod100 = $n % 100;
            if ($mod100 >= 11 && $mod100 <= 13) {
                return $n . 'th';
            }

            switch ($n % 10) {
                case 1:
                    return $n . 'st';
                case 2:
                    return $n . 'nd';
                case 3:
                    return $n . 'rd';
                default:
                    return $n . 'th';
            }
        };

        $floorLabel = '';
        if ($flat !== '') {
            $flatDigits = ltrim(preg_replace('/\D+/', '', $flat), '0');
            $firstDigit = $flatDigits !== '' ? (int) substr($flatDigits, 0, 1) : 0;
            if ($firstDigit > 0) {
                $floorLabel = $ordinal($firstDigit) . ' Floor';
            }
        }

        $parts = [];
        if ($block !== '') {
            $parts[] = 'Block ' . htmlspecialchars($block, ENT_QUOTES, 'UTF-8');
        }
        if ($floorLabel !== '') {
            $parts[] = htmlspecialchars($floorLabel, ENT_QUOTES, 'UTF-8');
        }

        $label = implode(', ', $parts);
        return $label !== '' ? $label : 'N/A';
    }

    // BILLS FUNCTIONS
    function load_bills($display_type = null, $order_by = 'bill_id', $sorting = 'DESC', $limit = null) {
        global $con;
        
        if (empty($display_type) || $display_type == NULL) {
            echo '<p class="text-muted">Display type is required in Function Call.</p>';
        }

        if ($display_type === 'bills-management') {
            $query = "SELECT b.*, m.*, om.* FROM bills b
                INNER JOIN members m ON b.bill_for_member = m.member_unique_id
                LEFT JOIN office_members om ON b.bill_added_by = om.office_member_unique_id
                WHERE b.bill_status != 'deleted' AND m.member_status != 'deleted'
                ORDER BY $order_by $sorting";

            if ($limit !== null && is_numeric($limit)) {
                $query .= " LIMIT ?";
            }

            $stmt = mysqli_prepare($con, $query);

            if ($limit !== null && is_numeric($limit)) {
                mysqli_stmt_bind_param($stmt, 'i', $limit);
            }

            mysqli_stmt_execute($stmt);
            $result = mysqli_stmt_get_result($stmt);

            if (mysqli_num_rows($result) <= 0) {
                echo "
                    <tr class='table-empty'>
                        <td class='text-center text-muted'>—</td>
                        <td class='text-muted'>No bills found.</td>
                        <td class='text-muted'>&nbsp;</td>
                        <td class='text-muted'>&nbsp;</td>
                        <td class='text-muted'>&nbsp;</td>
                        <td class='text-muted'>&nbsp;</td>
                    </tr>
                ";
            } else {
                $i = 0;
                while ($bill = mysqli_fetch_assoc($result)) {
                    $i++;
                    $bill_id = $bill['bill_id'];
                    $member_salutation = ucwords(strtolower(htmlspecialchars($bill['member_salutation'])));
                    $member_fullname = ucwords(strtolower(htmlspecialchars($bill['member_fullname'])));
                        if (strlen($member_fullname) > 30) {
                            $member_fullname = substr($member_fullname, 0, 27) . '...';
                        } else {
                            $member_fullname = $member_fullname;
                        }
                    $member_block = htmlspecialchars($bill['member_block']);
                    $member_flat = htmlspecialchars($bill['member_flat_number']);
                        $member_display = "(" . $member_block . "-" . $member_flat . ") " . $member_salutation . " " . $member_fullname;
                    
                    $bill_file = htmlspecialchars($bill['bill_file']);
                    $bill_month = date('F, Y', strtotime($bill['bill_for_month']));
                    $bill_status = htmlspecialchars($bill['bill_status']);
                        if ($bill_status === 'pending') {
                            $bill_status_badge = "
                                <button class='bg-warning-focus text-warning-main px-24 py-4 rounded-pill fw-medium text-sm' onclick=\"confirmStatusChange('bills', 'bill_id', $bill_id, 'bill_status', 'paid', 'bill_updated_on')\"> " . ucwords(strtolower($bill_status)) . "</button>
                            ";
                        } elseif ($bill_status === 'paid') {
                            $bill_status_badge = "
                                <button class='bg-success-focus text-success-main px-24 py-4 rounded-pill fw-medium text-sm' onclick=\"confirmStatusChange('bills', 'bill_id', $bill_id, 'bill_status', 'cancelled', 'bill_updated_on')\"> " . ucwords(strtolower($bill_status)) . "</button>
                            ";
                        } elseif ($bill_status === 'cancelled') {
                            $bill_status_badge = "
                                <button class='bg-secondary-focus text-danger-main px-24 py-4 rounded-pill fw-medium text-sm' onclick=\"confirmStatusChange('bills', 'bill_id', $bill_id, 'bill_status', 'pending', 'bill_updated_on')\"> " . ucwords(strtolower($bill_status)) . "</button>
                            ";
                        }
                    $bill_added_by_id = htmlspecialchars($bill['bill_added_by']);
                    $bill_added_by_salutation = ucwords(strtolower($bill['office_member_salutation']));
                    $bill_added_by_fullname = ucwords(strtolower(htmlspecialchars($bill['office_member_fullname'])));
                    $bill_added_by_name = $bill_added_by_salutation . ' ' . $bill_added_by_fullname;

                    $bill_added_on = date('d M, Y h:i A', strtotime($bill['bill_added_on']));
                    $bill_due_date = date('d M, Y', strtotime($bill['bill_due_on']));
                    $bill_updated_on = $bill['bill_updated_on'];
                        if (!empty($bill_updated_on) || $bill_updated_on !== NULL) {
                            $bill_updated_on = date('d M, Y h:i A', strtotime($bill['bill_updated_on']));
                        } else {
                            $bill_updated_on = 'N/A';
                        }

                    echo "
                        <tr>
                            <td class='text-center'>
                                $i
                            </td>
                            <td>$member_display</td>
                            <td>
                                <a href='" . get_site_option('dashboard_url') . "assets/uploads/documents/bills/$bill_file' class='btn btn-primary btn-sm' target='_blank'>
                                    <iconify-icon icon='clarity:pop-out-line'></iconify-icon>
                                </a>
                            </td>
                            <td>$bill_month</td>
                            <td>$bill_status_badge</td>
                            <td>
                                <a href='javascript:void(0)' class='w-32-px h-32-px bg-primary-light text-primary-600 rounded-circle d-inline-flex align-items-center justify-content-center' data-bs-toggle='modal' data-bs-target='#viewBillModal$bill_id'>
                                    <iconify-icon icon='iconamoon:eye-light'></iconify-icon>
                                </a>

                                <!--- View Bill Modal -->
                                <div class='modal fade' id='viewBillModal$bill_id' tabindex='-1' aria-labelledby='viewBillModalLabel$bill_id' aria-hidden='true'>
                                    <div class='modal-dialog modal-lg modal-dialog-centered'>
                                        <div class='modal-content'>
                                            <div class='modal-header'>
                                                <h5 class='modal-title' id='viewBillModalLabel$bill_id'>Bill Details</h5>
                                                <button type='button' class='btn-close' data-bs-dismiss='modal' aria-label='Close'></button>
                                            </div>
                                            <div class='modal-body'>
                                                <div class='row'>
                                                    <div class='col-md-2'>
                                                        <div class='mb-3'>
                                                            <label for='billID' class='form-label'>ID:</label>
                                                            <input type='text' readonly value='$bill_id' class='form-control' />
                                                        </div>
                                                    </div>
                                                    <div class='col-md-6'>
                                                        <div class='mb-3'>
                                                            <label for='billAddedBy' class='form-label'>Added By:</label>
                                                            <input type='text' readonly value='$bill_added_by_name ($bill_added_by_id)' class='form-control' />
                                                        </div>
                                                    </div>
                                                    <div class='col-md-4'>
                                                        <div class='mb-3'>
                                                            <label for='billAddedOn' class='form-label'>Added On:</label>
                                                            <input type='text' readonly value='$bill_added_on' class='form-control' />
                                                        </div>
                                                    </div>
                                                    <div class='col-md-6'>
                                                        <div class='mb-3'>
                                                            <label for='billMember' class='form-label'>Member:</label>
                                                            <input type='text' readonly value='$member_display' class='form-control' />
                                                        </div>
                                                    </div>
                                                    <div class='col-md-6'>
                                                        <div class='mb-3'>
                                                            <label for='billMonth' class='form-label'>Month:</label>
                                                            <input type='text' readonly value='$bill_month' class='form-control' />
                                                        </div>
                                                    </div>
                                                    <div class='col-md-12'>
                                                        <div class='mb-3'>
                                                            <label for='billFile' class='form-label'>File:</label>
                                                            <iframe src='" . get_site_option('dashboard_url') . "assets/uploads/documents/bills/$bill_file' width='100%' height='600px' style='border: 1px solid #ccc;'></iframe>
                                                        </div>
                                                    </div>
                                                    <div class='col-md-4'>
                                                        <div class='mb-3'>
                                                            <label for='billDueDate' class='form-label'>Due Date:</label>
                                                            <input type='text' readonly value='$bill_due_date' class='form-control' />
                                                        </div>
                                                    </div>
                                                    <div class='col-md-3'>
                                                        <div class='mb-3'>
                                                            <label for='billStatus' class='form-label'>Status:</label>
                                                            <input type='text' readonly value='" . ucwords($bill_status) . "' class='form-control' />
                                                        </div>
                                                    </div>
                                                    <div class='col-md-5'>
                                                        <div class='mb-3'>
                                                            <label for='billUpdatedOn' class='form-label'>Updated On:</label>
                                                            <input type='text' readonly value='$bill_updated_on' class='form-control' />
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>
                                            <div class='modal-footer d-flex justify-content-between'>
                                                <div>";
                                                    if ($bill_status === 'pending') {
                                                        echo "
                                                            <button type='button' class='btn btn-success' onclick=\"confirmStatusChange('bills', 'bill_id', $bill_id, 'bill_status', 'paid', 'bill_updated_on')\">
                                                                <i class='ri-hand-coin-line'></i> Mark as Paid
                                                            </button>
                                                            <button type='button' class='btn btn-secondary' onclick=\"confirmStatusChange('bills', 'bill_id', $bill_id, 'bill_status', 'cancelled', 'bill_updated_on')\">
                                                                <i class='ri-close-circle-line'></i> Mark as Cancelled
                                                            </button>
                                                        ";
                                                    } elseif ($bill_status === 'paid') {
                                                        echo "
                                                            <button type='button' class='btn btn-warning' onclick=\"confirmStatusChange('bills', 'bill_id', $bill_id, 'bill_status', 'pending', 'bill_updated_on')\">
                                                                <i class='ri-error-warning-line'></i> Mark as Pending
                                                            </button>
                                                            <button type='button' class='btn btn-secondary' onclick=\"confirmStatusChange('bills', 'bill_id', $bill_id, 'bill_status', 'cancelled', 'bill_updated_on')\">
                                                                <i class='ri-close-circle-line'></i> Mark as Cancelled
                                                            </button>
                                                        ";
                                                    } elseif ($bill_status === 'cancelled') {
                                                        echo "
                                                            <button type='button' class='btn btn-warning' onclick=\"confirmStatusChange('bills', 'bill_id', $bill_id, 'bill_status', 'pending', 'bill_updated_on')\">
                                                                <i class='ri-error-warning-line'></i> Mark as Pending
                                                            </button>
                                                        ";
                                                    }
                                                    echo "
                                                    <button type='button' class='btn btn-danger' onclick=\"confirmStatusChange('bills', 'bill_id', $bill_id, 'bill_status', 'deleted', 'bill_updated_on')\">
                                                        <i class='ri-delete-bin-line'></i> Delete
                                                    </button>
                                                </div>
                                                <button type='button' class='btn btn-outline-secondary' data-bs-dismiss='modal'>Close</button>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                                

                                <a href='" . get_site_option('dashboard_url') . "?page=edit-bill&bill_id=$bill_id' class='w-32-px h-32-px bg-success-focus text-success-main rounded-circle d-inline-flex align-items-center justify-content-center'>
                                    <iconify-icon icon='lucide:edit'></iconify-icon>
                                </a>

                                <a href='javascript:void(0);' class='w-32-px h-32-px bg-danger-focus text-danger-main rounded-circle d-inline-flex align-items-center justify-content-center' onclick=\"confirmStatusChange('bills', 'bill_id', $bill_id, 'bill_status', 'deleted', 'bill_updated_on')\">
                                    <iconify-icon icon='mingcute:delete-2-line'></iconify-icon>
                                </a>
                            </td>
                        </tr>
                    ";
                }
            }
        }
    }

    // Load bills for a specific member
    function load_this_member_bills($member_email) {
        global $con;

        $member = fetch_single_member($member_email);
        if (!$member) {
            return '<p class="text-muted">Member not found.</p>';
        }

        $member_unique_id = $member['member_unique_id'];

        $stmt = mysqli_prepare($con, "SELECT * FROM bills WHERE bill_for_member = ? ORDER BY bill_for_month DESC");
        mysqli_stmt_bind_param($stmt, 's', $member_unique_id);
        mysqli_stmt_execute($stmt);
        $result = mysqli_stmt_get_result($stmt);
        if (mysqli_num_rows($result) == 0) {
            return '<p class="text-muted">No bills found.</p>';
        }

        while ($bill = mysqli_fetch_assoc($result)) {
            $bill_id = $bill['bill_id'];
            $bill_month = date('F, Y', strtotime($bill['bill_for_month']));
            $bill_file = htmlspecialchars($bill['bill_file']);
            $bill_due_date = date('d M, Y', strtotime($bill['bill_due_on']));
            $bill_status = htmlspecialchars($bill['bill_status']);
                if ($bill_status === 'pending') {
                    $bill_status_badge = "<span class='badge warning'>Pending</span>";
                    $bill_button = "
                        <button class='btn btn-success' type='button' disabled> 
                            <i class='fas fa-credit-card'></i> 
                            <span>Pay Now (Coming Soon)</span> 
                        </button>
                    ";
                } elseif ($bill_status === 'paid') {
                    $bill_status_badge = "<span class='badge success'>Paid</span>";
                    $bill_button = "
                        <a href='javascript:void(0);' class='btn btn-outline' disabled> 
                            <i class='fas fa-download'></i> 
                            <span>Receipt (Coming Soon)</span> 
                        </a>
                    ";
                } elseif ($bill_status === 'cancelled') {
                    $bill_status_badge = "<span class='badge secondary'>Cancelled</span>";
                } elseif ($bill_status === 'deleted') {
                    $bill_status_badge = "<span class='badge danger'>Deleted</span>";
                }

                
            $bill_file = htmlspecialchars($bill['bill_file']);
            $download_url = !empty($bill_file) ? get_site_option('site_url') . 'assets/documents/bills/' . $bill_file : '';

            echo "
                <div class='bill-card'>
                    <div class='bill-info'>
                        <div class='bill-title'>
                            Bill - $bill_month
                        </div>
                        <div class='bill-meta'>
                            <div class='bill-meta-item'>
                                <i class='fas fa-calendar'></i> 
                                <span>Due: $bill_due_date</span>
                            </div>
                            <div class='bill-meta-item'>
                                <i class='fas fa-file-alt'></i> 
                                <span>Invoice: #SVN-2025-01-301 <a href='" . get_site_option('dashboard_url') . "assets/uploads/documents/bills/$bill_file' target='_blank'>View Bill</a></span>
                            </div>
                            <div class='bill-meta-item'>
                                $bill_status_badge
                            </div>
                        </div>
                    </div>
                    <div class='bill-actions'>
                        <!-- <div class='bill-amount'>
                            ₹7,500
                        </div> -->
                        $bill_button
                    </div>
                </div>
            ";
        }
    }

    function load_gallery($display_type = null, $order_by = 'gallery_id', $sorting = 'DESC', $limit = null) {
        global $con;
        
        if (empty($display_type) || $display_type == NULL) {
            echo '<p class="text-muted">Display type is required in Function Call.</p>';
            return;
        }

        if ($display_type === 'gallery-page') {
            $query = "SELECT * FROM gallery WHERE gallery_status = 'published' ORDER BY $order_by $sorting";

            if ($limit !== null && is_numeric($limit)) {
                $query .= " LIMIT ?";
            }

            $stmt = mysqli_prepare($con, $query);

            if ($limit !== null && is_numeric($limit)) {
                mysqli_stmt_bind_param($stmt, 'i', $limit);
            }

            mysqli_stmt_execute($stmt);
            $result = mysqli_stmt_get_result($stmt);

            if (mysqli_num_rows($result) <= 0) {
                echo '<p class="text-muted">No images found in the gallery.</p>';
                return;
            }

            $i = 0;
            while ($image = mysqli_fetch_assoc($result)) {
                $i++;
                $image_title = htmlspecialchars($image['gallery_title']);
                $image_src = htmlspecialchars($image['gallery_image']);
                echo "
                    <button type='button' class='gallery-item' data-gallery-index='<?= $i ?>' data-full='" . get_site_option('dashboard_url') . "assets/uploads/images/gallery/" . $image_src . "' data-caption='$image_title'>
                        <span class='gallery-thumb'>
                            <img src='" . get_site_option('dashboard_url') . "assets/uploads/images/gallery/" . $image_src . "' alt='$image_title' loading='lazy'>
                        </span>
                        <span class='gallery-meta'>
                            <span class='gallery-title'>$image_title</span>
                            <span class='gallery-zoom'><i class='fas fa-magnifying-glass'></i> View</span>
                        </span>
                    </button>
                ";
            }
        }

        if ($display_type === 'gallery-management') {
            $query = "SELECT g.*, om.* FROM gallery g
                LEFT JOIN office_members om ON g.gallery_uploaded_by = om.office_member_unique_id
                WHERE g.gallery_status != 'deleted' ORDER BY $order_by $sorting";

            $stmt = mysqli_prepare($con, $query);
            mysqli_stmt_execute($stmt);
            $result = mysqli_stmt_get_result($stmt);

            if (mysqli_num_rows($result) <= 0) {
                echo "
                    <tr class='table-empty'>
                        <td class='text-center text-muted'>—</td>
                        <td class='text-muted'>No images found.</td>
                        <td class='text-muted'>&nbsp;</td>
                        <td class='text-muted'>&nbsp;</td>
                        <td class='text-muted'>&nbsp;</td>
                    </tr>
                ";
                return;
            }

            $i = 0;
            while ($image = mysqli_fetch_assoc($result)) {
                $i++;
                $image_id = $image['gallery_id'];
                $image_title = htmlspecialchars($image['gallery_title']);
                $image_src = htmlspecialchars($image['gallery_image']);
                $image_status = htmlspecialchars($image['gallery_status']);
                    if ($image_status === 'published') {
                        $image_status_badge = "
                            <button class='bg-success-focus text-success-main px-24 py-4 rounded-pill fw-medium text-sm' onclick=\"confirmStatusChange('gallery', 'gallery_id', $image_id, 'gallery_status', 'draft', 'gallery_updated_on')\"> " . ucwords(strtolower($image_status)) . "</button>
                        ";
                    } elseif ($image_status === 'draft') {
                        $image_status_badge = "
                            <button class='bg-warning-focus text-warning-main px-24 py-4 rounded-pill fw-medium text-sm' onclick=\"confirmStatusChange('gallery', 'gallery_id', $image_id, 'gallery_status', 'published', 'gallery_updated_on')\"> " . ucwords(strtolower($image_status)) . "</button>
                        ";
                    }

                $image_uploaded_by_id = htmlspecialchars($image['gallery_uploaded_by']);
                $image_uploaded_by_salutation = ucwords(strtolower($image['office_member_salutation']));
                $image_uploaded_by_fullname = ucwords(strtolower(htmlspecialchars($image['office_member_fullname'])));
                $image_uploaded_by_name = $image_uploaded_by_salutation . ' ' . $image_uploaded_by_fullname;

                $image_uploaded_on = date('d M, Y h:i A', strtotime($image['gallery_uploaded_on']));
                $image_updated_on = $image['gallery_updated_on'];
                    if (!empty($image_updated_on) || $image_updated_on !== NULL) {
                        $image_updated_on = date('d M, Y h:i A', strtotime($image['gallery_updated_on']));
                    } else {
                        $image_updated_on = 'N/A';
                    }

                echo "
                    <tr>
                        <td class='text-center'>
                            $i
                        </td>
                        <td class='text-center'>
                            <img src='" . get_site_option('dashboard_url') . "assets/uploads/images/gallery/$image_src' alt='$image_title' width='50%' style='object-fit: cover; border-radius: 8px;' />
                        </td>
                        <td>$image_title</td>
                        <td>$image_status_badge</td>
                        <td>
                            <a href='javascript:void(0)' class='w-32-px h-32-px bg-primary-light text-primary-600 rounded-circle d-inline-flex align-items-center justify-content-center' data-bs-toggle='modal' data-bs-target='#viewImageModal$image_id'>
                                <iconify-icon icon='iconamoon:eye-light'></iconify-icon>
                            </a>

                            <!--- View Image Modal -->
                            <div class='modal fade' id='viewImageModal$image_id' tabindex='-1' aria-labelledby='viewImageModalLabel$image_id' aria-hidden='true'>
                                <div class='modal-dialog modal-lg modal-dialog-centered'>
                                    <div class='modal-content'>
                                        <div class='modal-header'>
                                            <h5 class='modal-title' id='viewImageModalLabel$image_id'>Image Details</h5>
                                            <button type='button' class='btn-close' data-bs-dismiss='modal' aria-label='Close'></button>
                                        </div>
                                        <div class='modal-body'>
                                            <div class='row'>
                                                <div class='col-md-2'>
                                                    <div class='mb-3'>
                                                        <label for='imageID' class='form-label'>ID:</label>
                                                        <input type='text' readonly value='$image_id' class='form-control' />
                                                    </div>
                                                </div>
                                                <div class='col-md-6'>
                                                    <div class='mb-3'>
                                                        <label for='imageAddedBy' class='form-label'>Added By:</label>
                                                        <input type='text' readonly value='$image_uploaded_by_name ($image_uploaded_by_id)' class='form-control' />
                                                    </div>
                                                </div>
                                                <div class='col-md-4'>
                                                    <div class='mb-3'>
                                                        <label for='imageUploadedOn' class='form-label'>Uploaded On:</label>
                                                        <input type='text' readonly value='$image_uploaded_on' class='form-control' />
                                                    </div>
                                                </div>
                                                <div class='col-md-12'>
                                                    <div class='mb-3'>
                                                        <label for='imageTitle' class='form-label'>Title:</label>
                                                        <input type='text' readonly value='$image_title' class='form-control' />
                                                    </div>
                                                </div>
                                                <div class='col-md-12'>
                                                    <div class='mb-3'>
                                                        <label for='imageFile' class='form-label'>Image:</label>
                                                        <img src='" . get_site_option('dashboard_url') . "assets/uploads/images/gallery/$image_src' alt='$image_title' width='100%' style='border: 1px solid #ccc; border-radius: 8px;' />
                                                    </div>
                                                </div>
                                                <div class='col-md-3'>
                                                    <div class='mb-3'>
                                                        <label for='imageStatus' class='form-label'>Status:</label>
                                                        <input type='text' readonly value='" . ucwords($image_status) . "' class='form-control' />
                                                    </div>
                                                </div>
                                                <div class='col-md-5'>
                                                    <div class='mb-3'>
                                                        <label for='imageUpdatedOn' class='form-label'>Updated On:</label>
                                                        <input type='text' readonly value='$image_updated_on' class='form-control' />
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                        <div class='modal-footer d-flex justify-content-between'>
                                            <div>";
                                                if ($image_status === 'published') {
                                                    echo "
                                                        <button type='button' class='btn btn-warning' onclick=\"confirmStatusChange('gallery', 'gallery_id', $image_id, 'image_status', 'draft', 'image_updated_on')\">
                                                            <i class='ri-error-warning-line'></i> Mark as Draft
                                                        </button>
                                                    ";
                                                } elseif ($image_status === 'draft') {
                                                    echo "
                                                        <button type='button' class='btn btn-success' onclick=\"confirmStatusChange('gallery', 'gallery_id', $image_id, 'image_status', 'published', 'image_updated_on')\">
                                                            <i class='ri-hand-coin-line'></i> Mark as Published
                                                        </button>
                                                    ";
                                                }
                                                echo "
                                                <button type='button' class='btn btn-danger' onclick=\"confirmStatusChange('gallery', 'gallery_id', $image_id, 'image_status', 'deleted', 'image_updated_on')\">
                                                    <i class='ri-delete-bin-line'></i> Delete
                                                </button>
                                            </div>
                                            <button type='button' class='btn btn-outline-secondary' data-bs-dismiss='modal'>Close</button>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            

                            <a href='" . get_site_option('dashboard_url') . "?page=edit-image&image_id=$image_id' class='w-32-px h-32-px bg-success-focus text-success-main rounded-circle d-inline-flex align-items-center justify-content-center'>
                                <iconify-icon icon='lucide:edit'></iconify-icon>
                            </a>

                            <a href='javascript:void(0);' class='w-32-px h-32-px bg-danger-focus text-danger-main rounded-circle d-inline-flex align-items-center justify-content-center' onclick=\"confirmStatusChange('gallery', 'gallery_id', $image_id, 'image_status', 'deleted', 'image_updated_on')\">
                                <iconify-icon icon='mingcute:delete-2-line'></iconify-icon>
                            </a>
                        </td>
                    </tr>
                ";
            }
        }
    }
?>