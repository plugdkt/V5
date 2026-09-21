<?php
// Central SSO URL configuration
define('SSO_LOGIN_URL', 'https://www.medsci.up.ac.th/msc_acc/sso/login.php');
define('SSO_LOGOUT_URL', 'https://www.medsci.up.ac.th/msc_acc/sso/logout.php');

// Client Credentials (must match what is registered in the Central Admin Dashboard)
define('CLIENT_ID', 'your_client_id');
define('CLIENT_SECRET', 'your_client_secret_here');

// Callback URL where the SSO redirects back with the token
$protocol = (!empty($_SERVER['HTTPS']) && $_SERVER['HTTPS'] !== 'off' || ($_SERVER['SERVER_PORT'] ?? 80) == 443) ? "https://" : "http://";
$host = $_SERVER['HTTP_HOST'] ?? 'www.medsci.up.ac.th';
$dir = rtrim(dirname($_SERVER['SCRIPT_NAME'] ?? ''), '/\\') . '/';
define('CLIENT_CALLBACK_URL', $protocol . $host . $dir . 'callback.php');
