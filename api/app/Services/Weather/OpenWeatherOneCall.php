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
        return new WeatherData(
            timezone: $response->json('timezone'),
            currentTemp: $response->json('current.temp'),
            currentUvi: $response->json('current.uvi'),
            currentWindSpeed: $response->json('current.wind_speed'),
            currentWeatherDesc: $response->json('current.weather.0.description'),
            dailyTempMin: $response->json('daily.0.temp.min'),
            dailyTempMax: $response->json('daily.0.temp.max'),
            dailyTempDay: $response->json('daily.0.temp.day'),
            dailyTempNight: $response->json('daily.0.temp.night'),
            dailyUvi: $response->json('daily.0.uvi'),
            dailyWindSpeed: $response->json('daily.0.wind_speed'),
            dailySummary: $response->json('daily.0.summary'),
        );
    }
}
