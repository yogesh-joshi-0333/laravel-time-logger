<?php

namespace LaravelTimeLogger;

use Illuminate\Support\ServiceProvider;

class LaravelTimeLoggerServiceProvider extends ServiceProvider
{
    public function boot(): void
    {
        $this->publishes([
            __DIR__.'/../config/laravel-time-logger.php' => config_path('laravel-time-logger.php'),
        ], 'laravel-time-logger');
    }

    public function register(): void
    {
        $this->mergeConfigFrom(
            __DIR__.'/../config/laravel-time-logger.php', 'laravel-time-logger'
        );
    }

}
