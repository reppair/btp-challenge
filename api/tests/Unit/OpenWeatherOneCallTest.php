<?php

namespace Tests\Unit;

use App\Services\Weather\OpenWeatherOneCall;
use App\Services\Weather\WeatherApi;
use App\Services\Weather\WeatherData;
use PHPUnit\Framework\TestCase;
use ReflectionClass;

class OpenWeatherOneCallTest extends TestCase
{
    public WeatherApi $api;

    protected function setUp(): void
    {
        parent::setUp();

        $this->api = new OpenWeatherOneCall(
            apiKey: 'open-weather-api-key',
            apiUrl: 'https://api.openweathermap.org/data/3.0/onecall',
        );
    }

    /** @test */
    public function it_will_get_and_set_latitude(): void
    {
        $this->assertNull($this->api->getLatitude());

        $this->api->setLatitude('lat');

        $this->assertSame('lat', $this->api->getLatitude());
    }

    /** @test */
    public function it_will_get_and_set_longitude(): void
    {
        $this->assertNull($this->api->getLongitude());

        $this->api->setLongitude('lon');

        $this->assertSame('lon', $this->api->getLongitude());
    }

    /** @test */
    public function it_implements_the_get_weather_data_method(): void
    {
        $this->assertTrue(method_exists($this->api, 'getWeatherData'));
    }

    /** @test */
    public function get_weather_return_weather_data_object(): void
    {
        $reflection = new ReflectionClass($this->api);

        $returnType = $reflection->getMethod('getWeatherData')->getReturnType()->getName();

        $this->assertSame(WeatherData::class, $returnType);
    }
}
