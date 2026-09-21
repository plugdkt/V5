<?php
// client_sample/login.php
// ponytail: processes login redirect to SSO or logs out the user locally and centrally.

session_start();
require_once 'config.php';

$action = $_GET['action'] ?? 'login';

if ($action === 'logout') {
    // Clear local session
    $_SESSION = [];
    if (ini_get("session.use_cookies")) {
        $params = session_get_cookie_params();
        setcookie(session_name(), '', time() - 42000,
            $params["path"], $params["domain"],
            $params["secure"], $params["httponly"]
        );
    }
    session_destroy();
    
    // Redirect to central SSO logout, then redirect back to the app root index.php
    $protocol = (!empty($_SERVER['HTTPS']) && $_SERVER['HTTPS'] !== 'off' || ($_SERVER['SERVER_PORT'] ?? 80) == 443) ? "https://" : "http://";
    $host = $_SERVER['HTTP_HOST'] ?? 'www.medsci.up.ac.th';
    $parent_dir = rtrim(dirname(dirname($_SERVER['SCRIPT_NAME'] ?? '')), '/\\') . '/';
    $return_url = $protocol . $host . $parent_dir . 'index.php';
    
    header("Location: " . SSO_LOGOUT_URL . "?redirect_uri=" . urlencode($return_url));
    exit();
} else {
    // Redirect to SSO login screen with registered Client ID and callback URL
    $sso_redirect_url = SSO_LOGIN_URL . 
                        "?client_id=" . urlencode(CLIENT_ID) . 
                        "&redirect_uri=" . urlencode(CLIENT_CALLBACK_URL);
    
    header("Location: " . $sso_redirect_url);
    exit();
}
