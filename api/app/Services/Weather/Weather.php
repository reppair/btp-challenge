<?php

namespace App\Services\Weather;

abstract class Weather
{
    protected ?string $latitude = null;

    protected ?string $longitude = null;

    public function setLatitude(string $latitude): WeatherApi
    {
        $this->latitude = $latitude;

        return $this;
    }

    public function getLatitude(): ?string
    {
        return $this->latitude;
    }

    public function setLongitude(string $longitude): WeatherApi
    {
        $this->longitude = $longitude;

        return $this;
    }

    public function getLongitude(): ?string
    {
        return $this->longitude;
    }
}
