<?php

namespace Tests;

use GuzzleHttp\Promise\PromiseInterface;
use Illuminate\Support\Facades\Config;
use Illuminate\Support\Facades\File;
use Illuminate\Support\Facades\Http;
use Illuminate\Support\Str;

class OpenWeatherOneCallHelper
{
    public readonly string $key;

    public readonly float $lat;

    public readonly float $lon;

    public static function make(): static
    {
        $instance = new static;

        $instance->lat = -46.4178;

        $instance->lon = 166.7696;

        $instance->key = Str::random();

        Config::set('weather.open-weather.key', $instance->key);

        return $instance;
    }

    public function getApiEndpoint(bool $withQueryString = false): string
    {
        $url = Config::get('weather.open-weather.one-call.url');

        $queryString = "?lat=$this->lat&lon=$this->lon&appid=$this->key";

        return $withQueryString ? $url.$queryString : "$url*";
    }

    public function successfulResponse(): PromiseInterface
    {
        $stub = File::get(base_path('tests/stubs/open_weather_one_call_200.json'));

        return Http::response(json_decode($stub, true));
    }

    public function unauthorizedResponse(): PromiseInterface
    {
        return Http::response(['message' => 'unauthorized'], 403);
    }
}
