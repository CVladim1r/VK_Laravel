<?php

namespace App\Providers;

use Illuminate\Support\ServiceProvider;
use App\Services\VkApiService;

class AppServiceProvider extends ServiceProvider
{
    /**
     * Register any application services.
     */
    public function register(): void
    {
        $this->app->singleton(VkApiService::class, function ($app) {
            return new VkApiService();
        });
    }
}
