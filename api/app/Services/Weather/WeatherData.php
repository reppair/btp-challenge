<?php

namespace App\Services\Weather;

class WeatherData
{
    /**
     * A simple DTO? Sure, why not.
     * Current version doesn't make much sense, it is here just to illustrate that it could be useful.
     */
    public function __construct(
        public readonly float $latitude,
        public readonly float $longitude,
        public readonly string $timezone,
        public readonly float $currentTemp,
        public readonly string $currentWeatherDesc,
    ) {
        // todo: self check if the passed data is valid here...
    }

    public function isValid(): bool
    {
        // todo: validation goodness here...

        return true;
    }
}
