<?php

namespace App\Services\Weather;

interface WeatherApi
{
    public function setLatitude(string $latitude): self;

    public function getLatitude(): ?string;

    public function setLongitude(string $longitude): self;

    public function getLongitude(): ?string;

    public function getWeatherData(): WeatherData;
}
