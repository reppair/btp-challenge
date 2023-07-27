<?php

use App\Models\User;
use App\Services\Weather\OpenWeatherOneCall;
use App\Services\Weather\WeatherApi;
use App\Services\Weather\WeatherData;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Support\Facades\Http;
use Tests\OpenWeatherOneCallHelper;
use Tests\TestCase;

uses(TestCase::class, RefreshDatabase::class);

beforeEach(function () {
    User::factory()->count(5)->create();

    $this->apiHelper = OpenWeatherOneCallHelper::make();

    $this->api = app('App\Services\Weather\WeatherApi');
});

it('resolves a weather service implementation', function () {
    expect($this->api)
        ->toBeInstanceOf(WeatherApi::class)
        ->toBeInstanceOf(OpenWeatherOneCall::class);
});

it('returns weather data', function () {
    Http::fake([$this->apiHelper->getApiEndpoint(true) => $this->apiHelper->successfulResponse()]);

    $weatherData = $this->api
        ->setLatitude($this->apiHelper->lat)
        ->setLongitude($this->apiHelper->lon)
        ->getWeatherData();

    expect($weatherData)->toBeInstanceOf(WeatherData::class);
});

it('will throw an exception if the api call fails', function () {
    Http::fake([$this->apiHelper->getApiEndpoint(true) => $this->apiHelper->unauthorizedResponse()]);

    $this->expectException(RuntimeException::class);

    $this->expectExceptionCode(0);

    $this->expectExceptionMessage('status code 403');

    $this->expectExceptionMessage('unauthorized');

    $this->api
        ->setLatitude($this->apiHelper->lat)
        ->setLongitude($this->apiHelper->lon)
        ->getWeatherData();
});
