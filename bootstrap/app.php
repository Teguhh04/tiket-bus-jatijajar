<?php

use Illuminate\Foundation\Application;
use Illuminate\Foundation\Configuration\Exceptions;
use Illuminate\Foundation\Configuration\Middleware;

$app = Application::configure(basePath: dirname(__DIR__))
    ->withRouting(
        web: __DIR__.'/../routes/web.php',
        commands: __DIR__.'/../routes/console.php',
        health: '/up',
    )
    ->withMiddleware(function (Middleware $middleware): void {
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

$app->singleton(\Illuminate\Contracts\Foundation\MaintenanceMode::class, function () {
    return new \Illuminate\Foundation\FileBasedMaintenanceMode();
});

return $app;
