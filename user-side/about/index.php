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
        <title>About Us - <?= htmlspecialchars(get_site_option('site_title')) ?></title>
        <meta name="viewport" content="width=device-width, initial-scale=1">
        <!-- Bootstrap CSS (CDN) -->
        <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-QWTKZyjpPEjISv5WaRU9OFeRpok6YctnYmDr5pNlyT2bRjXh0JMhjY6hW+ALEwIH" crossorigin="anonymous">
        <!-- Font Awesome -->
        <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.1/css/all.min.css"
            integrity="sha512-DTOQO9RWCH3ppGqcWaEA1BIZOC6xxalwEsw9c2QQeAIftl+Vegovlnee1c9QX4TctnWMn13TZye+giMm8e2LwA==" crossorigin="anonymous" referrerpolicy="no-referrer">
        <!-- Custom CSS Files -->
        <link rel="stylesheet" href="../assets/css/global.css">
        <link rel="stylesheet" href="../assets/css/topbar.css">
        <link rel="stylesheet" href="../assets/css/header.css">
        <link rel="stylesheet" href="../assets/css/sections.css">
        <link rel="stylesheet" href="../assets/css/footer.css">
        <link rel="stylesheet" href="../assets/css/style_about.css">
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
                        <a href="index.html">Home</a> / <span id="page-title">About Society</span>
                    </div>
                    <h2 class="hero-title" id="hero-heading">About Jagaran Cooperative Group Housing Society</h2>
                    <p class="hero-subtitle" id="hero-subheading">Learn about our society's governance structure, history, facilities, and commitment to providing a safe, transparent, and community-focused living environment for all residents.</p>
                </div>
            </section>

            <!-- Main Content -->
            <main aria-label="About society information">
                <div class="main-inner">
                    <!-- Society Overview -->
                    <section class="section-card" aria-labelledby="overview-title">
                        <h2 class="section-title" id="overview-title">Society Overview</h2>
                        <p class="section-text">Jagaran Cooperative Group Housing Society was established in 1985 and is duly registered under the Maharashtra Co-operative Societies Act, 1960. The Society comprises 128 residential flats spread across 8 blocks, housing over 450 residents including families and senior citizens.</p>
                        <p class="section-text">Our society is governed by a democratically elected Managing Committee that works in accordance with the approved bye-laws and directions issued by the Office of the Registrar of Co-operative Societies. We are committed to maintaining high standards of governance, transparency, and accountability in all our operations.</p>
                        <p class="section-text mb-0">The society premises span approximately 3.2 acres and include well-maintained landscaped gardens, children's play areas, community facilities, and adequate parking spaces. We prioritize the safety, security, and well-being of all residents through regular maintenance, modern amenities, and responsive management.</p>
                    </section>

                    <div class="row g-3">
                        <!-- Managing Committee -->
                        <div class="col-12 col-lg-4">
                            <section class="section-card" aria-labelledby="committee-title">
                                <h2 class="section-title" id="committee-title">Managing Committee (2024-2026)</h2>
                                <p class="section-subtitle">Our elected representatives working for the welfare of all society members.</p>
                                <div class="committee-list">
                                    <?= fetch_committee_members('aboutpage', 6) ?>
                                </div>
                                <div class="d-flex justify-content-end mt-3">
                                    <a href="./committee-members.html" class="btn-link">View All Members</a>
                                </div>
                            </section>
                        </div>

                        <!-- Key Facilities -->
                        <div class="col-12 col-lg-8">
                            <section class="section-card" aria-labelledby="facilities-title">
                                <h2 class="section-title" id="facilities-title">Key Facilities &amp; Amenities</h2>
                                <p class="section-subtitle">Modern amenities and well-maintained facilities for resident convenience and comfort.</p>
                                <div class="facilities-grid">
                            <div class="facility-item">
                                <div class="facility-icon" aria-hidden="true">
                                    <i class="fas fa-building"></i>
                                </div>
                                <div class="facility-name">
                                    Community Hall
                                </div>
                            </div>
                            <div class="facility-item">
                                <div class="facility-icon" aria-hidden="true">
                                    <i class="fas fa-gamepad"></i>
                                </div>
                                <div class="facility-name">
                                    Children's Play Area
                                </div>
                            </div>
                            <div class="facility-item">
                                <div class="facility-icon" aria-hidden="true">
                                    <i class="fas fa-tree"></i>
                                </div>
                                <div class="facility-name">
                                    Landscaped Gardens
                                </div>
                            </div>
                            <div class="facility-item">
                                <div class="facility-icon" aria-hidden="true">
                                    <i class="fas fa-car"></i>
                                </div>
                                <div class="facility-name">
                                    Covered Parking
                                </div>
                            </div>
                            <div class="facility-item">
                                <div class="facility-icon" aria-hidden="true">
                                    <i class="fas fa-tint"></i>
                                </div>
                                <div class="facility-name">
                                    24/7 Water Supply
                                </div>
                            </div>
                            <div class="facility-item">
                                <div class="facility-icon" aria-hidden="true">
                                    <i class="fas fa-bolt"></i>
                                </div>
                                <div class="facility-name">
                                    Power Backup
                                </div>
                            </div>
                            <div class="facility-item">
                                <div class="facility-icon" aria-hidden="true">
                                    <i class="fas fa-lock"></i>
                                </div>
                                <div class="facility-name">
                                    24/7 Security
                                </div>
                            </div>
                            <div class="facility-item">
                                <div class="facility-icon" aria-hidden="true">
                                    <i class="fas fa-video"></i>
                                </div>
                                <div class="facility-name">
                                    CCTV Surveillance
                                </div>
                            </div>
                            <div class="facility-item">
                                <div class="facility-icon" aria-hidden="true">
                                    <i class="fas fa-dumbbell"></i>
                                </div>
                                <div class="facility-name">
                                    Gymnasium
                                </div>
                            </div>
                            <div class="facility-item">
                                <div class="facility-icon" aria-hidden="true">
                                    <i class="fas fa-recycle"></i>
                                </div>
                                <div class="facility-name">
                                    Waste Management
                                </div>
                            </div>
                            <div class="facility-item">
                                <div class="facility-icon" aria-hidden="true">
                                    <i class="fas fa-sun"></i>
                                </div>
                                <div class="facility-name">
                                    Solar Panels
                                </div>
                            </div>
                            <div class="facility-item">
                                <div class="facility-icon" aria-hidden="true">
                                    <i class="fas fa-faucet"></i>
                                </div>
                                <div class="facility-name">
                                    Rainwater Harvesting
                                </div>
                            </div>
                        </div>
                    </section>

                    <!-- Vision & Mission -->
                    <section class="section-card" aria-labelledby="vision-mission-title">
                        <div class="vision-mission-grid">
                            <div class="vm-box">
                                <div class="vm-icon" aria-hidden="true">
                                    <i class="fas fa-eye"></i>
                                </div>
                                <h3 class="vm-title">Vision</h3>
                                <p class="vm-text mb-0" id="vision-text">To create a model residential community that exemplifies excellence in cooperative living, sustainable development, and inclusive growth, while maintaining the highest standards of transparency, safety, and resident satisfaction.</p>
                            </div>
                            <div class="vm-box">
                                <div class="vm-icon" aria-hidden="true">
                                    <i class="fas fa-bullseye"></i>
                                </div>
                                <h3 class="vm-title">Mission</h3>
                                <p class="vm-text mb-0" id="mission-text">To provide well-maintained infrastructure, responsive governance, and community-focused services that enhance the quality of life for all residents, while fostering a spirit of cooperation, mutual respect, and environmental responsibility.</p>
                            </div>
                        </div>
                    </section>
                </div>
            </div>

            <div class="row g-3">
                <!-- Historical Timeline -->
                <div class="col-12 col-lg-4">
                    <section class="section-card" aria-labelledby="timeline-title">
                        <h2 class="section-title" id="timeline-title">Historical Milestones</h2>
                        <p class="section-subtitle">Key events in the development and growth of our society.</p>
                        <div class="timeline">
                            <div class="timeline-item">
                                <div class="timeline-year">
                                    1985
                                </div>
                                <div class="timeline-event">
                                    Society officially registered under the Maharashtra Co-operative Societies Act, 1960.
                                </div>
                            </div>
                            <div class="timeline-item">
                                <div class="timeline-year">
                                    1987
                                </div>
                                <div class="timeline-event">
                                    Construction of all 8 residential blocks completed and occupancy certificates obtained.
                                </div>
                            </div>
                            <div class="timeline-item">
                                <div class="timeline-year">
                                    1995
                                </div>
                                <div class="timeline-event">
                                    Community hall and children's play area inaugurated for resident welfare.
                                </div>
                            </div>
                            <div class="timeline-item">
                                <div class="timeline-year">
                                    2005
                                </div>
                                <div class="timeline-event">
                                    Major infrastructure upgrade including water supply system and electrical distribution.
                                </div>
                            </div>
                            <div class="timeline-item">
                                <div class="timeline-year">
                                    2012
                                </div>
                                <div class="timeline-event">
                                    Installation of CCTV surveillance system and modernization of security infrastructure.
                                </div>
                            </div>
                            <div class="timeline-item">
                                <div class="timeline-year">
                                    2018
                                </div>
                                <div class="timeline-event">
                                    Implementation of rainwater harvesting and solar panel systems for sustainability.
                                </div>
                            </div>
                            <div class="timeline-item">
                                <div class="timeline-year">
                                    2023
                                </div>
                                <div class="timeline-event">
                                    Launch of digital portal for online services, payments, and transparent communication.
                                </div>
                            </div>
                        </div>
                    </section>
                </div>

                        <!-- Society Bye-laws -->
                        <div class="col-12 col-lg-8">
                            <section class="section-card" aria-labelledby="bylaws-title">
                                <h2 class="section-title" id="bylaws-title">Society Bye-laws &amp; Regulations</h2>
                                <p class="section-subtitle">Important rules and guidelines for all residents to follow.</p>
                                <ul class="bylaws-list">
                                    <li class="bylaws-item">
                                        <div class="bylaws-icon" aria-hidden="true">
                                            <i class="fas fa-clipboard-list"></i>
                                        </div>
                                        <div class="bylaws-text">
                                            All members must pay maintenance charges by the 5th of every month to avoid late fees.
                                        </div>
                                    </li>
                                    <li class="bylaws-item">
                                        <div class="bylaws-icon" aria-hidden="true">
                                            <i class="fas fa-indian-rupee-sign"></i>
                                        </div>
                                        <div class="bylaws-text">
                                            Penalties and fines for violations will be levied as per the approved schedule in the bye-laws.
                                        </div>
                                    </li>
                                    <li class="bylaws-item">
                                        <div class="bylaws-icon" aria-hidden="true">
                                            <i class="fas fa-hard-hat"></i>
                                        </div>
                                        <div class="bylaws-text">
                                            Any construction, renovation, or structural changes require prior written approval from the managing committee.
                                        </div>
                                    </li>
                                    <li class="bylaws-item">
                                        <div class="bylaws-icon" aria-hidden="true">
                                            <i class="fas fa-volume-mute"></i>
                                        </div>
                                        <div class="bylaws-text">
                                            Noise levels must be kept to a minimum after 10 PM to maintain a peaceful living environment for all residents.
                                        </div>
                                    </li>
                                    <li class="bylaws-item">
                                        <div class="bylaws-icon" aria-hidden="true">
                                            <i class="fas fa-dog"></i>
                                        </div>
                                        <div class="bylaws-text">
                                            Pet owners must follow society guidelines and ensure pets do not cause disturbance to other residents.
                                        </div>
                                    </li>
                                    <li class="bylaws-item">
                                        <div class="bylaws-icon" aria-hidden="true">
                                            <i class="fas fa-ban"></i>
                                        </div>
                                        <div class="bylaws-text">
                                            Common areas and facilities are for resident use only and must not be misused or damaged.
                                        </div>
                                    </li>
                                </ul>
                                <div class="d-flex justify-content-end mt-3">
                                    <a href="../bye-laws.html" class="btn-link">View All Bye-laws</a>
                                </div>
                            </section>
                        </div>
                    </div>
                </div>
            </main>

            <!-- Footer -->
            <?php 
                require_once '../assets/elements/footer.php';
            ?>
        </div>

        <!-- Bootstrap JS (for navbar hamburger functionality) -->
        <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js" integrity="sha384-YvpcrYf0tY3lHB60NNkmXc5s9fDVZLESaAA55NDzOxhy9GkcIdslK1eN7N6jIeHz" crossorigin="anonymous"></script>

        <script src="../assets/js/login-modal.js"></script>

    </body>
</html>