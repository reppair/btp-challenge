<?php

use App\Services\Weather\OpenWeatherOneCall;
use App\Services\Weather\WeatherApi;
use App\Services\Weather\WeatherData;

beforeEach(function () {
    $this->api = new OpenWeatherOneCall(
        apiKey: 'open-weather-api-key',
        apiUrl: 'https://api.openweathermap.org/data/3.0/onecall',
    );
});

it('will get and set latitude', function () {
    expect($this->api->getLatitude())->toBeNull();

    $this->api->setLatitude('lat');

    expect($this->api->getLatitude())->toBe('lat');
});

it('will get and set longitude', function () {
    expect($this->api->getLongitude())->toBeNull();

    $this->api->setLongitude('lon');

    expect($this->api->getLongitude())->toBe('lon');
});

it('implements the get weather data method', function () {
    expect(method_exists($this->api, 'getWeatherData'))->toBeTrue();
});

test('get weather return weather data object', function () {
    $reflection = new ReflectionClass($this->api);

    $returnType = $reflection->getMethod('getWeatherData')->getReturnType()->getName();

    expect($returnType)->toBe(WeatherData::class);
});
