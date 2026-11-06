
<?php

header('Content-Type: application/json');

try {
    $host = getenv('DB_HOST');
    $port = getenv('DB_PORT') ?: '5432';
    $database = getenv('DB_DATABASE');
    $username = getenv('DB_USERNAME');
    $password = getenv('DB_PASSWORD');

    if (!$host || !$database || !$username || !$password) {
        throw new Exception('Konfigurasi database belum lengkap.');
    }

    $dsn = "pgsql:host={$host};port={$port};dbname={$database};sslmode=require";

    $pdo = new PDO($dsn, $username, $password, [
        PDO::ATTR_ERRMODE => PDO::ERRMODE_EXCEPTION,
        PDO::ATTR_TIMEOUT => 10,
    ]);

    $result = $pdo->query(
        'SELECT current_database() AS database, current_user AS username'
    )->fetch(PDO::FETCH_ASSOC);

    echo json_encode([
        'connection' => 'success',
        'database' => $result['database'],
        'username' => $result['username'],
        'message' => 'Koneksi Neon berhasil!'
    ], JSON_PRETTY_PRINT);

} catch (Throwable $e) {
    http_response_code(500);

    echo json_encode([
        'connection' => 'failed',
        'error' => $e->getMessage()
    ], JSON_PRETTY_PRINT);
}
