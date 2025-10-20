<?php

namespace MailMug\ZentropyLaravel;

use Illuminate\Support\ServiceProvider;

class ZentropyWrapperServiceProvider extends ServiceProvider
{
    public function register(): void
    {
        $this->mergeConfigFrom(__DIR__ . '/../config/zentropy.php', 'zentropy');

        // Bind the wrapper to the container
        $this->app->singleton('zentropy-laravel', function ($app) {
            return new ZentropyWrapper();
        });
    }

    public function boot(): void
    {
        // Publish config file to Laravel's config directory
        $this->publishes([
            __DIR__ . '/../config/zentropy.php' => config_path('zentropy.php'),
        ], 'config');
    }
}
