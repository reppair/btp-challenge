<?php

namespace App\Traits;

use App\Actions\StoreUserWeather;
use App\Models\User;
use App\Services\Weather\WeatherApi;

trait FetchAndStoreUserWeather
{
    protected function fetchAndStoreWeatherData(User $user, WeatherApi $weatherApi): bool
    {
        $weatherData = $weatherApi
            ->setLatitude($user->latitude)
            ->setLongitude($user->longitude)
            ->getWeatherData();

        return (new StoreUserWeather)->execute($user, $weatherData);
    }
}
