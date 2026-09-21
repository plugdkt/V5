<?php
// C:\inetpub\wwwroot\V5\sso\callback.php
// Forward the SSO token back to Laravel's secure auth callback handler

$token = trim($_GET['token'] ?? '');

if (empty($token)) {
    die("เข้าสู่ระบบล้มเหลว: ไม่พบโทเคนยืนยันสิทธิ์");
}

// Redirect dynamically to Laravel's callback URL
$protocol = (!empty($_SERVER['HTTPS']) && $_SERVER['HTTPS'] !== 'off' || ($_SERVER['SERVER_PORT'] ?? 80) == 443) ? "https://" : "http://";
$host = $_SERVER['HTTP_HOST'] ?? 'www.medsci.up.ac.th';
$parentDir = rtrim(dirname($_SERVER['SCRIPT_NAME'] ?? ''), '/\\') . '/'; // e.g. /V5/sso/
$laravelCallbackUrl = $protocol . $host . str_replace('/sso/', '/public/auth/callback', $parentDir) . '?token=' . urlencode($token);

header("Location: " . $laravelCallbackUrl);
exit();
