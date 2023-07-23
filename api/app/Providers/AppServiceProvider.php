<?php

namespace App\Providers;

use App\Services\Weather\OpenWeather;
use App\Services\Weather\WeatherApi;
use Illuminate\Support\ServiceProvider;

class AppServiceProvider extends ServiceProvider
{
    public function register(): void
    {
        //
    }

    public function boot(): void
    {
        $this->app->bind(WeatherApi::class, OpenWeather::class);
    }
}
