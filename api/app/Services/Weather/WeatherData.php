<?php

namespace App\Services\Weather;

use Illuminate\Contracts\Support\Arrayable;

class WeatherData implements Arrayable
{
    public function __construct(
        public string $timezone,
        public float $currentTemp,
        public float $currentUvi,
        public float $currentWindSpeed,
        public string $currentWeatherDesc,
        public float $dailyTempMin,
        public float $dailyTempMax,
        public float $dailyTempDay,
        public float $dailyTempNight,
        public float $dailyUvi,
        public float $dailyWindSpeed,
        public string $dailySummary,
    ) {}

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
