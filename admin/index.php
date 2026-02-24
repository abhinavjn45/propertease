<?php 
    session_start();
    require_once './assets/includes/config/config.php';

    require_once './assets/includes/functions/data_fetcher.php';

    if (!isset($_SESSION['office_member_unique_id'])) {
        header("Location: " . get_site_option('site_url'));
        exit();
    } else {
        require_once './assets/includes/functions/utility_functions.php';
        require_once './assets/includes/functions/dashboard_functions.php';
        $logged_in_member = get_logged_in_member_details();

        if (!$logged_in_member) {
            header("Location: " . get_site_option('site_url'));
            exit();
        } else {
?>
<!-- meta tags and other links -->
<!DOCTYPE html>
<html lang="en" data-theme="light">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Dashboard - <?= get_site_option('site_title') ?></title>
    <link rel="icon" type="image/png" href="assets/images/favicon.png" sizes="16x16">
    <!-- remix icon font css  -->
    <link rel="stylesheet" href="assets/css/remixicon.css">
    <!-- BootStrap css -->
    <link rel="stylesheet" href="assets/css/lib/bootstrap.min.css">
    <!-- Apex Chart css -->
    <link rel="stylesheet" href="assets/css/lib/apexcharts.css">
    <!-- Data Table css -->
    <link rel="stylesheet" href="assets/css/lib/dataTables.min.css">
    <!-- Text Editor css -->
    <link rel="stylesheet" href="assets/css/lib/editor-katex.min.css">
    <link rel="stylesheet" href="assets/css/lib/editor.atom-one-dark.min.css">
    <link rel="stylesheet" href="assets/css/lib/editor.quill.snow.css">
    <!-- Date picker css -->
    <link rel="stylesheet" href="assets/css/lib/flatpickr.min.css">
    <!-- Calendar css -->
    <link rel="stylesheet" href="assets/css/lib/full-calendar.css">
    <!-- Vector Map css -->
    <link rel="stylesheet" href="assets/css/lib/jquery-jvectormap-2.0.5.css">
    <!-- Popup css -->
    <link rel="stylesheet" href="assets/css/lib/magnific-popup.css">
    <!-- Slick Slider css -->
    <link rel="stylesheet" href="assets/css/lib/slick.css">
    <!-- main css -->
    <link rel="stylesheet" href="assets/css/style.css">
    <!-- SweetAlert2 -->
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
    <!-- TinyMCE -->
    <script src="https://cdn.tiny.cloud/1/h56qb6ds8eil0mtw5namy87mh2xda6ze84nexdt5calbv81o/tinymce/8/tinymce.min.js" referrerpolicy="origin" crossorigin="anonymous"></script>
</head>
    <body>
        <?php 
            require_once './assets/elements/sidebar.php';
        ?>

        <main class="dashboard-main">
            <?php 
                require_once './assets/elements/header.php';
            ?>

          <div class="dashboard-main-body">
            <?php 
                // Load dashboard page by default
                if (!isset($_GET['page']) || $_GET['page'] == 'dashboard') {
                    require_once './assets/pages/dashboard/index.php';
                }


                // -------------------------------------------------------------------------------------------
                // MEMBERS MANAGEMENT PAGES LOADING STARTS HERE
                // -------------------------------------------------------------------------------------------

                // All Members Page
                if (isset($_GET['page']) && $_GET['page'] == 'members-management') {
                    require_once './assets/pages/members/members-management/index.php';
                }

                // Add Member Page
                if (isset($_GET['page']) && $_GET['page'] == 'add-member') {
                    require_once './assets/pages/members/add-member/index.php';
                }

                // Edit Member Page
                if (isset($_GET['page']) && $_GET['page'] == 'edit-member') {
                    if (isset($_GET['member_id']) || !empty(trim($_GET['member_id']))) {
                        require_once './assets/pages/members/edit-member/index.php';
                    } else {
                        header('Location: ' . get_site_option('dashboard_url') . '?page=members-management');
                        exit;
                    }
                }


                // -------------------------------------------------------------------------------------------
                // ANNOUNCEMENTS MANAGEMENT PAGES LOADING STARTS HERE
                // -------------------------------------------------------------------------------------------

                // All Announcements Page
                if (isset($_GET['page']) && $_GET['page'] == 'announcements-management') {
                    require_once './assets/pages/announcements/announcements-management/index.php';
                }
                
                // Add Announcement Page
                if (isset($_GET['page']) && $_GET['page'] == 'add-announcement') {
                    require_once './assets/pages/announcements/add-announcement/index.php';
                }

                // Edit Announcement Page
                if (isset($_GET['page']) && $_GET['page'] == 'edit-announcement') {
                    if (isset($_GET['announcement_id']) || !empty(trim($_GET['announcement_id']))) {
                        require_once './assets/pages/announcements/edit-announcement/index.php';
                    } else {
                        header('Location: ' . get_site_option('dashboard_url') . '?page=announcements-management');
                        exit;
                    }
                }


                // -------------------------------------------------------------------------------------------
                // NOTICES MANAGEMENT PAGES LOADING STARTS HERE
                // -------------------------------------------------------------------------------------------

                // All Notices Page
                if (isset($_GET['page']) && $_GET['page'] == 'notices-management') {
                    require_once './assets/pages/notices/notices-management/index.php';
                }
                
                // Add Notice Page
                if (isset($_GET['page']) && $_GET['page'] == 'add-notice') {
                    require_once './assets/pages/notices/add-notice/index.php';
                }

                // Edit Notice Page
                if (isset($_GET['page']) && $_GET['page'] == 'edit-notice') {
                    if (isset($_GET['notice_id']) || !empty(trim($_GET['notice_id']))) {
                        require_once './assets/pages/notices/edit-notice/index.php';
                    } else {
                        header('Location: ' . get_site_option('dashboard_url') . '?page=notices-management');
                        exit;
                    }
                }

                // All Notice Categories Page
                if (isset($_GET['page']) && $_GET['page'] == 'notice-categories') {
                    require_once './assets/pages/notices/notice-categories/index.php';
                }

                // Edit Notice Category Page
                if (isset($_GET['page']) && $_GET['page'] == 'edit-notice-category') {
                    if (isset($_GET['notice_category_id']) && !empty(trim($_GET['notice_category_id']))) {
                        require_once './assets/pages/notices/edit-notice-category/index.php';
                    } else {
                        header('Location: ' . get_site_option('dashboard_url') . '?page=notice-categories');
                        exit;
                    }
                }


                // -------------------------------------------------------------------------------------------
                // BILLS MANAGEMENT PAGES LOADING STARTS HERE
                // -------------------------------------------------------------------------------------------

                // All Bills Page
                if (isset($_GET['page']) && $_GET['page'] == 'bills-management') {
                    require_once './assets/pages/bills/bills-management/index.php';
                }

                // Add Bill Page
                if (isset($_GET['page']) && $_GET['page'] == 'add-bill') {
                    require_once './assets/pages/bills/add-bill/index.php';
                }

                // Edit Bill Page
                if (isset($_GET['page']) && $_GET['page'] == 'edit-bill') {
                    if (isset($_GET['bill_id']) && !empty(trim($_GET['bill_id']))) {
                        require_once './assets/pages/bills/edit-bill/index.php';
                    } else {
                        header('Location: ' . get_site_option('dashboard_url') . '?page=bills-management');
                        exit;
                    }
                }


                // -------------------------------------------------------------------------------------------
                // AGBMS MANAGEMENT PAGES LOADING STARTS HERE
                // -------------------------------------------------------------------------------------------

                // All AGBMs Management Page
                if (isset($_GET['page']) && $_GET['page'] == 'agbms-management') {
                    require_once './assets/pages/agbms/agbms-management/index.php';
                }

                // Add AGBM Page
                if (isset($_GET['page']) && $_GET['page'] == 'add-agbm') {
                    require_once './assets/pages/agbms/add-agbm/index.php';
                }

                // Edit AGBM Page
                if (isset($_GET['page']) && $_GET['page'] == 'edit-agbm') {
                    if (isset($_GET['agbm_id']) && !empty(trim($_GET['agbm_id']))) {
                        require_once './assets/pages/agbms/edit-agbm/index.php';
                    } else {
                        header('Location: ' . get_site_option('dashboard_url') . '?page=agbms-management');
                        exit;
                    }
                }


                // ----------------------------------------------------------------------------------------
                // GALLERY MANAGEMENT PAGES LOADING STARTS HERE
                // ----------------------------------------------------------------------------------------

                // All Gallery Images Page
                if (isset($_GET['page']) && $_GET['page'] == 'gallery-management') {
                    require_once './assets/pages/gallery/gallery-management/index.php';
                }

                if (isset($_GET['page']) && $_GET['page'] == 'add-gallery-image') {
                    require_once './assets/pages/gallery/add-gallery-image/index.php';
                }


                // -------------------------------------------------------------------------------------------
                // EMAILS MANAGEMENT PAGES LOADING STARTS HERE
                // -------------------------------------------------------------------------------------------

                // All Emails Page
                if (isset($_GET['page']) && $_GET['page'] == 'emails-management') {
                    require_once './assets/pages/emails/emails-management/index.php';
                }
            ?>
            
          </div>
            <?php 
                require_once './assets/elements/footer.php';
            ?>
        </main>
        <!-- jQuery library js -->
        <script src="assets/js/lib/jquery-3.7.1.min.js"></script>
        <!-- Bootstrap js -->
        <script src="assets/js/lib/bootstrap.bundle.min.js"></script>
        <!-- Apex Chart js -->
        <script src="assets/js/lib/apexcharts.min.js"></script>
        <!-- Data Table js -->
        <script src="assets/js/lib/dataTables.min.js"></script>
        <!-- Iconify Font js -->
        <script src="assets/js/lib/iconify-icon.min.js"></script>
        <!-- jQuery UI js -->
        <script src="assets/js/lib/jquery-ui.min.js"></script>
        <!-- Vector Map js -->
        <script src="assets/js/lib/jquery-jvectormap-2.0.5.min.js"></script>
        <script src="assets/js/lib/jquery-jvectormap-world-mill-en.js"></script>
        <!-- Popup js -->
        <script src="assets/js/lib/magnifc-popup.min.js"></script>
        <!-- Slick Slider js -->
        <script src="assets/js/lib/slick.min.js"></script>
        <!-- main js -->
        <script src="assets/js/app.js"></script>

        <script src="assets/js/homeTwoChart.js"></script>
        <script>
            // Initialize DataTables
            let membersTable = new DataTable('#membersDataTable');
            let announcementsTable = new DataTable('#announcementsDataTable');
            let noticesTable = new DataTable('#noticesDataTable');
            let noticeCategoriesTable = new DataTable('#noticeCategoriesDataTable');
            let billsTable = new DataTable('#billsDataTable');
            let agbmsTable = new DataTable('#agbmsDataTable');
            let emailsTable = new DataTable('#emailLogsDataTable');
        </script>
    </body>
</html>
<?php } } ?>