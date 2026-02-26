<?php 
    session_start();
    require_once './admin/assets/includes/config/config.php';

    require_once './admin/assets/includes/functions/data_fetcher.php';
    require_once './admin/assets/includes/functions/user_auth.php';
    require_once './admin/assets/includes/functions/utility_functions.php';
    require_once './admin/assets/includes/functions/send_emails.php';
?>
<!doctype html>
<html lang="en" style="height: 100%;">
    <head>
        <meta charset="UTF-8">
        <title><?= htmlspecialchars(get_site_option('site_title')) ?> - Home</title>
        <meta name="viewport" content="width=device-width, initial-scale=1">
        <!-- Bootstrap CSS (CDN) -->
        <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-QWTKZyjpPEjISv5WaRU9OFeRpok6YctnYmDr5pNlyT2bRjXh0JMhjY6hW+ALEwIH" crossorigin="anonymous">
        <!-- Font Awesome -->
        <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.1/css/all.min.css"
            integrity="sha512-DTOQO9RWCH3ppGqcWaEA1BIZOC6xxalwEsw9c2QQeAIftl+Vegovlnee1c9QX4TctnWMn13TZye+giMm8e2LwA==" crossorigin="anonymous" referrerpolicy="no-referrer">
        <!-- Custom CSS Files -->
        <link rel="stylesheet" href="assets/css/global.css">
        <link rel="stylesheet" href="assets/css/topbar.css">
        <link rel="stylesheet" href="assets/css/header.css">
        <link rel="stylesheet" href="assets/css/hero.css">
        <link rel="stylesheet" href="assets/css/sections.css">
        <link rel="stylesheet" href="assets/css/footer.css">
        <link rel="stylesheet" href="assets/css/management.css">
        <link rel="stylesheet" href="assets/css/login-modal.css">
    </head>
    <body>
        <div class="app-wrapper">
            <header>
                <?php 
                    require_once './assets/elements/topbar.php';
                ?>

                <!-- Header -->
                <?php 
                    require_once './assets/elements/header.php';
                ?>

                <!-- Navigation -->
                <?php 
                    require_once './assets/elements/navbar.php';
                ?>
            </header>

            <!-- Hero Section -->
            <section id="hero" class="hero-section" aria-labelledby="hero-heading" style="background: linear-gradient(rgba(0, 0, 0, 0.4), rgba(0, 0, 0, 0.4)),
              url('<?php echo get_hero_section_data('background_image'); ?>') center/cover no-repeat;">
                <div class="hero-inner">
                    <div class="hero-copy">
                        <div class="hero-badges">
                            <div class="hero-badge">
                                <span class="hero-badge-dot"></span> <?php echo get_hero_section_data('badge_1'); ?>
                            </div>
                            <div class="hero-badge">
                                <span class="hero-badge-dot"></span> <?php echo get_hero_section_data('badge_2'); ?>
                            </div>
                        </div>
                        <h2 class="hero-title" id="hero-heading"><?php echo get_hero_section_data('main_heading'); ?></h2>
                        <p class="hero-subtitle" id="hero-subheading"><?php echo get_hero_section_data('hero_paragraph'); ?></p>
                        <div class="hero-cta-group" role="group" aria-label="Primary actions">
                            <a href="<?php echo get_hero_section_data('primary_button_link'); ?>" class="btn btn-primary-hero">
                                <?php echo get_hero_section_data('primary_button_text'); ?>
                            </a>
                            <a href="<?php echo get_hero_section_data('secondary_button_link'); ?>" class="btn btn-outline-hero">
                                <?php echo get_hero_section_data('secondary_button_text'); ?>
                            </a>
                        </div>
                        <p class="hero-note mb-0"><?php echo get_hero_section_data('sub_paragraph'); ?></p>
                    </div>
                    <aside class="hero-stats-card" aria-label="Society statistics">
                        <div class="hero-stats-header">
                            <div class="hero-stats-title">
                                Key Statistics
                            </div>
                        </div>
                        <div class="hero-stats-grid">
                            <div class="hero-stat" aria-label="Number of flats">
                                <div class="hero-stat-label">
                                    Registered Flats
                                </div>
                                <div class="hero-stat-value">
                                    <?php  
                                        $stmt = $con->prepare("SELECT COUNT(*) AS total_registered_flats FROM members WHERE member_status = 'active' AND member_email != 'demo.member@gmail.com'");
                                        $stmt->execute();
                                        $result = $stmt->get_result();
                                        $data = $result->fetch_assoc();
                                        echo $data['total_registered_flats'];
                                    ?>
                                </div>
                                <div class="hero-stat-chip">
                                    In 6 residential blocks
                                </div>
                            </div>
                            <div class="hero-stat" aria-label="Number of resident members">
                                <div class="hero-stat-label">
                                    Resident Members
                                </div>
                                <div class="hero-stat-value">
                                    <?= "N/A" ?>
                                </div>
                                <div class="hero-stat-chip">
                                    Including senior citizens
                                </div>
                            </div>
                            <div class="hero-stat" aria-label="Occupancy rate">
                                <div class="hero-stat-label">
                                    Occupancy
                                </div>
                                <div class="hero-stat-value">
                                    <?= "N/A" ?>
                                </div>
                                <div class="hero-stat-chip">
                                    Actively inhabited units
                                </div>
                            </div>
                            <div class="hero-stat" aria-label="Green area">
                                <div class="hero-stat-label">
                                    <!--Green Area-->
                                </div>
                                <div class="hero-stat-value">
                                    <!--3.2-->
                                </div>
                                <div class="hero-stat-chip">
                                    <!--Acres of landscaped gardens-->
                                </div>
                            </div>
                        </div>
                        <p class="hero-stats-footer mb-0">Figures are indicative and subject to verification as per statutory records maintained by the Society Office.</p>
                    </aside>
                </div>
            </section>

            <!-- Main Content -->
            <main aria-label="Society information">
                <div class="main-inner">
                    <div class="row g-3">
                        <!-- About Section -->
                        <div class="col-12 col-lg-4">
                            <section id="about" class="section-card" aria-labelledby="about-section-title">
                                <h2 class="section-title" id="about-section-title">About the Society</h2>
                                <p class="section-subtitle mb-2">Overview of governance, objectives and legal status.</p>
                                <p class="about-text" id="about-text">Jagaran Cooperative Group Housing Society is a duly registered housing society under the Maharashtra Co-operative Societies Act, 1960. The Society is committed to providing safe, clean and citizen-friendly living conditions for all its members. The Managing Committee functions in accordance with the approved bye-laws and directions issued by the Office of the Registrar of Co-operative Societies and relevant urban local bodies.</p>
                                <p class="about-text mb-0">Details of Annual General Meetings, audited statements, and key resolutions are made available to members through official notices and circulars published on this portal.</p>
                                <div class="mt-3 d-flex">
                                    <a class="btn-link float-right" href="about.html">Read More</a>
                                </div>
                            </section>
                        </div>

                        <!-- Management & Announcements -->
                        <div class="col-12 col-lg-8">
                            <!-- Management Team -->
                            <section class="section-card" aria-labelledby="management-section-title">
                                <div class="d-flex align-items-center justify-content-between mb-2">
                                    <h2 class="section-title mb-0" id="management-section-title">Management Committee</h2>
                                    <a class="btn-link" href="./committee-members/">View All Members</a>
                                </div>
                                <p class="section-subtitle mb-3">Meet our dedicated leadership team</p>
                                <div class="management-team-grid">
                                    <?= fetch_committee_members('homepage', 4); ?>
                                </div>
                            </section>

                            <!-- Latest Announcements -->
                            <section id="announcements" class="section-card mt-3" aria-labelledby="announcement-section-title">
                                <h2 class="section-title" id="announcement-section-title">Latest Announcements</h2>
                                <p class="section-subtitle">Official notices, circulars and important information for residents.</p>
                                <ul class="announcement-list" aria-label="List of latest announcements">
                                    <?= fetch_notice('homepage', 'published', 'notice_id', 'DESC', 3) ?>
                                </ul>

                                <?php 
                                    if (get_total_numbers('notices', 'published') > 3) {
                                        echo "
                                            <div class='d-flex mt-2'>
                                                <a class='btn-link float-right' href='" . get_site_option('site_url') . "notices/'>View All Announcements</a>
                                            </div>
                                        ";
                                    }
                                ?>
                            </section>
                        </div>

                        <!-- Quick Links -->
                        <div class="col-12 col-lg-4">
                            <section id="links" class="section-card" aria-labelledby="quick-links-title">
                                <h2 class="section-title" id="quick-links-title">Quick Links</h2>
                                <div class="quick-links-grid" aria-label="Important quick links">
                                    <a href="#" class="quick-link" role="button">
                                        <span class="quick-link-icon" aria-hidden="true"><i class="fas fa-file-alt"></i></span> Bye-laws &amp; Rules
                                    </a>
                                    <a href="#" class="quick-link" role="button">
                                        <span class="quick-link-icon" aria-hidden="true"><i class="fas fa-edit"></i></span> Forms &amp; Applications
                                    </a>
                                    <a href="#" class="quick-link" role="button">
                                        <span class="quick-link-icon" aria-hidden="true"><i class="fas fa-tint"></i></span> Utility Complaints
                                    </a>
                                    <a href="#" class="quick-link" role="button">
                                        <span class="quick-link-icon" aria-hidden="true"><i class="fas fa-calendar-alt"></i></span> Event Calendar
                                    </a>
                                    <a href="#" class="quick-link" role="button">
                                        <span class="quick-link-icon" aria-hidden="true"><i class="fas fa-chart-bar"></i></span> AGM Reports
                                    </a>
                                    <a href="#" class="quick-link" role="button">
                                        <span class="quick-link-icon" aria-hidden="true"><i class="fas fa-bullhorn"></i></span> Suggestion Box
                                    </a>
                                </div>
                            </section>
                        </div>

                        <!-- Contact Info -->
                        <div class="col-12 col-lg-8">
                            <section id="contact" class="section-card" aria-labelledby="contact-section-title">
                                <h2 class="section-title" id="contact-section-title">Contact Information</h2>
                                <div class="contact-row">
                                    <div class="contact-block">
                                        <div class="contact-label">
                                            Society Office
                                        </div>
                                        <p class="contact-value mb-2">
                                            <?= get_office_address() ?>
                                        </p>
                                    </div>
                                    <div class="contact-block">
                                        <div class="contact-label">
                                            Office Timings
                                        </div>
                                        <p class="contact-value mb-2">
                                            <?= get_office_hours() ?>
                                        </p>
                                    </div>
                                    <div class="contact-block">
                                        <div class="contact-label">
                                            Helpline &amp; Email
                                        </div>
                                        <p class="contact-value mb-1">
                                            Phone: <a href="tel:<?=  get_office_details('office_phone_number') ?>" class="contact-link"><?=  get_office_details('office_phone_number') ?></a><br>
                                            Email: <a href="mailto:<?= get_office_details('office_email_address') ?>" class="contact-link"> <?= get_office_details('office_email_address') ?> </a>
                                        </p>
                                        <p class="contact-value mb-0">For emergencies, please contact the security desk or local emergency services directly.</p>
                                    </div>
                                </div>
                            </section>
                        </div>
                    </div>
                </div>
            </main>

            <!-- Footer -->
            <?php 
                require_once './assets/elements/footer.php';
            ?>
        </div>

        <!-- Bootstrap JS (for navbar hamburger functionality) -->
        <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js" integrity="sha384-YvpcrYf0tY3lHB60NNkmXc5s9fDVZLESaAA55NDzOxhy9GkcIdslK1eN7N6jIeHz" crossorigin="anonymous"></script>

        <script src="assets/js/login-modal.js"></script>
    </body>
</html>