<?php

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

// Forward to public/index.php
require __DIR__ . '/../public/index.php';
