<?php

namespace App\Providers;

use Illuminate\Support\ServiceProvider;
use Square\SquareClient;

class SquareServiceProvider extends ServiceProvider
{
    /**
     * Register services.
     */
    public function register(): void
    {
        $this->app->singleton(SquareClient::class, function ($app) {
            return new SquareClient([
                'accessToken' => config('app.square.access_token'),
                'environment' => config('app.square.environment'),
            ]);
        });
    }

    /**
     * Bootstrap services.
     */
    public function boot(): void
    {
        //
    }
}
