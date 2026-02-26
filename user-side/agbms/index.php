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
?>
<!doctype html>
<html lang="en" style="height: 100%;">
    <head>
        <meta charset="UTF-8">
        <title>Annual General Body Meetings - <?= htmlspecialchars(get_site_option('site_title')) ?></title>
        <meta name="viewport" content="width=device-width, initial-scale=1">
        <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-QWTKZyjpPEjISv5WaRU9OFeRpok6YctnYmDr5pNlyT2bRjXh0JMhjY6hW+ALEwIH" crossorigin="anonymous">
        <!-- Font Awesome -->
        <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.1/css/all.min.css" integrity="sha512-DTOQO9RWCH3ppGqcWaEA1BIZOC6xxalwEsw9c2QQeAIftl+Vegovlnee1c9QX4TctnWMn13TZye+giMm8e2LwA==" crossorigin="anonymous" referrerpolicy="no-referrer">
        <link rel="stylesheet" href="../assets/css/global.css">
        <link rel="stylesheet" href="../assets/css/topbar.css">
        <link rel="stylesheet" href="../assets/css/header.css">
        <link rel="stylesheet" href="../assets/css/sections.css">
        <link rel="stylesheet" href="../assets/css/footer.css">
        <link rel="stylesheet" href="../assets/css/style_notices.css">
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
                        <a href="index.html">Home</a>
                        /
                        <span id="page-title">Annual General Body Meetings</span>
                    </div>
                    <h2 class="hero-title" id="hero-heading">Annual General Body Meetings</h2>
                    <p class="hero-subtitle" id="hero-subheading">
                        Access all official details, minutes, meeting videos, and important communications issued by the Managing Committee.
                    </p>
                </div>
            </section>

            <!-- Main Content -->
            <main aria-label="Notices and circulars">
                <div class="main-inner">
                    <!-- Filter and Search -->
                    <section class="filter-search-section" aria-label="Filter and search notices">
                        <div class="search-box">
                            <input
                                type="text"
                                class="search-input"
                                id="searchInput"
                                placeholder="Search notices by title or content..."
                                aria-label="Search notices"
                            >
                            <button class="search-btn" id="searchBtn"><i class="fas fa-search"></i> Search</button>
                        </div>
                    </section>

                    <!-- Recent Notices Section -->
                    <div class="section-header">
                        <div class="section-icon" aria-hidden="true"><i class="fas fa-thumbtack"></i></div>
                        <h3 class="section-title">This Year</h3>
                        <span class="section-count"><?= date('(Y)') ?></span>
                    </div>

                    <div class="notices-container" id="noticesContainer">
                        <?= fetch_agbm('list_view', 'published', 'agbm_id', 'DESC') ?>
                    </div>

                    <!-- Archive Section -->
                    <section class="archive-section" aria-labelledby="archive-title">
                        <div class="archive-toggle" id="archiveToggle" role="button" tabindex="0" aria-expanded="false">
                            <span class="archive-toggle-text" id="archive-title"><i class="fas fa-box"></i> View Archived AGBMs (Older than 1 Year)</span>
                            <span class="archive-toggle-icon" id="archiveIcon">▼</span>
                        </div>
                        <div class="archive-content" id="archiveContent">
                            <div class="notices-container">
                                <?= fetch_agbm('list_view', 'published', 'agbm_id', 'DESC', null, true) ?>
                            </div>
                        </div>
                    </section>
                </div>
            </main>

            <!-- Footer -->
            <?php 
                require_once '../assets/elements/footer.php';
            ?>
        </div>

        <!-- Bootstrap JS (for navbar hamburger functionality) -->
        <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js" integrity="sha384-YvpcrYf0tY3lHB60NNkmXc5s9fDVZLESaAA55NDzOxhy9GkcIdslK1eN7N6jIeHz" crossorigin="anonymous"></script>
        <script src="../assets/js/notices.js"></script>
        <script src="../assets/js/login-modal.js"></script>
    </body>
</html>
<?php } ?>