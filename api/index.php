<?php

/**
 * Vercel Serverless Entry Point for Laravel
 * Fixes: ArgumentCountError from empty/unsupported driver values
 */

// 1. Buat direktori yang writable di /tmp (karena Vercel filesystem read-only)
$dirs = [
    '/tmp/storage/framework/views',
    '/tmp/storage/framework/cache/data',
    '/tmp/storage/framework/sessions',
    '/tmp/storage/logs',
    '/tmp/bootstrap/cache',
];

foreach ($dirs as $dir) {
    if (!is_dir($dir)) {
        mkdir($dir, 0777, true);
    }
}

// 2. Hapus cache bootstrap lama agar tidak konflik
@unlink('/tmp/bootstrap/cache/services.php');
@unlink('/tmp/bootstrap/cache/packages.php');
@unlink('/tmp/bootstrap/cache/config.php');

// 3. Override storage path ke /tmp
$_ENV['APP_STORAGE_PATH'] = '/tmp/storage';

// 4. Set semua environment variable yang dibutuhkan
//    PENTING: SESSION_DRIVER harus 'cookie' (bukan 'file') di Vercel
//             CACHE_STORE harus 'array'
//             DB menggunakan sqlite :memory:
$envOverrides = [
    'APP_ENV'          => 'production',
    'APP_DEBUG'        => 'false',
    'LOG_CHANNEL'      => 'stderr',
    'LOG_STACK'        => 'stderr',
    'SESSION_DRIVER'   => 'cookie',
    'SESSION_LIFETIME' => '120',
    'SESSION_ENCRYPT'  => 'false',
    'CACHE_STORE'      => 'array',
    'QUEUE_CONNECTION' => 'sync',
    'DB_CONNECTION'    => 'sqlite',
    'DB_DATABASE'      => ':memory:',
    'FILESYSTEM_DISK'  => 'local',
    'BROADCAST_CONNECTION' => 'log',
    'MAIL_MAILER'      => 'log',
];

foreach ($envOverrides as $key => $value) {
    putenv("$key=$value");
    $_ENV[$key]    = $value;
    $_SERVER[$key] = $value;
}

// 5. Override storage path di Laravel
if (!defined('LARAVEL_STORAGE_PATH')) {
    define('LARAVEL_STORAGE_PATH', '/tmp/storage');
}

// 6. Jalankan Laravel
try {
    require __DIR__ . '/../public/index.php';
} catch (\Throwable $e) {
    http_response_code(500);
    header('Content-Type: text/html; charset=UTF-8');
    echo "<!DOCTYPE html><html><head><title>Server Error</title></head><body>";
    echo "<div style='font-family: sans-serif; padding: 40px; max-width: 900px; margin: 0 auto;'>";
    echo "<h2 style='color: #e53e3e;'>Vercel Live Exception</h2>";
    echo "<h3>" . htmlspecialchars(get_class($e)) . "</h3>";
    echo "<p><strong>Message:</strong> " . htmlspecialchars($e->getMessage()) . "</p>";
    echo "<p><strong>File:</strong> " . htmlspecialchars($e->getFile()) . " (line " . $e->getLine() . ")</p>";
    echo "<pre style='background:#f7fafc;padding:15px;border-radius:8px;overflow:auto;font-size:12px;'>";
    echo htmlspecialchars($e->getTraceAsString());
    echo "</pre></div></body></html>";
}
