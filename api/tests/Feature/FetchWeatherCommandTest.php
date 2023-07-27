<?php

use App\Actions\FetchAndStoreUserWeatherAction;
use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\OpenWeatherOneCallHelper;
use Tests\TestCase;

uses(TestCase::class, RefreshDatabase::class);

it('will fail without users', function () {
    OpenWeatherOneCallHelper::make();

    $this->artisan('fetch-weather')->assertFailed();
});

it('will delegate the work to an action', function () {
    $users = User::factory()->count(5)->create();

    $this->mock(FetchAndStoreUserWeatherAction::class)
        ->shouldReceive('execute')
        ->once()
        ->andReturn($users->pluck('id')->toArray());

    $this->artisan('fetch-weather')->assertSuccessful();
});

it('will fail if the action doesnt return the same amount of user ids', function () {
    $users = User::factory()->count(5)->create();

    $this->mock(FetchAndStoreUserWeatherAction::class)
        ->shouldReceive('execute')
        ->once()
        ->andReturn($users->pluck('id')->reject(fn ($id) => $id == 1)->toArray());

    $this->artisan('fetch-weather')->assertFailed();
});
