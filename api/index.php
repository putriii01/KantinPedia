<?php

// Buat direktori sementara di /tmp agar compile Blade dan session tidak error
$storageDirs = [
    '/tmp/storage/framework/views',
    '/tmp/storage/framework/cache',
    '/tmp/storage/framework/sessions',
    '/tmp/storage/logs',
];

foreach ($storageDirs as $dir) {
    if (!is_dir($dir)) {
        mkdir($dir, 0755, true);
    }
}

// Salin database ke /tmp agar bisa diakses jika di Vercel path aslinya bermasalah
$dbPath = __DIR__ . '/../database/database.sqlite';
$tmpDbPath = '/tmp/database.sqlite';
if (file_exists($dbPath) && !file_exists($tmpDbPath)) {
    copy($dbPath, $tmpDbPath);
}

// Arahkan konfigurasi ke folder /tmp
putenv('VIEW_COMPILED_PATH=/tmp/storage/framework/views');
putenv('APP_SERVICES_CACHE=/tmp/storage/framework/cache/services.php');
putenv('APP_PACKAGES_CACHE=/tmp/storage/framework/cache/packages.php');
putenv('APP_CONFIG_CACHE=/tmp/storage/framework/cache/config.php');
putenv('APP_ROUTES_CACHE=/tmp/storage/framework/cache/routes.php');
putenv('DB_DATABASE=' . $tmpDbPath);

// Jalankan Laravel dari public/index.php
require __DIR__ . '/../public/index.php';