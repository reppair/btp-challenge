<?php

namespace App\Services\Weather;

class WeatherData
{
    /**
     * A simple DTO? Sure, why not.
     *
     * Current doesn't make much sense, it is here just to illustrate that it could be useful if we had more detailed feature spec.
     */
    public function __construct(
        public readonly string $latitude,
        public readonly string $longitude,
        public readonly string $timezone,
    ) {
        // self check if the passed data is valid here...
    }

    public function isValid(): bool
    {
        // validation goodness here...

        return true;
    }
}
