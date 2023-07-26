<?php

namespace App\Traits;

use App\Actions\CanStoreUserWeather;
use App\Models\User;
use App\Services\Weather\WeatherApi;
use Illuminate\Support\Facades\Log;
use RuntimeException;

trait FetchAndStoreUserWeather
{
    public function fetchAndStoreWeatherData(User $user, WeatherApi $weatherApi, CanStoreUserWeather $action): bool
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

        return $action->execute($user, $weatherData);
    }
}
