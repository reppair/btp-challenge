<?php

namespace Tests\Feature;

use App\Services\Weather\WeatherApi;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Support\Facades\Config;
use Illuminate\Support\Str;
use Tests\TestCase;

class WeatherServiceTest extends TestCase
{
    /** @test */
    public function it_resolves_a_weather_service_implementation(): void
    {
        Config::set('weather.open-weather.key', Str::random());

        $instance = app('App\Services\Weather\WeatherApi');

        $this->assertInstanceOf(WeatherApi::class, $instance);
    }
}
