<?php

namespace App\Casts;

use App\Services\Weather\WeatherData;
use Illuminate\Contracts\Database\Eloquent\CastsAttributes;
use Illuminate\Database\Eloquent\Model;
use InvalidArgumentException;

class WeatherDataCast implements CastsAttributes
{
    public function get(Model $model, string $key, mixed $value, array $attributes): mixed
    {
        return new WeatherData(...json_decode($value,true));
    }

    public function set(Model $model, string $key, mixed $value, array $attributes): mixed
    {
        /** @var $value WeatherData */
        return ! $value instanceof WeatherData
            ? throw new InvalidArgumentException('Expecting UserWeather::$data attribute to be instance of '.WeatherData::class)
            : json_encode($value->toArray());
    }
}
