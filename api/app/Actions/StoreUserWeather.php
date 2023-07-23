<?php

namespace App\Actions;

use App\Models\User;
use App\Services\Weather\WeatherData;

class StoreUserWeather
{
    public function execute(User $user, WeatherData $weatherData): bool
    {
        // let's keep it simple for now just store the entire weather data as json

        $weather = $user->weather()->firstOrNew();

        $weather->data = $weatherData;

        return $weather->save();
    }
}
