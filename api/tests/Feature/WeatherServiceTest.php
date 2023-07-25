<?php

namespace Tests\Feature;

use App\Services\Weather\OpenWeatherOneCall;
use App\Services\Weather\WeatherApi;
use App\Services\Weather\WeatherData;
use Illuminate\Support\Facades\Config;
use Illuminate\Support\Facades\File;
use Illuminate\Support\Facades\Http;
use Illuminate\Support\Str;
use Tests\TestCase;

class WeatherServiceTest extends TestCase
{
    protected WeatherApi $api;

    protected string $key;

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
        $lat = -46.4178;
        $lon = 166.7696;

        $url = Config::get('weather.open-weather.one-call.url') . "?lat=$lat&lon=$lon&appid=$this->key";

        $stub = File::get(base_path('tests/stubs/open_weather_one_call_200.json'));

        $response = Http::response(json_decode($stub, true));

        Http::fake([$url => $response]);

        $weatherData = $this->api->setLatitude($lat)->setLongitude($lon)->getWeatherData();

        $this->assertInstanceOf(WeatherData::class, $weatherData);
    }
}
