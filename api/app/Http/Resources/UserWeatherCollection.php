<?php

namespace App\Http\Resources;

use App\Services\Weather\WeatherData;
use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\ResourceCollection;

class UserWeatherCollection extends ResourceCollection
{
    public function toArray(Request $request): array
    {
        return [];
    }
}
