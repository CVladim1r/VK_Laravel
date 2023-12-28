<?php

namespace App\Providers;

use Illuminate\Support\ServiceProvider;
use App\Services\VkApiService;
use VK\Client\VKApiClient;
class AppServiceProvider extends ServiceProvider
{
public function register()
    {
        $this->app->singleton(VkApiService::class, function ($app) {
            $vkApiClient = new VKApiClient();
            $accessToken = 'your_actual_vk_access_token';
            $apiVersion = '5.199';

            return new VkApiService($vkApiClient, $accessToken, $apiVersion);
        });
    }
}
