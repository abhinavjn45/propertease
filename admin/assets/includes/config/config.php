<?php 
    define('DB_HOST', 'localhost');
    define('DB_USER', 'root');
    define('DB_PASS', '');
    define('DB_NAME', 'propertease');

    // define('DB_USER', 'u160623252_jagarancghs');
    // define('DB_PASS', 'Jagaran@2025');
    // define('DB_NAME', 'u160623252_jagarancghs');

    $con = mysqli_connect(DB_HOST, DB_USER, DB_PASS, DB_NAME);

    if (!$con) {
        header("Location: http://localhost/propertease/404.html");
        exit();
    }

    require_once __DIR__ . '/../functions/data_fetcher.php';

    // Set the default timezone
    date_default_timezone_set(get_site_option('timezone') ?: 'UTC');

    $_SESSION['office_member_unique_id'] = "JCGHSOFF00001";
?>