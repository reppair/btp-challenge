<?php

namespace App\Actions;

use App\Events\WeatherUpdated;
use App\Models\User;
use App\Services\Weather\WeatherApi;
use App\Services\Weather\WeatherData;
use Illuminate\Database\Eloquent\Collection;
use Illuminate\Support\Facades\Log;
use RuntimeException;

class FetchAndStoreUserWeatherAction
{
    protected WeatherApi $api;

    public array $usersWithFreshWeatherData = [];

    protected CanStoreUserWeather|StoreUserWeatherAction $storeAction;

    public function __construct(WeatherApi $api, CanStoreUserWeather $storeAction = new StoreUserWeatherAction)
    {
        $this->api = $api;
        $this->storeAction = $storeAction;
    }

    public function execute(Collection $users): array
    {
        $users->each(function (User $user) {
            $weatherData = $this->fetchWeatherData($user);

            if (! $weatherData) {
                return;
            }

            $stored = $this->storeAction->execute($user, $weatherData);

            if ($stored) {
                $this->usersWithFreshWeatherData[] = $user->id;
            }
        });

        if ($this->usersWithFreshWeatherData) {
            event(new WeatherUpdated(userIds: $this->usersWithFreshWeatherData));
        }

        return $this->usersWithFreshWeatherData;
    }

    public function fetchWeatherData(User $user): false|WeatherData
    {
        try {
            $weatherData = $this->api->setLatitude($user->latitude)
                ->setLongitude($user->longitude)
                ->getWeatherData();
        } catch (RuntimeException $exception) {
            Log::error($exception->getMessage());
            return false;
        }

        return $weatherData;
    }
}
