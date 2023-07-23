<?php

namespace App\Services\Weather;

interface WeatherApi
{
    public function latitude(string $latitude): self;

    public function longitude(string $longitude): self;

    public function getWeatherData(): WeatherData;
}
