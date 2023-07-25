<?php

namespace App\Traits;

use App\Actions\StoreUserWeather;
use App\Models\User;
use App\Services\Weather\WeatherApi;

trait FetchAndStoreUserWeather
{
    protected function fetchAndStoreWeatherData(User $user, WeatherApi $weatherApi): void
    {
        $weatherData = $weatherApi
            ->setLatitude($user->latitude)
            ->setLongitude($user->longitude)
            ->getWeatherData();

        $stored = (new StoreUserWeather)->execute($user, $weatherData);

        if ($stored) {
            $this->usersWithFreshWeatherData[] = $user->id;
        }
    }
}
