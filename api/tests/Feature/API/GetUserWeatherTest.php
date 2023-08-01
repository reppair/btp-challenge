<?php

use App\Models\UserWeather;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Testing\Fluent\AssertableJson;
use Tests\TestCase;

uses(TestCase::class, RefreshDatabase::class);

beforeEach(function () {
    UserWeather::factory()->count(5)->create();
});

it('will return a collection of user weather records', function () {
    $this->getJson(route('user-weather.index'))
        ->assertSuccessful()
        ->assertJson(fn (AssertableJson $json) =>
            $json->has('data', 5)
                ->has('data.0', fn (AssertableJson $json) =>
                    $json->hasAll(
                        'id',
                        'user_id',
                        'timezone',
                        'current_temp',
                        'current_uvi',
                        'current_wind_speed',
                        'current_weather_desc',
                        'daily_temp_min',
                        'daily_temp_max',
                        'daily_temp_day',
                        'daily_temp_night',
                        'daily_uvi',
                        'daily_wind_speed',
                        'daily_summary',
                    )
                )
                ->has('links', fn (AssertableJson $json) =>
                    $json->where('index', route('user-weather.index'))
                        ->where('create', null)
                        ->where('update', null)
                        ->where('delete', null)
                )
        );
});

it('will filter the user weather index by id', function () {
    $this->getJson(route('user-weather.index', ['user_ids' => '1,2,3']))
        ->assertSuccessful()
        ->assertJson(fn (AssertableJson $json) =>
            $json->has('data', 3)
                ->where('data.0.user_id', 1)
                ->where('data.1.id', 2)
                ->where('data.2.id', 3)
                ->missing('data.3')
                ->has('links')
        );
});
