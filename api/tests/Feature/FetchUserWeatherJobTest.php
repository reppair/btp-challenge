<?php

namespace Tests\Feature;

use App\Jobs\FetchUserWeather;
use Illuminate\Support\Carbon;
use Illuminate\Support\Facades\Queue;
use Tests\TestCase;

class FetchUserWeatherJobTest extends TestCase
{
    /** @test */
    public function it_gets_dispatched_by_the_scheduler(): void
    {
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
    }

    /** @test */
    public function it_will_fetch_and_store_user_weather(): void
    {
        // todo: need to step out for a bit.. brb
    }
}
