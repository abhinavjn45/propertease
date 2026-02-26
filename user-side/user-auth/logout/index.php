<?php 
    // Logout Script
    session_start();

    require_once '../../admin/assets/includes/config/config.php';
    require_once '../../admin/assets/includes/functions/data_fetcher.php';

    session_unset();
    session_destroy();
    header("Location: " . get_site_option('site_url'));
    exit();
?>