<?php

ini_set('display_errors', '1');
ini_set('display_startup_errors', '1');
error_reporting(E_ALL);

register_shutdown_function(function () {
    $error = error_get_last();
    if ($error && in_array($error['type'], [E_ERROR, E_PARSE, E_CORE_ERROR, E_COMPILE_ERROR])) {
        http_response_code(500);
        header('Content-Type: text/plain');
        echo "SHUTDOWN FATAL ERROR:\n";
        print_r($error);
    }
});

// Normalize PATH_INFO and SCRIPT_NAME for Vercel Serverless
// In Vercel, requests to /api/... get PATH_INFO set to the suffix (e.g. /products instead of /api/products),
// which causes Symfony / Laravel to strip the /api prefix and 404.
// By unsetting PATH_INFO and normalizing SCRIPT_NAME to /index.php, Laravel accurately routes all /api/... and web requests.
unset($_SERVER['PATH_INFO']);
$_SERVER['SCRIPT_NAME'] = '/index.php';
$_SERVER['PHP_SELF'] = '/index.php';

// Ensure /tmp directories exist for Laravel on Vercel's serverless environment
$dirs = [
    '/tmp/storage',
    '/tmp/storage/framework',
    '/tmp/storage/framework/views',
    '/tmp/storage/framework/cache',
    '/tmp/storage/framework/cache/data',
    '/tmp/storage/framework/sessions',
    '/tmp/storage/app',
    '/tmp/storage/app/public',
    '/tmp/storage/logs',
    '/tmp/views',
    '/tmp/cache',
];
foreach ($dirs as $dir) {
    if (!is_dir($dir)) {
        @mkdir($dir, 0755, true);
    }
}

// Default environment variables for Vercel
$defaultEnv = [
    'VERCEL' => '1',
    'APP_NAME' => 'U-Market',
    'APP_ENV' => 'production',
    'APP_KEY' => 'base64:l5d04LB8osrG/nKoJiZYLgMZsEXHkY8Q+jOMhcGgefA=',
    'APP_DEBUG' => 'true',
    'APP_URL' => 'https://umarket-skripsi.vercel.app',
    'DB_CONNECTION' => 'mysql',
    'DB_HOST' => 'gateway01.ap-southeast-1.prod.aws.tidbcloud.com',
    'DB_PORT' => '4000',
    'DB_DATABASE' => 'test',
    'DB_USERNAME' => 'daw8YEYXR9uL45q.root',
    'DB_PASSWORD' => 'lJbn1OctVTSmONWr',
    'DB_SSL_CA' => 'true',
    'DB_SSL_VERIFY' => 'false',
    'CACHE_STORE' => 'array',
    'SESSION_DRIVER' => 'cookie',
    'LOG_CHANNEL' => 'stderr',
    'VIEW_COMPILED_PATH' => '/tmp/storage/framework/views',
    'APP_CONFIG_CACHE' => '/tmp/cache/config.php',
    'APP_EVENTS_CACHE' => '/tmp/cache/events.php',
    'APP_PACKAGES_CACHE' => '/tmp/cache/packages.php',
    'APP_ROUTES_CACHE' => '/tmp/cache/routes.php',
    'APP_SERVICES_CACHE' => '/tmp/cache/services.php',
    'MAIL_MAILER' => 'smtp',
    'MAIL_HOST' => 'smtp.gmail.com',
    'MAIL_PORT' => '587',
    'MAIL_USERNAME' => 'marketunila@gmail.com',
    'MAIL_PASSWORD' => 'quix iowh xfnc wfjm',
    'MAIL_ENCRYPTION' => 'tls',
    'MAIL_FROM_ADDRESS' => 'marketunila@gmail.com',
    'MAIL_FROM_NAME' => 'U-Market',
];

foreach ($defaultEnv as $k => $v) {
    if (getenv($k) === false || getenv($k) === '') {
        putenv("$k=$v");
        $_ENV[$k] = $v;
        $_SERVER[$k] = $v;
    }
}

// Ensure REMOTE_ADDR is always set for Symfony/Laravel proxy handling
if (empty($_SERVER['REMOTE_ADDR'])) {
    if (!empty($_SERVER['HTTP_X_FORWARDED_FOR'])) {
        $ips = explode(',', $_SERVER['HTTP_X_FORWARDED_FOR']);
        $_SERVER['REMOTE_ADDR'] = trim($ips[0]);
    } elseif (!empty($_SERVER['HTTP_X_REAL_IP'])) {
        $_SERVER['REMOTE_ADDR'] = $_SERVER['HTTP_X_REAL_IP'];
    } else {
        $_SERVER['REMOTE_ADDR'] = '127.0.0.1';
    }
}

try {
    // Forward to public/index.php
    require __DIR__ . '/../public/index.php';
} catch (\Throwable $e) {
    http_response_code(500);
    header('Content-Type: text/plain');
    echo "CAUGHT EXCEPTION: " . get_class($e) . ": " . $e->getMessage() . "\n";
    echo "FILE: " . $e->getFile() . ":" . $e->getLine() . "\n";
    echo "TRACE:\n" . $e->getTraceAsString();
}
