<?php

namespace App\Services\Weather;

abstract class Weather
{
    protected string $latitude;

    protected string $longitude;

    public function latitude(string $latitude): WeatherApi
    {
        $this->latitude = $latitude;

        return $this;
    }

    public function longitude(string $longitude): WeatherApi
    {
        $this->longitude = $longitude;

        return $this;
    }
}
