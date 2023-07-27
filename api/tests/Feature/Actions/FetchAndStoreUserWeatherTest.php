<?php

use App\Actions\CanStoreUserWeather;
use App\Actions\FetchAndStoreUserWeatherAction;
use App\Events\WeatherUpdated;
use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Support\Facades\Event;
use Illuminate\Support\Facades\Http;
use Illuminate\Support\Facades\Log;
use Tests\OpenWeatherOneCallHelper;
use Tests\TestCase;

uses(TestCase::class, RefreshDatabase::class);

it('will fetch and store user weather', function () {
    $users = User::factory()->count(5)->create();

    $helper = OpenWeatherOneCallHelper::make();

    Event::fake();

    Http::fake([$helper->getApiEndpoint() => $helper->successfulResponse()]);

    $this->app[FetchAndStoreUserWeatherAction::class]->execute($users);

    $this->assertDatabaseCount('user_weather', 5);

    Event::assertDispatched(
        WeatherUpdated::class,
        fn (WeatherUpdated $event) => $users->pluck('id')->toArray() === $event->userIds,
    );
});

it('wont fire a weather updated event if no weather updates were stored', function () {
    $users = User::factory()->count(5)->create();

    $helper = OpenWeatherOneCallHelper::make();

    Event::fake();

    Http::fake([$helper->getApiEndpoint() => $helper->unauthorizedResponse()]);

    $this->app[FetchAndStoreUserWeatherAction::class]->execute($users);

    Event::assertNotDispatched(WeatherUpdated::class);
});

it('will catch the weather api runtime exception and return false', function () {
    $helper = OpenWeatherOneCallHelper::make();

    Http::fake([$helper->getApiEndpoint() => $helper->unauthorizedResponse()]);

    $spy = Log::spy();

    expect($this->app[FetchAndStoreUserWeatherAction::class]->fetchWeatherData(User::factory()->create()))->toBeFalse();

    $spy->shouldHaveReceived('error');
});

it('will delegate storing the weather data to another action', function () {
    $users = User::factory(3)->create();

    $helper = OpenWeatherOneCallHelper::make();

    Http::fake([$helper->getApiEndpoint() => $helper->successfulResponse()]);

    $this->mock(CanStoreUserWeather::class)
        ->shouldReceive('execute')
        ->times(3);

    $this->app[FetchAndStoreUserWeatherAction::class]->execute($users);
});

it('will return an array of user ids whose weather data got updated', function () {
    $users = User::factory(3)->create();

    $helper = OpenWeatherOneCallHelper::make();

    Http::fake([$helper->getApiEndpoint() => $helper->successfulResponse()]);

    $this->mock(CanStoreUserWeather::class)
        ->shouldReceive('execute')
        ->times(3)
        ->andReturn(true);

    $updatedWeatherForUserIds = $this->app[FetchAndStoreUserWeatherAction::class]->execute($users);

    expect($updatedWeatherForUserIds)->toBe($users->pluck('id')->toArray());
});
