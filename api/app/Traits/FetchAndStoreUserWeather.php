<?php

namespace App\Traits;

use App\Actions\StoreUserWeather;
use App\Models\User;
use App\Services\Weather\WeatherApi;
use Illuminate\Support\Facades\Log;
use RuntimeException;

trait FetchAndStoreUserWeather
{
    protected function fetchAndStoreWeatherData(User $user, WeatherApi $weatherApi): bool
    {
        try {
            $weatherData = $weatherApi
                ->setLatitude($user->latitude)
                ->setLongitude($user->longitude)
                ->getWeatherData();
        } catch (RuntimeException $exception) {
            Log::error($exception->getMessage());
            return false;
        }


        return (new StoreUserWeather)->execute($user, $weatherData);
    }
}
