<?php

use Illuminate\Foundation\Application;
use Illuminate\Foundation\Configuration\Exceptions;
use Illuminate\Foundation\Configuration\Middleware;
use Illuminate\Http\Request;

// ============================================================
// Vercel Serverless Environment Fix
// Set required env vars BEFORE Application is created so that
// config files (session.php, cache.php) read correct values.
// ============================================================
if (isset($_SERVER['VERCEL']) || getenv('VERCEL')) {
    $vercelEnv = [
        'SESSION_DRIVER'   => 'cookie',
        'SESSION_LIFETIME' => '120',
        'CACHE_STORE'      => 'array',
        'QUEUE_CONNECTION' => 'sync',
        'DB_CONNECTION'    => 'sqlite',
        'DB_DATABASE'      => ':memory:',
        'BROADCAST_CONNECTION' => 'log',
        'FILESYSTEM_DISK'  => 'local',
        'MAIL_MAILER'      => 'log',
        'LOG_CHANNEL'      => 'stderr',
        'APP_ENV'          => 'production',
    ];

    foreach ($vercelEnv as $key => $value) {
        if (!getenv($key) || in_array(getenv($key), ['', 'null', 'NULL'])) {
            putenv("$key=$value");
            $_ENV[$key]    = $value;
            $_SERVER[$key] = $value;
        }
    }
}

$app = Application::configure(basePath: dirname(__DIR__))
    ->withRouting(
        web: __DIR__.'/../routes/web.php',
        commands: __DIR__.'/../routes/console.php',
        health: '/up',
    )
    
->withMiddleware(function (Middleware $middleware): void {

    // Trust Vercel reverse proxy
    $middleware->trustProxies(
        at: '*',
        headers:
            Request::HEADER_X_FORWARDED_FOR |
            Request::HEADER_X_FORWARDED_HOST |
            Request::HEADER_X_FORWARDED_PORT |
            Request::HEADER_X_FORWARDED_PROTO 
    );

    // Existing admin middleware
    $middleware->alias([
        'admin' => \App\Http\Middleware\AdminMiddleware::class,
    ]);

})

    ->withExceptions(function (Exceptions $exceptions): void {
        $exceptions->render(function (\Throwable $e) {
            if (isset($_SERVER['HTTP_HOST']) && str_contains($_SERVER['HTTP_HOST'], 'vercel.app')) {
                return response(
                    "<div style='font-family:sans-serif;padding:30px;background:#fff;color:#111;'>" .
                    "<h2 style='color:#e53e3e;'>Vercel Live Exception</h2>" .
                    "<h3>" . htmlspecialchars(get_class($e)) . "</h3>" .
                    "<p style='font-size:16px;'><strong>Message:</strong> " . htmlspecialchars($e->getMessage()) . "</p>" .
                    "<p><strong>File:</strong> " . htmlspecialchars($e->getFile()) . " (line " . $e->getLine() . ")</p>" .
                    "<pre style='background:#f7fafc;padding:15px;border-radius:8px;border:1px solid #e2e8f0;overflow:auto;max-height:400px;'>" . htmlspecialchars($e->getTraceAsString()) . "</pre>" .
                    "</div>", 200
                );
            }
        });
    })->create();

if (isset($_ENV['VERCEL']) || isset($_SERVER['VERCEL']) || (isset($_SERVER['HTTP_HOST']) && str_contains($_SERVER['HTTP_HOST'], 'vercel.app'))) {
    $app->useStoragePath('/tmp/storage');
}

return $app;
