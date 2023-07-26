<?php

namespace App\Services\Weather;

use Illuminate\Contracts\Support\Arrayable;

class WeatherData implements Arrayable
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
        public readonly array $daily, // should really be a dedicated object in our domain (external services should not dictate our own data structures)
    ) {
        // todo: self check if the passed data is valid here...
    }

    public function isValid(): bool
    {
        // todo: validation goodness here...

        return true;
    }

    public function toArray(): array
    {
        return (array) $this;
    }
}
