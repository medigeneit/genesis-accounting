<?php

namespace Medigeneit\GenesisAccounting;

use Illuminate\Support\ServiceProvider;

class GenesisAccountingServiceProvider extends ServiceProvider
{
    /**
     * Register the package services.
     */
    public function register(): void
    {
        $this->mergeConfigFrom(
            __DIR__ . '/../config/genesis-accounting.php',
            'genesis-accounting'
        );

        $this->app->singleton('genesis-accounting', function ($app) {
            return new GenesisAccountingClient();
        });
    }

    /**
     * Bootstrap the package services.
     */
    public function boot(): void
    {
        if ($this->app->runningInConsole()) {
            $this->publishes([
                __DIR__ . '/../config/genesis-accounting.php' => $this->app->configPath('genesis-accounting.php'),
            ], 'genesis-accounting-config');
        }
    }
}
