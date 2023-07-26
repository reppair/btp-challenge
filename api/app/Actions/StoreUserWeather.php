<?php

namespace App\Actions;

use App\Models\User;
use App\Services\Weather\WeatherData;
use Illuminate\Contracts\Auth\Authenticatable;

class StoreUserWeather implements CanStoreUserWeather
{
    public function execute(User|Authenticatable $user, WeatherData $data): bool
    {
        // let's keep it simple for now just store the entire weather data as json

        $weather = $user->weather()->firstOrNew();

        $weather->data = $data;

        return $weather->save();
    }
}
