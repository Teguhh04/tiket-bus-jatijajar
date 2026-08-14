<?php

// Ensure all required writable directories exist in /tmp
$dirs = [
    '/tmp/storage/framework/views',
    '/tmp/storage/framework/cache/data',
    '/tmp/storage/framework/sessions',
    '/tmp/storage/bootstrap/cache',
    '/tmp/storage/logs',
    '/tmp/framework/views',
];

foreach ($dirs as $dir) {
    if (!file_exists($dir)) {
        @mkdir($dir, 0777, true);
    }
}

// Force view compiled path & log channel
putenv('VIEW_COMPILED_PATH=/tmp/framework/views');
$_ENV['VIEW_COMPILED_PATH'] = '/tmp/framework/views';
$_SERVER['VIEW_COMPILED_PATH'] = '/tmp/framework/views';

putenv('LOG_CHANNEL=stderr');
$_ENV['LOG_CHANNEL'] = 'stderr';

require __DIR__ . '/../public/index.php';
