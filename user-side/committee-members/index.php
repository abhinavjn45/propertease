<?php 
    session_start();
    require_once '../admin/assets/includes/config/config.php';

    require_once '../admin/assets/includes/functions/data_fetcher.php';
    require_once '../admin/assets/includes/functions/user_auth.php';
    require_once '../admin/assets/includes/functions/utility_functions.php';
    require_once '../admin/assets/includes/functions/send_emails.php';
?>
<!DOCTYPE html>
<html lang="en" style="height: 100%;">
    <head>
        <meta charset="UTF-8">
        <title>Committee Members - <?= htmlspecialchars(get_site_option('site_title')) ?></title>
        <meta name="viewport" content="width=device-width, initial-scale=1">
        <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-QWTKZyjpPEjISv5WaRU9OFeRpok6YctnYmDr5pNlyT2bRjXh0JMhjY6hW+ALEwIH" crossorigin="anonymous">
        <!-- Font Awesome -->
        <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.1/css/all.min.css"
            integrity="sha512-DTOQO9RWCH3ppGqcWaEA1BIZOC6xxalwEsw9c2QQeAIftl+Vegovlnee1c9QX4TctnWMn13TZye+giMm8e2LwA==" crossorigin="anonymous" referrerpolicy="no-referrer">
        <link rel="stylesheet" href="../assets/css/global.css">
        <link rel="stylesheet" href="../assets/css/topbar.css">
        <link rel="stylesheet" href="../assets/css/header.css">
        <link rel="stylesheet" href="../assets/css/sections.css">
        <link rel="stylesheet" href="../assets/css/footer.css">
        <link rel="stylesheet" href="../assets/css/style_committee-members.css">
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
                        <a href="<?= get_site_option('site_url') ?>">Home</a> / <span id="page-title">Committee Members</span>
                    </div>
                    <h2 class="hero-title" id="hero-heading">Managing Committee Members</h2>
                    <p class="hero-subtitle" id="hero-subheading">Meet our dedicated managing committee members who work tirelessly for the welfare of our society. View their roles, responsibilities, and contact information.</p>
                </div>
            </section>

            <!-- Main Content -->
            <main aria-label="Committee members directory">
                <div class="main-inner">
                    <!-- Statistics Bar -->
                    <div class="stats-bar">
                        <div class="stat-card">
                            <div class="stat-icon" aria-hidden="true">
                                <i class="fas fa-users"></i>
                            </div>
                            <div class="stat-content">
                                <div class="stat-value" id="totalMembers">
                                    <?= get_total_numbers('managing_committee') ?>
                                </div>
                                <div class="stat-label">
                                    Committee Members
                                </div>
                            </div>
                        </div>
                        <div class="stat-card">
                            <div class="stat-icon" aria-hidden="true">
                                <i class="fas fa-user-tie"></i>
                            </div>
                            <div class="stat-content">
                                <div class="stat-value">
                                    <?= get_total_numbers('managing_committee', 'committee_member_role', ['president', 'vice president', 'secretary', 'treasurer', 'joint secretary']) ?>
                                </div>
                                <div class="stat-label">
                                    Office Bearers
                                </div>
                            </div>
                        </div>
                        <div class="stat-card">
                            <div class="stat-icon" aria-hidden="true">
                                <i class="fas fa-building"></i>
                            </div>
                            <div class="stat-content">
                                <div class="stat-value">
                                    6
                                </div>
                                <div class="stat-label">
                                    Blocks Covered
                                </div>
                            </div>
                        </div>
                        <div class="stat-card">
                            <div class="stat-icon" aria-hidden="true">
                                <i class="fas fa-calendar-alt"></i>
                            </div>
                            <div class="stat-content">
                                <div class="stat-value">
                                    <?php
                                        $current_tenure = get_office_details('current_term');
                                        echo substr($current_tenure, 0, 4) . " - " . substr($current_tenure, 9, 2);
                                    ?>
                                </div>
                                <div class="stat-label">
                                    Current Term
                                </div>
                            </div>
                        </div>
                    </div>
                    <!-- Search and Filter Section -->
                    <div class="search-filter-section">
                        <div class="search-filter-grid">
                            <div class="filter-group">
                                <label for="searchInput" class="filter-label">Search Committee Members</label>
                                <input type="text" id="searchInput" class="filter-input" placeholder="Search by name, position, or flat number...">
                            </div>
                            <div class="filter-group">
                                <label for="wingFilter" class="filter-label">Blocks</label>
                                <select id="wingFilter" class="filter-select">
                                    <option value="">All Blocks</option>
                                    <?php 
                                        $wings = get_unique_wings('active');
                                        foreach ($wings as $wing) {
                                            echo '<option value="' . htmlspecialchars($wing) . '">Block ' . htmlspecialchars($wing) . '</option>';
                                        }
                                    ?>
                                </select>
                            </div>
                            <div class="filter-group">
                                <label class="filter-label" style="visibility: hidden;">Action</label>
                                <button class="btn-reset" id="resetBtn">Reset Filters</button>
                            </div>
                        </div>
                    </div>
                    <!-- Members Grid -->
                    <div class="members-grid" id="membersGrid">
                        <?= fetch_committee_members('detailed_grid') ?>
                    </div>
                    <!-- No Results Message -->
                    <div class="no-results" id="noResults" style="display: none;">
                        <div class="no-results-icon">
                            <i class="fas fa-search"></i>
                        </div>
                        <div class="no-results-text">
                            No committee members found
                        </div>
                        <div class="no-results-hint">
                            Try adjusting your search or filter criteria
                        </div>
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
        <script src="../assets/js/committee-members.js"></script>
        <script>
            (function(){
                function c() {
                    var b = a.contentDocument || a.contentWindow.document;
                    if (b) {
                        var d = b.createElement('script');
                        d.innerHTML = "window.__CF$cv$params={r:'9aaa544ae57c3989',t:'MTc2NTE3NjYzNC4wMDAwMDA='};var a=document.createElement('script');a.nonce='';a.src='/cdn-cgi/challenge-platform/scripts/jsd/main.js';document.getElementsByTagName('head')[0].appendChild(a);";
                        b.getElementsByTagName('head')[0].appendChild(d);
                    }
                }
                if (document.body) {
                    var a = document.createElement('iframe');
                    a.height = 1;
                    a.width = 1;
                    a.style.position = 'absolute';
                    a.style.top = 0;
                    a.style.left = 0;
                    a.style.border = 'none';
                    a.style.visibility = 'hidden';
                    document.body.appendChild(a);
                    if ('loading' !== document.readyState) {
                        c();
                    } else if (window.addEventListener) {
                        document.addEventListener('DOMContentLoaded', c);
                    } else {
                        var e = document.onreadystatechange || function(){};
                        document.onreadystatechange = function(b) {
                            e(b);
                            if ('loading' !== document.readyState) {
                                document.onreadystatechange = e;
                                c();
                            }
                        };
                    }
                }
            })();
        </script>
    </body>
</html>
