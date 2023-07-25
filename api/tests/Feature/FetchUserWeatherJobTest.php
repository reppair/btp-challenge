<?php

namespace Tests\Feature;

use App\Events\WeatherUpdated;
use App\Jobs\FetchUserWeather;
use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Support\Carbon;
use Illuminate\Support\Facades\Event;
use Illuminate\Support\Facades\Http;
use Illuminate\Support\Facades\Queue;
use Tests\OpenWeatherOneCallHelper;
use Tests\TestCase;

class FetchUserWeatherJobTest extends TestCase
{
    use RefreshDatabase;

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
        $this->assertDatabaseCount('users', 0);
        $this->assertDatabaseCount('user_weather', 0);

        $helper = OpenWeatherOneCallHelper::make();

        Event::fake();

        Http::fake([$helper->getApiEndpoint() => $helper->successfulResponse()]);

        FetchUserWeather::dispatch();

        Event::assertNotDispatched(WeatherUpdated::class);

        User::factory()->count(5)->create();

        FetchUserWeather::dispatch();

        $this->assertDatabaseCount('user_weather', 5);

        Event::assertDispatched(WeatherUpdated::class);
    }
}
