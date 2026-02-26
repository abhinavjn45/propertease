<?php 
    session_start();
    require_once '../admin/assets/includes/config/config.php';

    require_once '../admin/assets/includes/functions/data_fetcher.php';
    require_once '../admin/assets/includes/functions/user_auth.php';
    require_once '../admin/assets/includes/functions/utility_functions.php';
    require_once '../admin/assets/includes/functions/send_emails.php';
?>
<!doctype html>
<html lang="en" style="height: 100%;">
    <head>
        <meta charset="UTF-8">
        <title>Gallery - <?= htmlspecialchars(get_site_option('site_title')) ?></title>
        <meta name="viewport" content="width=device-width, initial-scale=1">
        <!-- Bootstrap CSS (CDN) -->
        <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-QWTKZyjpPEjISv5WaRU9OFeRpok6YctnYmDr5pNlyT2bRjXh0JMhjY6hW+ALEwIH" crossorigin="anonymous">
        <!-- Font Awesome -->
        <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.1/css/all.min.css" integrity="sha512-DTOQO9RWCH3ppGqcWaEA1BIZOC6xxalwEsw9c2QQeAIftl+Vegovlnee1c9QX4TctnWMn13TZye+giMm8e2LwA==" crossorigin="anonymous" referrerpolicy="no-referrer">
        <!-- Custom CSS Files -->
        <link rel="stylesheet" href="../assets/css/global.css">
        <link rel="stylesheet" href="../assets/css/topbar.css">
        <link rel="stylesheet" href="../assets/css/header.css">
        <link rel="stylesheet" href="../assets/css/sections.css">
        <link rel="stylesheet" href="../assets/css/footer.css">
        <link rel="stylesheet" href="../assets/css/style_gallery.css">
        <link rel="stylesheet" href="../assets/css/login-modal.css">
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
                        <a href="<?= get_site_option('site_url'); ?>">Home</a> / <span id="page-title">Gallery</span>
                    </div>
                    <h2 class="hero-title" id="hero-heading">Gallery</h2>
                    <p class="hero-subtitle" id="hero-subheading">Highlights from Jagaran Cooperative Group Housing Society — events, facilities, and everyday moments captured by our community.</p>
                </div>
            </section>

            <!-- Main Content -->
            <main aria-label="Photo gallery">
                <div class="main-inner">
                    <section class="section-card gallery-intro" aria-labelledby="gallery-intro-title">
                        <div class="d-flex align-items-start flex-wrap gap-3 justify-content-between">
                            <div>
                                <h2 class="section-title mb-2" id="gallery-intro-title">Community moments</h2>
                                <p class="section-subtitle mb-0">Explore photos of facilities, celebrations, and daily life within the society.</p>
                            </div>
                            <div class="badge bg-warning text-dark fw-semibold px-3 py-2 shadow-sm">
                                <i class="fas fa-camera me-2"></i>Tap an image to view full size
                            </div>
                        </div>
                    </section>

                    <section class="section-card" aria-label="Image gallery grid">
                        <div class="gallery-grid" id="galleryGrid">
                            <?= load_gallery('gallery-page') ?>
                        </div>
                    </section>
                </div>
            </main>

            <!-- Lightbox -->
            <div class="lightbox" id="galleryLightbox" aria-hidden="true" role="dialog" aria-label="Image preview">
                <div class="lightbox-backdrop" data-dismiss="lightbox"></div>
                <div class="lightbox-content" role="document">
                    <button type="button" class="lightbox-close" aria-label="Close gallery" data-dismiss="lightbox">
                        <i class="fas fa-times"></i>
                    </button>
                    <button type="button" class="lightbox-nav lightbox-prev" aria-label="Previous image" data-nav="prev">
                        <i class="fas fa-chevron-left"></i>
                    </button>
                    <figure class="lightbox-figure">
                        <img id="lightboxImage" src="" alt="" loading="lazy">
                        <figcaption id="lightboxCaption"></figcaption>
                    </figure>
                    <button type="button" class="lightbox-nav lightbox-next" aria-label="Next image" data-nav="next">
                        <i class="fas fa-chevron-right"></i>
                    </button>
                </div>
            </div>

            <?php 
                require_once '../assets/elements/footer.php';
            ?>
        </div>

        <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js" integrity="sha384-YvpcrYf0tY3lHB60NNkmXc5s9fDVZLESaAA55NDzOxhy9GkcIdslK1eN7N6jIeHz" crossorigin="anonymous"></script>
        <script src="../assets/js/gallery.js"></script>
    </body>
</html>