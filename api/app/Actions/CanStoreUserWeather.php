<?php

namespace App\Actions;

use App\Services\Weather\WeatherData;
use Illuminate\Contracts\Auth\Authenticatable;

interface CanStoreUserWeather
{
    public function execute(Authenticatable $user, WeatherData $data): bool;
}
