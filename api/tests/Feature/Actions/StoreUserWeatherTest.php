<?php

use App\Actions\FetchAndStoreUserWeather;
use App\Actions\StoreUserWeather;
use App\Models\User;
use App\Models\UserWeather;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Illuminate\Support\Facades\Http;
use Tests\OpenWeatherOneCallHelper;
use Tests\TestCase;

uses(TestCase::class, RefreshDatabase::class);

it('will create user weather record if it doesnt exist', function () {
    $helper = OpenWeatherOneCallHelper::make();

    Http::fake([$helper->getApiEndpoint() => $helper->successfulResponse()]);

    $user = User::factory()->create();

    $weatherData = $this->app[FetchAndStoreUserWeather::class]->fetchWeatherData($user);

    $this->assertDatabaseCount('user_weather', 0);

    expect($this->app[StoreUserWeather::class]->execute($user, $weatherData))->toBeTrue();

    $this->assertDatabaseCount('user_weather', 1);
});

it('will update the existing user weather record for a user', function () {
    $helper = OpenWeatherOneCallHelper::make();

    Http::fake([$helper->getApiEndpoint() => $helper->successfulResponse()]);

    $user = User::factory()->has(UserWeather::factory(), 'weather')->create();

    $weatherData = $this->app[FetchAndStoreUserWeather::class]->fetchWeatherData($user);

    $this->assertDatabaseCount('user_weather', 1);

    $this->assertNotEquals($user->weather->data, $weatherData->toArray());

    expect($this->app[StoreUserWeather::class]->execute($user, $weatherData))->toBeTrue();

    $this->assertDatabaseCount('user_weather', 1);

    expect($weatherData->toArray())->toEqual($user->weather->fresh()->data);
});
