<?php

namespace App\Providers;

use Illuminate\Support\Facades\Config;
use Illuminate\Support\Facades\URL;
use Illuminate\Support\ServiceProvider;


class AppServiceProvider extends ServiceProvider
{
    /**
     * Register any application services.
     */
    public function register(): void
    {
        // Force safe config defaults for Vercel serverless environment.
        // This runs BEFORE service providers boot, ensuring managers
        // never receive an empty-string driver name.
        if (getenv('VERCEL') || isset($_SERVER['VERCEL'])) {
            $overrides = [
                'session.driver'       => 'cookie',
                'cache.default'        => 'array',
                'queue.default'        => 'sync',
                'filesystems.default'  => 'local',
                'broadcasting.default' => 'log',
                'mail.default'         => 'log',
            ];

            foreach ($overrides as $key => $value) {
                Config::set($key, $value);
            }
        }
    }

    
    public function boot(): void
    {
        // Force HTTPS in production environment.
    if (app()->environment('production')) {
        URL::forceScheme('https');
    
        }
    }
}