<?php

use App\Actions\FetchAndStoreUserWeather;
use App\Jobs\FetchUserWeather;
use App\Models\User;
use Illuminate\Database\Eloquent\Collection;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Support\Carbon;
use Illuminate\Support\Facades\Queue;
use Mockery\MockInterface;
use Tests\TestCase;

uses(TestCase::class, RefreshDatabase::class);

it('gets dispatched by the scheduler', function () {
    $pointInTime = Carbon::parse('2023-03-23 23:23:23');
    $this->travelTo($pointInTime);

    Queue::fake();
    Queue::assertNothingPushed();

    $this->artisan('schedule:run');
    Queue::assertNothingPushed();

    $pointInTime->addMinutes(7);
    $this->travelTo($pointInTime);
    $this->artisan('schedule:run');

    Queue::assertPushed(FetchUserWeather::class);
});

it('will call an action class to do the work', function () {
    $users = User::factory(5)->create();

    $this->mock(FetchAndStoreUserWeather::class)
        ->shouldReceive('execute')
        ->once()
        ->with(Mockery::on(
            fn (Collection $actual) => $actual->diff($users)->isEmpty()
        ));

    FetchUserWeather::dispatch();
});
