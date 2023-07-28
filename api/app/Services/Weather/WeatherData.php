<?php

namespace App\Services\Weather;

use Illuminate\Contracts\Support\Arrayable;

class WeatherData implements Arrayable
{
    public function __construct(
        public readonly string $timezone,
        public readonly float $currentTemp,
        public readonly float $currentUvi,
        public readonly float $currentWindSpeed,
        public readonly string $currentWeatherDesc,
        public readonly float $dailyTempMin,
        public readonly float $dailyTempMax,
        public readonly float $dailyTempDay,
        public readonly float $dailyTempNight,
        public readonly float $dailyUvi,
        public readonly float $dailyWindSpeed,
        public readonly string $dailySummary,
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
