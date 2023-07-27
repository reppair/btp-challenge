<?php

use App\Models\User;
use App\Models\UserWeather;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Testing\Fluent\AssertableJson;
use Tests\TestCase;

uses(TestCase::class, RefreshDatabase::class);

beforeEach(function () {
    User::factory(20)->create();
});

test('the application returns a successful response', function () {
    $response = $this->get('/');

    $response->assertStatus(200);
});

test('database works', function () {
    expect(User::all()->count())
        ->toEqual(20)
        ->and(UserWeather::all()->count())
        ->toEqual(0);
});

it('returns a list of users', function () {
    $this->getJson('/')
        ->assertJson(fn (AssertableJson $json) =>
            $json->has('users', 20)
                ->where('users.0.weather', null));
});

test('user weather is included by default', function () {
    User::each(fn (User $user) => UserWeather::factory()->for($user)->create());

    $this->getJson('/')
        ->assertJson(fn (AssertableJson $json) =>
            $json->has('users', 20)
                ->where('users.19.weather.id', 20)
                ->where('users.19.weather.data', fn ($data) => $data !== null));
});
