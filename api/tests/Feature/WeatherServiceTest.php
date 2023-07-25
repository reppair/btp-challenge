<?php

namespace Tests\Feature;

use App\Services\Weather\WeatherApi;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Support\Facades\Config;
use Illuminate\Support\Str;
use Tests\TestCase;

class WeatherServiceTest extends TestCase
{
    public WeatherApi $weatherApi;

    protected function setUp(): void
    {
        parent::setUp();

        Config::set('weather.open-weather.key', Str::random());

        $this->weatherApi = app('App\Services\Weather\WeatherApi');
    }

    /** @test */
    public function it_resolves_a_weather_service_implementation(): void
    {
        $this->assertInstanceOf(WeatherApi::class, $this->weatherApi);
    }
}
