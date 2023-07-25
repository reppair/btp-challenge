<?php

namespace Tests\Feature;

use App\Models\User;
use App\Services\Weather\OpenWeatherOneCall;
use App\Services\Weather\WeatherApi;
use App\Services\Weather\WeatherData;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Support\Facades\File;
use Illuminate\Support\Facades\Http;
use RuntimeException;
use Tests\OpenWeatherOneCallHelper;
use Tests\TestCase;

class WeatherServiceTest extends TestCase
{
    use RefreshDatabase;

    protected WeatherApi $api;

    protected OpenWeatherOneCallHelper $apiHelper;

    protected function setUp(): void
    {
        parent::setUp();

        User::factory()->count(5)->create();

        $this->apiHelper = OpenWeatherOneCallHelper::make();

        $this->api = app('App\Services\Weather\WeatherApi');
    }

    /** @test */
    public function it_resolves_a_weather_service_implementation(): void
    {
        $this->assertInstanceOf(WeatherApi::class, $this->api);

        $this->assertInstanceOf(OpenWeatherOneCall::class, $this->api);
    }

    /** @test */
    public function it_returns_weather_data(): void
    {
        Http::fake([$this->apiHelper->getApiEndpoint(true) => $this->apiHelper->successfulResponse()]);

        $weatherData = $this->api
            ->setLatitude($this->apiHelper->lat)
            ->setLongitude($this->apiHelper->lon)
            ->getWeatherData();

        $this->assertInstanceOf(WeatherData::class, $weatherData);
    }

    /** @test */
    public function it_will_throw_an_exception_if_the_api_call_fails(): void
    {
        Http::fake([$this->apiHelper->getApiEndpoint(true) => $this->apiHelper->unauthorizedResponse()]);

        $this->expectException(RuntimeException::class);

        $this->expectExceptionCode(0);

        $this->expectExceptionMessage('status code 403');

        $this->expectExceptionMessage('unauthorized');

        $this->api
            ->setLatitude($this->apiHelper->lat)
            ->setLongitude($this->apiHelper->lon)
            ->getWeatherData();
    }
}
