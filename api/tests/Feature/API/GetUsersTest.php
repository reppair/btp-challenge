<?php

use App\Models\User;
use App\Models\UserWeather;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Testing\Fluent\AssertableJson;
use Tests\TestCase;

uses(TestCase::class, RefreshDatabase::class);

beforeEach(function () {
    User::factory()->count(5)->create();
});

it('will return a collection of users', function () {
    $this->getJson(route('users.index'))
        ->assertSuccessful()
        ->assertJson(fn (AssertableJson $json) =>
            $json->has('data', fn (AssertableJson $json) =>
                    $json->hasAll('0.id', '0.name', '0.email')
                        ->etc()
                )
                ->has('links', fn (AssertableJson $json) =>
                    $json->where('index', route('users.index'))
                        ->where('create', null)
                        ->where('update', null)
                        ->where('delete', null)
                )
        );
});

test('the user weather can be loaded via query parameter', function () {

    /** @var UserWeather $weather */
    $weather = UserWeather::factory()->for(User::find(2))->create();

    /** @var \App\Services\Weather\WeatherData $data */
    $data = $weather->data;

    $this->getJson(route('users.index', ['with' => 'weather']))
        ->assertSuccessful()
        ->assertJson(fn (AssertableJson $json) =>
            $json->has('data.0.weather', null) // user#1 has no weather
                ->has('data.1.weather', fn (AssertableJson $json) =>
                    $json->where('id', $weather->id)
                        ->where('user_id', $weather->user_id)
                        ->where('timezone', $data->timezone)
                        ->where('current_temp', json_decode($data->currentTemp))
                        ->where('current_uvi', json_decode($data->currentUvi))
                        ->where('current_wind_speed', json_decode($data->currentWindSpeed))
                        ->where('current_weather_desc', $data->currentWeatherDesc)
                        ->where('daily_temp_min', json_decode($data->dailyTempMin))
                        ->where('daily_temp_max', json_decode($data->dailyTempMax))
                        ->where('daily_temp_day', json_decode($data->dailyTempDay))
                        ->where('daily_temp_night', json_decode($data->dailyTempNight))
                        ->where('daily_uvi', json_decode($data->dailyUvi))
                        ->where('daily_wind_speed', json_decode($data->dailyWindSpeed))
                        ->where('daily_summary', $data->dailySummary)
                )
                ->etc()
        );
});
