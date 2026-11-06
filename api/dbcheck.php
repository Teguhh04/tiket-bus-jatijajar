<?php

header('Content-Type: application/json');

echo json_encode([
    'test' => 'API PHP BERHASIL',
    'php_version' => PHP_VERSION,
    'pdo_loaded' => extension_loaded('pdo'),
    'pdo_pgsql_loaded' => extension_loaded('pdo_pgsql'),
    'pgsql_loaded' => extension_loaded('pgsql'),
    'pdo_drivers' => PDO::getAvailableDrivers(),
], JSON_PRETTY_PRINT);

exit;