<?php

use App\Models\UserWeather;
use App\Services\Weather\WeatherData;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

uses(TestCase::class, RefreshDatabase::class);

it('throws an exception when not passing WeatherData to it', fn () => new UserWeather(['data' => null]))
    ->throws(InvalidArgumentException::class, 'to be instance of '. WeatherData::class);

it('will cast to WeatherData object', function () {
    expect(UserWeather::factory()->create()->fresh()->data)->toBeInstanceOf(WeatherData::class);
});
