<?php

namespace App\Http\Resources;

use App\Services\Weather\WeatherData;
use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\ResourceCollection;

class UserWeatherCollection extends ResourceCollection
{
    public function toArray(Request $request): array
    {
        return [
            'data' => $this->collection,
            'links' => [
                'index' => route('user-weather.index'),
                'create' => null,
                'update' => null,
                'delete' => null,
            ],
        ];
    }
}
