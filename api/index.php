<?php

// Buat direktori temporary yang dibutuhkan Laravel di folder /tmp (karena Vercel serverless read-only)
$directories = [
    '/tmp/storage/app/public',
    '/tmp/storage/framework/cache/data',
    '/tmp/storage/framework/sessions',
    '/tmp/storage/framework/views',
    '/tmp/storage/logs',
    '/tmp/bootstrap/cache',
];

foreach ($directories as $dir) {
    if (!is_dir($dir)) {
        @mkdir($dir, 0755, true);
    }
}

// Set environment variables default untuk runtime serverless jika belum diset di Vercel Dashboard
if (!getenv('LARAVEL_STORAGE_PATH')) {
    putenv('LARAVEL_STORAGE_PATH=/tmp/storage');
    $_ENV['LARAVEL_STORAGE_PATH'] = '/tmp/storage';
    $_SERVER['LARAVEL_STORAGE_PATH'] = '/tmp/storage';
}

if (!getenv('VIEW_COMPILED_PATH')) {
    putenv('VIEW_COMPILED_PATH=/tmp/storage/framework/views');
    $_ENV['VIEW_COMPILED_PATH'] = '/tmp/storage/framework/views';
    $_SERVER['VIEW_COMPILED_PATH'] = '/tmp/storage/framework/views';
}

if (!getenv('APP_CONFIG_CACHE')) {
    putenv('APP_CONFIG_CACHE=/tmp/bootstrap/cache/config.php');
    $_ENV['APP_CONFIG_CACHE'] = '/tmp/bootstrap/cache/config.php';
    $_SERVER['APP_CONFIG_CACHE'] = '/tmp/bootstrap/cache/config.php';
}

if (!getenv('APP_ROUTES_CACHE')) {
    putenv('APP_ROUTES_CACHE=/tmp/bootstrap/cache/routes-v7.php');
    $_ENV['APP_ROUTES_CACHE'] = '/tmp/bootstrap/cache/routes-v7.php';
    $_SERVER['APP_ROUTES_CACHE'] = '/tmp/bootstrap/cache/routes-v7.php';
}

if (!getenv('APP_EVENTS_CACHE')) {
    putenv('APP_EVENTS_CACHE=/tmp/bootstrap/cache/events.php');
    $_ENV['APP_EVENTS_CACHE'] = '/tmp/bootstrap/cache/events.php';
    $_SERVER['APP_EVENTS_CACHE'] = '/tmp/bootstrap/cache/events.php';
}

// Forward request ke public/index.php milik Laravel
require __DIR__ . '/../public/index.php';
