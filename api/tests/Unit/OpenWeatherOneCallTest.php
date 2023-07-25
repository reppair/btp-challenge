<?php

namespace Tests\Unit;

use App\Services\Weather\OpenWeatherOneCall;
use App\Services\Weather\WeatherApi;
use PHPUnit\Framework\TestCase;

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
}
