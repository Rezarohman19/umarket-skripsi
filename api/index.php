<?php

// Ensure /tmp directories exist for Laravel on Vercel's serverless environment
$dirs = [
    '/tmp/storage/framework/views',
    '/tmp/storage/framework/cache/data',
    '/tmp/storage/framework/sessions',
    '/tmp/storage/app/public',
    '/tmp/storage/logs',
    '/tmp/views',
];
foreach ($dirs as $dir) {
    if (!is_dir($dir)) {
        @mkdir($dir, 0755, true);
    }
}

// Forward to public/index.php
require __DIR__ . '/../public/index.php';
