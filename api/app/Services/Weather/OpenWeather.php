<?php

namespace App\Services\Weather;

use Exception;
use Illuminate\Http\Client\Response;
use Illuminate\Support\Facades\Http;

class OpenWeather extends Weather implements WeatherApi
{
    protected string $apiKey;

    protected string $apiUrl;

    public function __construct()
    {
        $this->apiKey = config('weather.open-weather.key');

        $this->apiUrl = config('weather.open-weather.url');

        throw_if(
            ! $this->apiKey,
            new Exception('Open Weather API key not set. You can set the key in .env as `OPEN_WEATHER_KEY`!')
        );
    }

    public function getWeatherData(): WeatherData
    {
        $response = Http::get($this->apiUrl, [
            'lat' => $this->latitude,
            'lon' => $this->longitude,
            'appid' => $this->apiKey,
        ]);

        if ($response->failed()) {
            throw new Exception(
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
