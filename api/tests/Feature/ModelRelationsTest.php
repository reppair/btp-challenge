<?php

use App\Models\User;
use App\Models\UserWeather;
use Illuminate\Database\Eloquent\Factories\Factory;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasOne;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

uses(TestCase::class, RefreshDatabase::class);

test('user has one user weather', function () {
    expect(User::factory())->toHasOne('weather', UserWeather::factory());
});

test('user weather belongs to user', function () {
    expect(UserWeather::factory())->toBelongTo('user', User::factory());
});
