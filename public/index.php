<?php

use Illuminate\Http\Request;

define('LARAVEL_START', microtime(true));

// Redirect /V5 (no trailing slash) to /V5/ to prevent Laravel routing 404s
if (isset($_SERVER['REQUEST_URI'])) {
    $path = parse_url($_SERVER['REQUEST_URI'], PHP_URL_PATH);
    if (strcasecmp($path, '/V5') === 0) {
        $queryString = isset($_SERVER['QUERY_STRING']) && $_SERVER['QUERY_STRING'] !== '' ? '?' . $_SERVER['QUERY_STRING'] : '';
        header('Location: /V5/' . $queryString, true, 301);
        exit;
    }
}

// Normalize SCRIPT_NAME and PHP_SELF for IIS URL Rewrite if "/public" is missing from the Request URI
if (isset($_SERVER['REQUEST_URI']) && isset($_SERVER['SCRIPT_NAME'])) {
    if (preg_match('/^\/([vV]5)/', $_SERVER['REQUEST_URI'], $matches)) {
        $v5Prefix = '/' . $matches[1];
    } else {
        $v5Prefix = '/V5';
    }

    if (stripos($_SERVER['REQUEST_URI'], $v5Prefix . '/public') === false && stripos($_SERVER['SCRIPT_NAME'], $v5Prefix . '/public') !== false) {
        $_SERVER['SCRIPT_NAME'] = str_ireplace($v5Prefix . '/public', $v5Prefix, $_SERVER['SCRIPT_NAME']);
        if (isset($_SERVER['PHP_SELF'])) {
            $_SERVER['PHP_SELF'] = str_ireplace($v5Prefix . '/public', $v5Prefix, $_SERVER['PHP_SELF']);
        }
    }
    
    if (strpos($_SERVER['SCRIPT_NAME'], $v5Prefix) !== 0) {
        $_SERVER['SCRIPT_NAME'] = preg_replace('/^\/[vV]5/i', $v5Prefix, $_SERVER['SCRIPT_NAME']);
        if (isset($_SERVER['PHP_SELF'])) {
            $_SERVER['PHP_SELF'] = preg_replace('/^\/[vV]5/i', $v5Prefix, $_SERVER['PHP_SELF']);
        }
    }
}

// Determine if the application is in maintenance mode...
if (file_exists($maintenance = __DIR__.'/../storage/framework/maintenance.php')) {
    require $maintenance;
}

// Register the Composer autoloader...
require __DIR__.'/../vendor/autoload.php';

// Bootstrap Laravel and handle the request...
(require_once __DIR__.'/../bootstrap/app.php')
    ->handleRequest(Request::capture());
