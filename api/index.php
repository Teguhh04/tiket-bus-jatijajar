<?php

// Prepare writable /tmp/storage folder structure for Vercel Serverless
$tmpStorage = '/tmp/storage';
if (!file_exists($tmpStorage)) {
    @mkdir($tmpStorage . '/framework/views', 0777, true);
    @mkdir($tmpStorage . '/framework/cache/data', 0777, true);
    @mkdir($tmpStorage . '/framework/sessions', 0777, true);
    @mkdir($tmpStorage . '/bootstrap/cache', 0777, true);
    @mkdir($tmpStorage . '/logs', 0777, true);
}

// Remove any incomplete config cache file if present in /tmp
if (file_exists('/tmp/config.php')) {
    @unlink('/tmp/config.php');
}

require __DIR__ . '/../public/index.php';
