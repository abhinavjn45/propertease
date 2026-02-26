<?php 
    session_start();

    require_once '../admin/assets/includes/config/config.php';

    require_once '../admin/assets/includes/functions/data_fetcher.php';
    require_once '../admin/assets/includes/functions/user_auth.php';
    require_once './admin/assets/includes/functions/utility_functions.php';
    require_once './admin/assets/includes/functions/send_emails.php';

    if (!isset($_SESSION['member_email']) && !isset($_SESSION['office_member_unique_id'])) {
        header("Location: " . get_site_option('site_url'));
        exit();
    } else {
        // Fetch AGBM details
        if (!isset($_GET['agbm_id']) && !is_numeric($_GET['agbm_id'])) {
            // Redirect to agbms page if id is not valid
            header("Location: " . get_site_option('site_url') . "agbms/");
            exit();
        } else {
            $agbm_id = intval($_GET['agbm_id']);
            $agbm_details = fetch_single_agbm($agbm_id);

            if (!$agbm_details) {
                header("Location: " . get_site_option('site_url') . "agbms/");
                exit();
            } else {
?>
<!DOCTYPE html>
<html lang="en" style="height: 100%;">

<head>
    <meta charset="UTF-8">
    <title><?= htmlspecialchars($agbm_details['agbm_title']) ?> - <?= htmlspecialchars(get_site_option('site_title')) ?></title>
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <!-- Bootstrap CSS (CDN) -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet"
        integrity="sha384-QWTKZyjpPEjISv5WaRU9OFeRpok6YctnYmDr5pNlyT2bRjXh0JMhjY6hW+ALEwIH" crossorigin="anonymous">
    <!-- Font Awesome -->
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.1/css/all.min.css"
        integrity="sha512-DTOQO9RWCH3ppGqcWaEA1BIZOC6xxalwEsw9c2QQeAIftl+Vegovlnee1c9QX4TctnWMn13TZye+giMm8e2LwA==" crossorigin="anonymous" referrerpolicy="no-referrer">
    <!-- Global Styles -->
    <link rel="stylesheet" href="../assets/css/global.css">
    <link rel="stylesheet" href="../assets/css/topbar.css">
    <link rel="stylesheet" href="../assets/css/header.css">
    <link rel="stylesheet" href="../assets/css/footer.css">
    <!-- Page-specific Styles -->
    <link rel="stylesheet" href="../assets/css/style_single-announcement.css">
    <link rel="stylesheet" href="../assets/css/login-modal.css">
    <!-- Password Toggle Function (MUST be before components.js) -->
    <script src="../assets/js/toggle-password.js"></script>
</head>

<body>
    <div class="app-wrapper">
        <header>
            <?php 
                require_once '../assets/elements/topbar.php';
            ?>

            <!-- Header -->
            <?php 
                require_once '../assets/elements/header.php';
            ?>

            <!-- Navigation -->
            <?php 
                require_once '../assets/elements/navbar.php';
            ?>
        </header>

        <!-- Hero Section -->
        <section class="hero-section" aria-labelledby="page-title">
            <div class="hero-inner">
                <div class="hero-breadcrumb">
                    <a href="<?= get_site_option('site_url') ?>">Home</a> / <a href="<?= get_site_option('site_url') . 'notices/' ?>">Announcements</a> / <?= htmlspecialchars(substr($agbm_details['agbm_title'], 0, 40)) . "..." ?>
                </div>
                <h1 class="hero-title" id="page-title"><?= htmlspecialchars($agbm_details['agbm_title']) ?></h1>
                <p class="hero-subtitle" id="hero-subheading"><?= htmlspecialchars($agbm_details['agbm_single_line']) ?></p>
                <a href="<?= get_site_option('site_url') . 'agbms/' ?>" class="back-link">
                    <span>←</span>
                    <span>Back to All AGBMs</span>
                </a>
            </div>
        </section>
        <!-- Main Content -->
        <main aria-label="Announcement details">
            <div class="main-inner">
                <!-- Announcement Detail Card -->
                <article class="announcement-detail-card">
                    <!-- Header -->
                    <div class="announcement-header">
                        <!-- <div class="announcement-meta-row">
                            <span class="announcement-category" id="category"><?= htmlspecialchars(date("Y", strtotime($agbm_details['agbm_posted_on']))) ?></span>
                        </div> -->
                        <div class="announcement-meta-info">
                            <div class="meta-item">
                                <span class="meta-icon"><i class="fas fa-calendar-alt"></i></span>
                                <div>
                                    <span class="meta-label">Posted on:</span>
                                    <span id="announcement-date"><?= date("d F, Y", strtotime($agbm_details['agbm_posted_on'])) ?></span>
                                </div>
                            </div>
                            <div class="meta-item">
                                <span class="meta-icon"><i class="fas fa-user-edit"></i></span>
                                <div>
                                    <span class="meta-label">Posted by:</span>
                                    <span id="announcement-author">Office</span>
                                </div>
                            </div>
                            <!-- <div class="meta-item">
                                <span class="meta-icon"><i class="fas fa-eye"></i></span>
                                <div>
                                    <span class="meta-label">Views:</span>
                                    <span>247</span>
                                </div>
                            </div> -->
                        </div>
                    </div>
                    <?php 
                        if (($agbm_details['agbm_video_link'] !== NULL || !empty($agbm_details['agbm_video_link'])) && filter_var($agbm_details['agbm_video_link'], FILTER_VALIDATE_URL)) {
                            $agbm_video_url = htmlspecialchars($agbm_details['agbm_video_link']);
                            $agbm_year = date("Y", strtotime($agbm_details['agbm_posted_on']));
                            echo "
                                <div class='action-section' style='margin-bottom: 32px;'>
                                    <div class='action-title'>
                                        <i class='fas fa-video'></i> AGBM $agbm_year Video
                                    </div>
                                    <div class='action-buttons'>
                                        <iframe 
                                            src='$agbm_video_url'
                                            width='100%'
                                            height='480'
                                            allow='autoplay'
                                            allowfullscreen>
                                        </iframe>
                                    </div>
                                </div>
                            ";
                        }
                    ?>
                    <!-- Content -->
                    <div class="announcement-content" id="announcement-content">
                        <?= $agbm_details['agbm_content'] ?>
                    </div>
                    <!-- Action Section -->
                    <div class="action-section">
                        <div class="action-title">
                            <i class="fas fa-download"></i> Download Documents
                        </div>
                        <div class="action-buttons">
                            <?php 
                                if (!empty(htmlspecialchars($agbm_details['agbm_material']))) {
                                    echo "
                                        <a class='btn-action' href='" . get_site_option('dashboard_url') . "assets/uploads/documents/agbms/" . htmlspecialchars($agbm_details['agbm_material']) . "' download>
                                            <span><i class='fas fa-file-pdf'></i></span>
                                            <span>" . htmlspecialchars($agbm_details['agbm_material_title']) . "</span>
                                        </a>
                                    ";
                                }

                                fetch_additional_attachments('agbm', $agbm_id);
                            ?>
                        </div>
                    </div>
                </article>
                <!-- Contact Section -->
                <div class="contact-section">
                    <div class="contact-title">
                        <span><i class="fas fa-phone-alt"></i></span>
                        <span>Need More Information?</span>
                    </div>
                    <div class="contact-grid">
                        <div class="contact-item">
                            <div class="contact-icon">
                                <i class="fas fa-envelope"></i>
                            </div>
                            <div class="contact-details">
                                <div class="contact-label">
                                    Email Us
                                </div>
                                <div class="contact-value">
                                    <a href="mailto:<?= get_office_details('office_email_address') ?>"><?= get_office_details('office_email_address') ?></a>
                                </div>
                            </div>
                        </div>
                        <div class="contact-item">
                            <div class="contact-icon">
                                <i class="fas fa-mobile-alt"></i>
                            </div>
                            <div class="contact-details">
                                <div class="contact-label">
                                    Call Us
                                </div>
                                <div class="contact-value">
                                    <a href="tel:<?= get_office_details('office_phone_number') ?>"><?= get_office_details('office_phone_number') ?></a>
                                </div>
                            </div>
                        </div>
                        <div class="contact-item">
                            <div class="contact-icon">
                                <i class="fas fa-clock"></i>
                            </div>
                            <div class="contact-details">
                                <div class="contact-label">
                                    Office Hours
                                </div>
                                <div class="contact-value">
                                    <?= get_office_hours() ?>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
                <!-- Related Announcements -->
                <div class="related-section">
                    <div class="related-title">
                        <i class="fas fa-thumbtack"></i> Related Announcements
                    </div>
                    <ul class="related-list">
                        <?= fetch_related_notices($agbm_id) ?>
                    </ul>
                </div>
            </div>
        </main>
        <!-- Footer -->
        <?php 
            require_once '../assets/elements/footer.php';
        ?>
    </div>
    <!-- Bootstrap JS -->
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js" integrity="sha384-YvpcrYf0tY3lHB60NNkmXc5s9fDVZLESaAA55NDzOxhy9GkcIdslK1eN7N6jIeHz" crossorigin="anonymous"></script>
    <script src="../assets/js/login-modal.js"></script>
    <script>(function () { function c() { var b = a.contentDocument || a.contentWindow.document; if (b) { var d = b.createElement('script'); d.innerHTML = "window.__CF$cv$params={r:'9aaab895b1716091',t:'MTc2NTE4MDc0Mi4wMDAwMDA='};var a=document.createElement('script');a.nonce='';a.src='/cdn-cgi/challenge-platform/scripts/jsd/main.js';document.getElementsByTagName('head')[0].appendChild(a);"; b.getElementsByTagName('head')[0].appendChild(d) } } if (document.body) { var a = document.createElement('iframe'); a.height = 1; a.width = 1; a.style.position = 'absolute'; a.style.top = 0; a.style.left = 0; a.style.border = 'none'; a.style.visibility = 'hidden'; document.body.appendChild(a); if ('loading' !== document.readyState) c(); else if (window.addEventListener) document.addEventListener('DOMContentLoaded', c); else { var e = document.onreadystatechange || function () { }; document.onreadystatechange = function (b) { e(b); 'loading' !== document.readyState && (document.onreadystatechange = e, c()) } } } })();</script>
</body>
</html>
<?php } } } ?>