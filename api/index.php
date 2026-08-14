<?php

// Prepare writable /tmp/storage folder structure for Vercel
$tmpStorage = '/tmp/storage';
if (!file_exists($tmpStorage)) {
    @mkdir($tmpStorage . '/framework/views', 0777, true);
    @mkdir($tmpStorage . '/framework/cache/data', 0777, true);
    @mkdir($tmpStorage . '/framework/sessions', 0777, true);
    @mkdir($tmpStorage . '/bootstrap/cache', 0777, true);
    @mkdir($tmpStorage . '/logs', 0777, true);
}

putenv('LOG_CHANNEL=stderr');
$_ENV['LOG_CHANNEL'] = 'stderr';
$_SERVER['LOG_CHANNEL'] = 'stderr';

putenv('LOG_STACK=stderr');
$_ENV['LOG_STACK'] = 'stderr';
$_SERVER['LOG_STACK'] = 'stderr';

require __DIR__ . '/../public/index.php';
