<?php 
    session_start();
    require_once '../../admin/assets/includes/config/config.php';

    require_once '../../admin/assets/includes/functions/data_fetcher.php';
    require_once '../../admin/assets/includes/functions/user_auth.php';
    require_once '../../admin/assets/includes/functions/utility_functions.php';
    require_once '../../admin/assets/includes/functions/send_emails.php';

    // Check if user is logged in
    if (!isset($_SESSION['member_email'])) {
        header('Location: ' . get_site_option('site_url'));
        exit();
    } else {
        $member = fetch_single_member($_SESSION['member_email']);
        if (!$member) {
            // Invalid session, redirect to home
            header('Location: ' . get_site_option('site_url'));
            exit();
        } else {
?>
<!DOCTYPE html>
<html lang="en" style="height: 100%;">
<head>
    <meta charset="UTF-8">
    <title><?= ucwords(strtolower(htmlspecialchars($member['member_salutation']))) ?> <?= ucwords(strtolower(htmlspecialchars($member['member_fullname']))) ?> - My Account - Jagaran CGHS</title>
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <!-- Bootstrap CSS (CDN) -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet"
        integrity="sha384-QWTKZyjpPEjISv5WaRU9OFeRpok6YctnYmDr5pNlyT2bRjXh0JMhjY6hW+ALEwIH" crossorigin="anonymous">
    <!-- Font Awesome -->
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.1/css/all.min.css"
        integrity="sha512-DTOQO9RWCH3ppGqcWaEA1BIZOC6xxalwEsw9c2QQeAIftl+Vegovlnee1c9QX4TctnWMn13TZye+giMm8e2LwA==" crossorigin="anonymous" referrerpolicy="no-referrer">
    <!-- Global Styles -->
    <link rel="stylesheet" href="../../assets/css/global.css">
    <link rel="stylesheet" href="../../assets/css/topbar.css">
    <link rel="stylesheet" href="../../assets/css/header.css">
    <link rel="stylesheet" href="../../assets/css/footer.css">
    <!-- Page-specific Styles -->
    <link rel="stylesheet" href="../../assets/css/style_my-account.css">
    <link rel="stylesheet" href="../../assets/css/login-modal.css">
    <!-- Password Toggle Function (MUST be before components.js) -->
    <script src="../../assets/js/toggle-password.js"></script>
</head>

<body>
    <div class="app-wrapper">
        <header>
            <?php 
                require_once '../../assets/elements/topbar.php';
            ?>

            <!-- Header -->
            <?php 
                require_once '../../assets/elements/header.php';
            ?>

            <!-- Navigation -->
            <?php 
                require_once '../../assets/elements/navbar.php';
            ?>
        </header>

        <!-- Hero Section -->
        <section class="hero-section" aria-labelledby="page-title">
            <div class="hero-inner">
                <div class="hero-breadcrumb">
                    <a href="<?= get_site_option('site_url') ?>">Home</a> / My Account
                </div>
                <h1 class="hero-title" id="page-title">My Account</h1>
                <p class="hero-subtitle" id="hero-subheading">All your account details and activities.</p>
                <a href="<?= get_site_option('site_url') ?>" class="back-link">
                    <span>←</span>
                    <span>Back to Home</span>
                </a>
            </div>
        </section>
        <!-- Main Content -->
        <main class="account-content">
            <div class="content-container">
                <!-- Profile Banner -->
                <div class="profile-banner">
                    <div class="profile-content">
                        <div class="profile-avatar" id="userAvatar">
                            <?php 
                                if (!empty($member['member_image'])) {
                                    echo '<img src="' . get_site_option('site_url') . '/admin/assets/images/members/' . htmlspecialchars($member['member_image']) . '" alt="Profile Picture of ' . ucwords(strtolower(htmlspecialchars($member['member_fullname']))) . '">';
                                } else {
                                    $nameParts = preg_split('/\s+/', trim((string) ($member['member_fullname'] ?? '')));
                                    $initials = '';

                                    if (!empty($nameParts)) {
                                        foreach ($nameParts as $index => $part) {
                                            if ($index >= 2) {
                                                break;
                                            }
                                            $initials .= strtoupper(substr($part, 0, 1));
                                        }
                                    }

                                    $initials = $initials ?: 'U';
                                    echo htmlspecialchars($initials);
                                }
                            ?>
                        </div>
                        <div class="profile-info">
                            <h2 class="profile-name" id="userName"><?= ucwords(strtolower(htmlspecialchars($member['member_salutation']))) ?> <?= ucwords(strtolower(htmlspecialchars($member['member_fullname']))) ?></h2>
                            <div class="profile-meta">
                                <div class="profile-meta-item">
                                    <i class="fas fa-home"></i> 
                                    <span>
                                        Flat 
                                        <strong id="flatNumber">
                                            <?php
                                                if (!empty($member['member_block']) || $member['member_block'] !== NULL || !empty($member['member_flat_number']) || $member['member_flat_number'] !== NULL) {
                                                    echo "
                                                        " . htmlspecialchars($member['member_block']) . "-" . htmlspecialchars($member['member_flat_number']) . "
                                                    ";
                                                } else {
                                                    echo "N/A";
                                                }
                                            ?>
                                        </strong>
                                    </span>
                                </div>
                                <div class="profile-meta-item">
                                    <i class="fas fa-envelope"></i> 
                                    <span id="userEmail"><?= htmlspecialchars($member['member_email'] ?? 'N/A') ?></span>
                                </div>
                                <div class="profile-meta-item">
                                    <i class="fas fa-phone"></i> 
                                    <span id="userPhone">
                                        <?php 
                                            if (!empty($member['member_phone_number']) || $member['member_phone_number'] !== NULL) {
                                                echo htmlspecialchars($member['member_phone_number']);
                                            } else {
                                                echo "N/A";
                                            }
                                        ?>
                                    </span>
                                </div>
                                <div class="profile-meta-item">
                                    <i class="fas fa-calendar-check"></i> 
                                    <span>
                                        Member since 
                                        <strong>
                                            <?= date("M Y", strtotime($member['member_added_on'])) ?>
                                        </strong>
                                    </span>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
                
                <!-- Quick Stats -->
                <!-- <div class="quick-stats">
                    <div class="stat-card">
                        <div class="stat-icon blue">
                            <i class="fas fa-file-invoice-dollar"></i>
                        </div>
                        <div class="stat-info">
                            <div class="stat-label">
                                Pending Bills
                            </div>
                            <div class="stat-value">
                                NA
                            </div>
                        </div>
                    </div>
                    <div class="stat-card">
                        <div class="stat-icon green">
                            <i class="fas fa-check-circle"></i>
                        </div>
                        <div class="stat-info">
                            <div class="stat-label">
                                Paid This Year
                            </div>
                            <div class="stat-value">
                                NA
                            </div>
                        </div>
                    </div>
                    <div class="stat-card">
                        <div class="stat-icon yellow">
                            <i class="fas fa-exclamation-triangle"></i>
                        </div>
                        <div class="stat-info">
                            <div class="stat-label">
                                Open Complaints
                            </div>
                            <div class="stat-value">
                                NA
                            </div>
                        </div>
                    </div>
                    <div class="stat-card">
                        <div class="stat-icon red">
                            <i class="fas fa-calendar-times"></i>
                        </div>
                        <div class="stat-info">
                            <div class="stat-label">
                                Overdue
                            </div>
                            <div class="stat-value">
                                NA
                            </div>
                        </div>
                    </div>
                </div> -->
            
                <!-- Tabs -->
                <div class="tabs-container">
                    <div class="tabs-header">
                        <button class="tab-btn active" type="button" data-tab="profile"> 
                            <i class="fas fa-user"></i> 
                            <span>Profile</span> 
                        </button> 
                        <button class="tab-btn" type="button" data-tab="changePassword"> 
                            <i class="fas fa-key"></i> 
                            <span>Change Password</span> 
                        </button> 
                        <button class="tab-btn" type="button" data-tab="bills"> 
                            <i class="fas fa-file-invoice"></i> 
                            <span>Bills &amp; Payments</span> 
                        </button> 
                        <!-- <button class="tab-btn" type="button" data-tab="complaints"> 
                            <i class="fas fa-comment-dots"></i> 
                            <span>My Complaints</span> 
                        </button> 
                        <button class="tab-btn" type="button" data-tab="documents"> 
                            <i class="fas fa-folder"></i> 
                            <span>Documents</span> 
                        </button> 
                        <button class="tab-btn" type="button" data-tab="maintenance"> 
                            <i class="fas fa-history"></i> 
                            <span>History</span> 
                        </button> -->
                    </div>

                    <div class="tabs-content">
                        <!-- Profile Tab -->
                        <div class="tab-panel active" id="profile">
                            <h3 class="section-title"><i class="fas fa-id-card"></i> <span>Personal Information</span></h3>
                            <div class="info-grid">
                                <div class="info-card">
                                    <div class="info-label">
                                        <i class="fas fa-user"></i> Full Name
                                    </div>
                                    <div class="info-value" id="profileName">
                                        <?= ucwords(strtolower(htmlspecialchars($member['member_salutation']))) . " " . ucwords(strtolower(htmlspecialchars($member['member_fullname']))) ?>
                                    </div>
                                </div>
                                <div class="info-card">
                                    <div class="info-label">
                                        <i class="fas fa-home"></i> Flat Number
                                    </div>
                                    <div class="info-value" id="profileFlat">
                                        <?php
                                            if (!empty($member['member_block']) || $member['member_block'] !== NULL || !empty($member['member_flat_number']) || $member['member_flat_number'] !== NULL) {
                                                echo "
                                                    " . htmlspecialchars($member['member_block']) . "-" . htmlspecialchars($member['member_flat_number']) . "
                                                ";
                                            } else {
                                                echo "N/A";
                                            }
                                        ?>
                                    </div>
                                </div>
                                <div class="info-card">
                                    <div class="info-label">
                                        <i class="fas fa-building"></i> Block
                                    </div>
                                    <div class="info-value">
                                        <?= format_block_floor_label($member['member_block'], $member['member_flat_number']) ?>
                                    </div>
                                </div>
                                <div class="info-card">
                                    <div class="info-label">
                                        <i class="fas fa-envelope"></i> Email Address
                                    </div>
                                    <div class="info-value" id="profileEmail">
                                        <?= htmlspecialchars($member['member_email']) ?>
                                    </div>
                                </div>
                                <div class="info-card">
                                    <div class="info-label">
                                        <i class="fas fa-phone"></i> Phone Number
                                    </div>
                                    <div class="info-value" id="profilePhone">
                                        <?php 
                                            if (!empty($member['member_phone_number']) || $member['member_phone_number'] !== NULL) {
                                                echo htmlspecialchars($member['member_phone_number']);
                                            } else {
                                                echo "N/A";
                                            }
                                        ?>
                                    </div>
                                </div>
                                <!-- <div class="info-card">
                                <div class="info-label"><i class="fas fa-phone-alt"></i> Alternate Number
                                </div>
                                <div class="info-value">
                                +91 98765 43211
                                </div>
                                </div>
                                <div class="info-card">
                                <div class="info-label"><i class="fas fa-users"></i> Family Members
                                </div>
                                <div class="info-value">
                                4 Members
                                </div>
                                </div>
                                <div class="info-card">
                                <div class="info-label"><i class="fas fa-car"></i> Vehicle Registration
                                </div>
                                <div class="info-value">
                                MH 02 AB 1234
                                </div>
                                </div>
                                <div class="info-card">
                                <div class="info-label"><i class="fas fa-parking"></i> Parking Slot
                                </div>
                                <div class="info-value">
                                P-A-15
                                </div>
                                </div> -->
                                <div class="info-card">
                                    <div class="info-label">
                                        <i class="fas fa-calendar"></i> Member Since
                                    </div>
                                    <div class="info-value">
                                        <?= date("F Y", strtotime($member['member_added_on'])) ?>
                                    </div>
                                </div>
                                <div class="info-card">
                                    <div class="info-label">
                                        <i class="fas fa-id-badge"></i> Member ID
                                    </div>
                                    <div class="info-value">
                                        <?= htmlspecialchars($member['member_unique_id']) ?>
                                    </div>
                                </div>
                                <div class="info-card">
                                    <div class="info-label">
                                        <i class="fas fa-shield-alt"></i> Membership Status
                                    </div>
                                    <div class="info-value">
                                        <?php 
                                            if ($member['member_status'] === 'inactive') {
                                                echo '<span class="badge warning">Inactive</span>';
                                            } elseif ($member['member_status'] === 'active') {
                                                echo '<span class="badge success">Active</span>';
                                            }
                                        ?>
                                    </div>
                                </div>
                            </div>
                            <div style="margin-top: 2rem;">
                                <button class="btn btn-primary" type="button" id="editProfileBtn" disabled> 
                                    <i class="fas fa-edit"></i> 
                                    <span>To Change the Details Please Contact Society Office</span> 
                                </button>
                            </div>
                        </div>

                        <!-- Change Password Tab -->
                        <div class="tab-panel" id="changePassword">
                            <h3 class="section-title"><i class="fas fa-key"></i> <span>Change Password</span></h3>
                            <form id="changePasswordForm" action="" method="post">
                                <!-- New Password Field -->
                                <div class="mb-3">
                                    <div class="input-group">
                                        <input type="password" class="form-control form-control-lg" id="newPassword" name="newPassword" placeholder="Enter your new password" required>
                                        <button class="btn btn-outline-secondary toggle-password-btn" type="button" id="toggleNewPassword" tabindex="-1" aria-label="Toggle password visibility">
                                            <i class="fas fa-eye"></i>
                                        </button>
                                    </div>
                                </div>

                                <!-- Confirm New Password Field -->
                                <div class="mb-3">
                                    <div class="input-group">
                                        <input type="password" class="form-control form-control-lg" id="confirmPassword" name="confirmPassword" placeholder="Confirm your new password" required>
                                        <button class="btn btn-outline-secondary toggle-password-btn" type="button" id="toggleConfirmPassword" tabindex="-1" aria-label="Toggle password visibility">
                                            <i class="fas fa-eye"></i>
                                        </button>
                                    </div>
                                </div>

                                <!-- Change Password Button -->
                                <input type="submit" value="Change Password" class="btn btn-lg btn-warning w-100 fw-bold mb-3" name="change_password" id="change_password">
                            </form>
                        </div>
                    
                        <!-- Bills Tab -->
                        <div class="tab-panel" id="bills">
                            <h3 class="section-title">
                                <i class="fas fa-file-invoice-dollar"></i> 
                                <span>Bills &amp; Payments</span>
                            </h3>

                            <div class="bills-list">
                                <?= load_this_member_bills($_SESSION['member_email']) ?>
                            </div>
                        </div>
            
                        <!-- Complaints Tab -->
                        <!-- <div class="tab-panel" id="complaints">
                            <div class="d-flex flex-column flex-lg-row align-items-start align-items-lg-center justify-content-lg-between gap-3 mb-3">
                                <h3 class="section-title mb-0">
                                    <i class="fas fa-comment-dots"></i> 
                                    <span>My Complaints</span>
                                </h3>
                            </div>

                            <p class="info-text">This Feature is coming soon.</p> -->

                            <!-- <div class="complaints-list">
                                <div class="complaint-card pending">
                                    <div class="complaint-header">
                                        <div>
                                            <div class="complaint-title">
                                                Water Leakage in Bathroom
                                            </div>
                                            <div class="complaint-id">
                                                Complaint ID: CMP-2025-0142
                                            </div>
                                        </div>
                                        <span class="badge warning">Pending</span>
                                    </div>
                                    <div class="complaint-body">
                                        There is water leakage from the ceiling of my bathroom. It seems to be coming from the flat above. Kindly arrange for inspection and repair at the earliest.
                                    </div>
                                    <div class="complaint-footer">
                                        <div class="complaint-date">
                                            <i class="fas fa-clock"></i> 
                                            <span>Submitted on Jan 14, 2025</span>
                                        </div>
                                        <div class="complaint-date">
                                            <i class="fas fa-user"></i> 
                                            <span>Assigned to: Maintenance Team</span>
                                        </div>
                                    </div>
                                </div>

                                <div class="complaint-card in-progress">
                                    <div class="complaint-header">
                                        <div>
                                            <div class="complaint-title">
                                                Water Leakage in Bathroom
                                            </div>
                                            <div class="complaint-id">
                                                Complaint ID: CMP-2025-0142
                                            </div>
                                        </div>
                                        <span class="badge warning">Pending</span>
                                    </div>
                                    <div class="complaint-body">
                                        There is water leakage from the ceiling of my bathroom. It seems to be coming from the flat above. Kindly arrange for inspection and repair at the earliest.
                                    </div>
                                    <div class="complaint-footer">
                                        <div class="complaint-date">
                                            <i class="fas fa-clock"></i> 
                                            <span>Submitted on Jan 14, 2025</span>
                                        </div>
                                        <div class="complaint-date">
                                            <i class="fas fa-user"></i> 
                                            <span>Assigned to: Maintenance Team</span>
                                        </div>
                                    </div>
                                </div>

                                <div class="complaint-card resolved">
                                    <div class="complaint-header">
                                        <div>
                                            <div class="complaint-title">
                                                Water Leakage in Bathroom
                                            </div>
                                            <div class="complaint-id">
                                                Complaint ID: CMP-2025-0142
                                            </div>
                                        </div>
                                        <span class="badge warning">Pending</span>
                                    </div>
                                    <div class="complaint-body">
                                        There is water leakage from the ceiling of my bathroom. It seems to be coming from the flat above. Kindly arrange for inspection and repair at the earliest.
                                    </div>
                                    <div class="complaint-footer">
                                        <div class="complaint-date">
                                            <i class="fas fa-clock"></i> 
                                            <span>Submitted on Jan 14, 2025</span>
                                        </div>
                                        <div class="complaint-date">
                                            <i class="fas fa-user"></i> 
                                            <span>Assigned to: Maintenance Team</span>
                                        </div>
                                    </div>
                                </div>
                            </div> -->
                            <!-- <div class="w-100 w-lg-auto">
                                <button class="btn btn-primary" type="button" id="newComplaintBtn" disabled> 
                                    <i class="fas fa-plus"></i> 
                                    <span>Submit New Complaint (Coming Soon)</span> 
                                </button>
                            </div> -->
                        <!-- </div> -->
                        
                        <!-- Documents Tab -->
                        <!-- <div class="tab-panel" id="documents">
                            <h3 class="section-title">
                                <i class="fas fa-folder-open"></i> 
                                <span>My Documents</span>
                            </h3>

                            <p class="info-text">This Feature is coming soon.</p> -->
                            <!-- <div class="documents-grid">
                            <div class="document-card">
                            <div class="document-icon"><i class="fas fa-file-contract"></i>
                            </div>
                            <div>
                            <div class="document-name">
                                Society Agreement
                            </div>
                            <div class="document-size">
                                2.4 MB • PDF
                            </div>
                            </div><button class="btn btn-outline" type="button"> <i class="fas fa-download"></i> <span>Download</span> </button>
                            </div>
                            <div class="document-card">
                            <div class="document-icon"><i class="fas fa-id-card"></i>
                            </div>
                            <div>
                            <div class="document-name">
                                Membership Certificate
                            </div>
                            <div class="document-size">
                                856 KB • PDF
                            </div>
                            </div><button class="btn btn-outline" type="button"> <i class="fas fa-download"></i> <span>Download</span> </button>
                            </div>
                            <div class="document-card">
                            <div class="document-icon"><i class="fas fa-file-invoice"></i>
                            </div>
                            <div>
                            <div class="document-name">
                                Property Tax Receipt
                            </div>
                            <div class="document-size">
                                1.2 MB • PDF
                            </div>
                            </div><button class="btn btn-outline" type="button"> <i class="fas fa-download"></i> <span>Download</span> </button>
                            </div>
                            <div class="document-card">
                            <div class="document-icon"><i class="fas fa-file-alt"></i>
                            </div>
                            <div>
                            <div class="document-name">
                                NOC Certificate
                            </div>
                            <div class="document-size">
                                645 KB • PDF
                            </div>
                            </div><button class="btn btn-outline" type="button"> <i class="fas fa-download"></i> <span>Download</span> </button>
                            </div>
                            <div class="document-card">
                            <div class="document-icon"><i class="fas fa-car"></i>
                            </div>
                            <div>
                            <div class="document-name">
                                Vehicle Registration
                            </div>
                            <div class="document-size">
                                421 KB • PDF
                            </div>
                            </div><button class="btn btn-outline" type="button"> <i class="fas fa-download"></i> <span>Download</span> </button>
                            </div>
                            <div class="document-card">
                            <div class="document-icon"><i class="fas fa-shield-alt"></i>
                            </div>
                            <div>
                            <div class="document-name">
                                Insurance Policy
                            </div>
                            <div class="document-size">
                                3.1 MB • PDF
                            </div>
                            </div><button class="btn btn-outline" type="button"> <i class="fas fa-download"></i> <span>Download</span> </button>
                            </div>
                            </div> -->
                        <!-- </div> -->
                        
                        <!-- Maintenance History Tab -->
                        <!-- <div class="tab-panel" id="maintenance">
                            <h3 class="section-title">
                                <i class="fas fa-history"></i> 
                                <span>Payment History</span>
                            </h3>

                            <p class="info-text">This Feature is coming soon.</p> -->
                            <!-- <div class="maintenance-timeline">
                            <div class="timeline-item">
                            <div class="timeline-dot"></div>
                            <div class="timeline-content">
                            <div class="timeline-header">
                                <div class="timeline-month">
                                December 2024
                                </div>
                                <div class="timeline-amount">
                                ₹7,500
                                </div>
                            </div>
                            <div class="timeline-details">
                                <div><strong>Payment Date:</strong> Dec 5, 2024
                                </div>
                                <div><strong>Method:</strong> Online Transfer
                                </div>
                                <div><strong>Status:</strong> <span class="badge success">Paid</span>
                                </div>
                                <div><strong>Receipt:</strong> #R-2024-12-301
                                </div>
                            </div>
                            </div>
                            </div>
                            <div class="timeline-item">
                            <div class="timeline-dot"></div>
                            <div class="timeline-content">
                            <div class="timeline-header">
                                <div class="timeline-month">
                                November 2024
                                </div>
                                <div class="timeline-amount">
                                ₹7,500
                                </div>
                            </div>
                            <div class="timeline-details">
                                <div><strong>Payment Date:</strong> Nov 8, 2024
                                </div>
                                <div><strong>Method:</strong> Cheque
                                </div>
                                <div><strong>Status:</strong> <span class="badge success">Paid</span>
                                </div>
                                <div><strong>Receipt:</strong> #R-2024-11-301
                                </div>
                            </div>
                            </div>
                            </div>
                            <div class="timeline-item">
                            <div class="timeline-dot"></div>
                            <div class="timeline-content">
                            <div class="timeline-header">
                                <div class="timeline-month">
                                October 2024
                                </div>
                                <div class="timeline-amount">
                                ₹7,500
                                </div>
                            </div>
                            <div class="timeline-details">
                                <div><strong>Payment Date:</strong> Oct 6, 2024
                                </div>
                                <div><strong>Method:</strong> Cash
                                </div>
                                <div><strong>Status:</strong> <span class="badge success">Paid</span>
                                </div>
                                <div><strong>Receipt:</strong> #R-2024-10-301
                                </div>
                            </div>
                            </div>
                            </div>
                            <div class="timeline-item">
                            <div class="timeline-dot"></div>
                            <div class="timeline-content">
                            <div class="timeline-header">
                                <div class="timeline-month">
                                September 2024
                                </div>
                                <div class="timeline-amount">
                                ₹7,500
                                </div>
                            </div>
                            <div class="timeline-details">
                                <div><strong>Payment Date:</strong> Sep 10, 2024
                                </div>
                                <div><strong>Method:</strong> Online Transfer
                                </div>
                                <div><strong>Status:</strong> <span class="badge success">Paid</span>
                                </div>
                                <div><strong>Receipt:</strong> #R-2024-09-301
                                </div>
                            </div>
                            </div>
                            </div>
                            <div class="timeline-item">
                            <div class="timeline-dot"></div>
                            <div class="timeline-content">
                            <div class="timeline-header">
                                <div class="timeline-month">
                                August 2024
                                </div>
                                <div class="timeline-amount">
                                ₹7,500
                                </div>
                            </div>
                            <div class="timeline-details">
                                <div><strong>Payment Date:</strong> Aug 7, 2024
                                </div>
                                <div><strong>Method:</strong> Online Transfer
                                </div>
                                <div><strong>Status:</strong> <span class="badge success">Paid</span>
                                </div>
                                <div><strong>Receipt:</strong> #R-2024-08-301
                                </div>
                            </div>
                            </div>
                            </div>
                            </div> -->
                        <!-- </div> -->
                    </div>
                </div>
            </div>
        </main>
        <!-- Footer -->
        <?php 
            require_once '../../assets/elements/footer.php';
        ?>
    </div>
    <!-- Bootstrap JS -->
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js" integrity="sha384-YvpcrYf0tY3lHB60NNkmXc5s9fDVZLESaAA55NDzOxhy9GkcIdslK1eN7N6jIeHz" crossorigin="anonymous"></script>
    <script src="../../assets/js/login-modal.js"></script>
    <script>
        // Toggle password visibility for Change Password form
        document.addEventListener('DOMContentLoaded', function() {
            // Toggle New Password
            const toggleNewPassword = document.getElementById('toggleNewPassword');
            const newPasswordInput = document.getElementById('newPassword');
            
            if (toggleNewPassword && newPasswordInput) {
                toggleNewPassword.addEventListener('click', function(e) {
                    e.preventDefault();
                    e.stopPropagation();
                    
                    const currentType = newPasswordInput.getAttribute('type');
                    const newType = currentType === 'password' ? 'text' : 'password';
                    
                    newPasswordInput.setAttribute('type', newType);
                    
                    const icon = this.querySelector('i');
                    if (icon) {
                        if (newType === 'text') {
                            icon.classList.remove('fa-eye');
                            icon.classList.add('fa-eye-slash');
                        } else {
                            icon.classList.remove('fa-eye-slash');
                            icon.classList.add('fa-eye');
                        }
                    }
                    
                    return false;
                });
            }
            
            // Toggle Confirm Password
            const toggleConfirmPassword = document.getElementById('toggleConfirmPassword');
            const confirmPasswordInput = document.getElementById('confirmPassword');
            
            if (toggleConfirmPassword && confirmPasswordInput) {
                toggleConfirmPassword.addEventListener('click', function(e) {
                    e.preventDefault();
                    e.stopPropagation();
                    
                    const currentType = confirmPasswordInput.getAttribute('type');
                    const newType = currentType === 'password' ? 'text' : 'password';
                    
                    confirmPasswordInput.setAttribute('type', newType);
                    
                    const icon = this.querySelector('i');
                    if (icon) {
                        if (newType === 'text') {
                            icon.classList.remove('fa-eye');
                            icon.classList.add('fa-eye-slash');
                        } else {
                            icon.classList.remove('fa-eye-slash');
                            icon.classList.add('fa-eye');
                        }
                    }
                    
                    return false;
                });
            }
        });
        
        // Simple tabs handler for custom tabs markup
        (function() {
            const btns = document.querySelectorAll('.tabs-header .tab-btn');
            const panels = document.querySelectorAll('.tabs-content .tab-panel');
            btns.forEach(btn => {
                btn.addEventListener('click', () => {
                    const target = btn.getAttribute('data-tab');
                    // Toggle active button
                    btns.forEach(b => b.classList.remove('active'));
                    btn.classList.add('active');
                    // Toggle active panel
                    panels.forEach(p => {
                        if (p.id === target) {
                            p.classList.add('active');
                        } else {
                            p.classList.remove('active');
                        }
                    });
                });
            });
        })();
    </script>
    <script>(function () { function c() { var b = a.contentDocument || a.contentWindow.document; if (b) { var d = b.createElement('script'); d.innerHTML = "window.__CF$cv$params={r:'9aaab895b1716091',t:'MTc2NTE4MDc0Mi4wMDAwMDA='};var a=document.createElement('script');a.nonce='';a.src='/cdn-cgi/challenge-platform/scripts/jsd/main.js';document.getElementsByTagName('head')[0].appendChild(a);"; b.getElementsByTagName('head')[0].appendChild(d) } } if (document.body) { var a = document.createElement('iframe'); a.height = 1; a.width = 1; a.style.position = 'absolute'; a.style.top = 0; a.style.left = 0; a.style.border = 'none'; a.style.visibility = 'hidden'; document.body.appendChild(a); if ('loading' !== document.readyState) c(); else if (window.addEventListener) document.addEventListener('DOMContentLoaded', c); else { var e = document.onreadystatechange || function () { }; document.onreadystatechange = function (b) { e(b); 'loading' !== document.readyState && (document.onreadystatechange = e, c()) } } } })();</script>
</body>
</html>
<?php } } ?>