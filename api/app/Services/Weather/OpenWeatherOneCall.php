<?php

namespace App\Services\Weather;

use Illuminate\Http\Client\Response;
use Illuminate\Support\Facades\Http;
use RuntimeException;

class OpenWeatherOneCall extends Weather implements WeatherApi
{
    public function __construct(
        protected string $apiKey,
        protected string $apiUrl,
    ) {}

    public function getWeatherData(): WeatherData
    {
        $response = Http::get($this->apiUrl, [
            'lat' => $this->latitude,
            'lon' => $this->longitude,
            'appid' => $this->apiKey,
        ]);

        if ($response->failed()) {
            throw new RuntimeException(
                "The Open Weather API request failed with status code {$response->status()}. " .
                "The API responded with this message: `{$response->json('message')}`."
            );
        }

        return $this->weatherDataFromResponse($response);
    }

    protected function weatherDataFromResponse(Response $response): WeatherData
    {
        $data = (object) $response->json();

        return new WeatherData(
            latitude: $data->lat,
            longitude: $data->lon,
            timezone: $data->timezone,
            currentTemp: $data->current['temp'],
            currentWeatherDesc: $data->current['weather'][0]['description'],
            daily: $data->daily[0],
        );
    }
}
