<?php

use App\Services\Weather\Weather;

beforeEach(function () {
    $this->weather = new ReflectionClass(Weather::class);
});

it('is an abstract class', function () {
    expect($this->weather->isAbstract())->toBeTrue();
});

it('Expect Pest PHP to be awesome!', fn () => expect('awesome')->toBeAwesome());
