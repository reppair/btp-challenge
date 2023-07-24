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
            ->latitude($user->latitude)
            ->longitude($user->longitude)
            ->getWeatherData();

        $stored = (new StoreUserWeather)->execute($user, $weatherData);

        if ($stored) {
            $this->usersWithFreshWeatherData[] = $user->id;
        }
    }
}
