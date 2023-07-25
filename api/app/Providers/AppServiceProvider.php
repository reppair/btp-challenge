<?php

namespace App\Providers;

use App\Services\Weather\OpenWeatherOneCall;
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
        $this->app->bind(WeatherApi::class, function () {
            return new OpenWeatherOneCall(
                apiKey: config('weather.open-weather.key'),
                apiUrl: config('weather.open-weather.one-call.url'),
            );
        });
    }
}
