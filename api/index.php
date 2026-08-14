<?php

// Prepare writable /tmp storage and cache directories for Vercel Serverless
$tmpStorage = '/tmp/storage';
$tmpCache = '/tmp/bootstrap/cache';

$dirs = [
    $tmpStorage . '/framework/views',
    $tmpStorage . '/framework/cache/data',
    $tmpStorage . '/framework/sessions',
    $tmpStorage . '/bootstrap/cache',
    $tmpStorage . '/logs',
    $tmpCache,
];

foreach ($dirs as $dir) {
    if (!file_exists($dir)) {
        @mkdir($dir, 0777, true);
    }
}

// Copy manifest files to /tmp/bootstrap/cache if they exist
$baseCache = __DIR__ . '/../bootstrap/cache';
if (file_exists($baseCache . '/packages.php') && !file_exists($tmpCache . '/packages.php')) {
    @copy($baseCache . '/packages.php', $tmpCache . '/packages.php');
}
if (file_exists($baseCache . '/services.php') && !file_exists($tmpCache . '/services.php')) {
    @copy($baseCache . '/services.php', $tmpCache . '/services.php');
}

// Force environment settings
putenv('APP_ENV=production');
putenv('APP_DEBUG=true');
putenv('LOG_CHANNEL=stderr');
putenv('SESSION_DRIVER=file');
putenv('CACHE_STORE=array');

putenv("APP_PACKAGES_CACHE={$tmpCache}/packages.php");
putenv("APP_SERVICES_CACHE={$tmpCache}/services.php");

$_ENV['APP_ENV'] = 'production';
$_ENV['APP_DEBUG'] = 'true';
$_ENV['LOG_CHANNEL'] = 'stderr';
$_ENV['SESSION_DRIVER'] = 'file';
$_ENV['CACHE_STORE'] = 'array';
$_ENV['APP_PACKAGES_CACHE'] = "{$tmpCache}/packages.php";
$_ENV['APP_SERVICES_CACHE'] = "{$tmpCache}/services.php";

$_SERVER['APP_ENV'] = 'production';
$_SERVER['APP_DEBUG'] = 'true';
$_SERVER['LOG_CHANNEL'] = 'stderr';
$_SERVER['SESSION_DRIVER'] = 'file';
$_SERVER['CACHE_STORE'] = 'array';
$_SERVER['APP_PACKAGES_CACHE'] = "{$tmpCache}/packages.php";
$_SERVER['APP_SERVICES_CACHE'] = "{$tmpCache}/services.php";

try {
    require __DIR__ . '/../public/index.php';
} catch (\Throwable $e) {
    header("HTTP/1.1 200 OK");
    echo "<div style='font-family: sans-serif; padding: 20px; background: #fff; color: #111;'>";
    echo "<h2 style='color: #e53e3e;'>Laravel Serverless Error</h2>";
    echo "<p><strong>Message:</strong> " . htmlspecialchars($e->getMessage()) . "</p>";
    echo "<p><strong>File:</strong> " . htmlspecialchars($e->getFile()) . " (line " . $e->getLine() . ")</p>";
    echo "<pre style='background: #f7fafc; padding: 15px; border-radius: 8px; overflow: auto;'>" . htmlspecialchars($e->getTraceAsString()) . "</pre>";
    echo "</div>";
}
