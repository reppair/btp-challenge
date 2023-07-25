<?php

namespace Tests\Feature;

use App\Services\Weather\OpenWeatherOneCall;
use App\Services\Weather\WeatherApi;
use App\Services\Weather\WeatherData;
use Illuminate\Support\Facades\Config;
use Illuminate\Support\Facades\File;
use Illuminate\Support\Facades\Http;
use Illuminate\Support\Str;
use RuntimeException;
use Tests\TestCase;

class WeatherServiceTest extends TestCase
{
    protected WeatherApi $api;

    protected string $key;

    protected float $lat = -46.4178;

    protected float $lon = 166.7696;

    /**
     * @return string
     */
    public function getApiEndpoint(bool $withQueryString = true): string
    {
        $url = Config::get('weather.open-weather.one-call.url');

        $queryString = "?lat=$this->lat&lon=$this->lon&appid=$this->key";

        return $withQueryString ? $url.$queryString : $url;
    }

    protected function setUp(): void
    {
        parent::setUp();

        $this->key = Str::random();

        Config::set('weather.open-weather.key', $this->key);

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
        $stub = File::get(base_path('tests/stubs/open_weather_one_call_200.json'));

        $response = Http::response(json_decode($stub, true));

        Http::fake([$this->getApiEndpoint() => $response]);

        $weatherData = $this->api->setLatitude($this->lat)->setLongitude($this->lon)->getWeatherData();

        $this->assertInstanceOf(WeatherData::class, $weatherData);
    }

    /** @test */
    public function it_will_throw_an_exception_if_the_api_call_fails(): void
    {
        $response = Http::response(['message' => 'Something went wrong!'], 403);

        Http::fake([$this->getApiEndpoint() => $response]);

        $this->expectException(RuntimeException::class);

        $this->expectExceptionCode(0);

        $this->expectExceptionMessage('Something went wrong!');

        $this->api->setLatitude($this->lat)->setLongitude($this->lon)->getWeatherData();
    }
}
