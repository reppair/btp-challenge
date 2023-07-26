<?php

namespace Tests\Feature;

use App\Actions\StoreUserWeather;
use App\Events\WeatherUpdated;
use App\Jobs\FetchUserWeather;
use App\Models\User;
use App\Services\Weather\WeatherApi;
use App\Traits\FetchAndStoreUserWeather;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Support\Carbon;
use Illuminate\Support\Facades\Event;
use Illuminate\Support\Facades\Http;
use Illuminate\Support\Facades\Log;
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
        User::factory()->count(5)->create();

        $helper = OpenWeatherOneCallHelper::make();

        Event::fake();

        Http::fake([$helper->getApiEndpoint() => $helper->successfulResponse()]);

        FetchUserWeather::dispatch();

        Event::assertDispatched(WeatherUpdated::class);
    }

    /** @test */
    public function it_wont_fire_a_weather_updated_event_if_no_weather_updates_were_stored(): void
    {
        User::factory()->count(5)->create();

        $helper = OpenWeatherOneCallHelper::make();

        Event::fake();

        Http::fake([$helper->getApiEndpoint() => $helper->unauthorizedResponse()]);

        FetchUserWeather::dispatch();

        Event::assertNotDispatched(WeatherUpdated::class);
    }

    /** @test */
    public function it_will_catch_the_weather_api_runtime_exception_and_return_false(): void
    {
        $helper = OpenWeatherOneCallHelper::make();

        Http::fake([$helper->getApiEndpoint() => $helper->unauthorizedResponse()]);

        $instance = new class {
            use FetchAndStoreUserWeather;
        };

        $spy = Log::spy();

        $this->assertFalse($instance->fetchAndStoreWeatherData(
            user: User::factory()->create(),
            weatherApi: $this->app[WeatherApi::class],
            action: new StoreUserWeather,
        ));

        $spy->shouldHaveReceived('error');
    }

    /** @test */
    public function it_will_execute_an_action_class_and_return_the_result(): void
    {
        $helper = OpenWeatherOneCallHelper::make();

        Http::fake([$helper->getApiEndpoint() => $helper->successfulResponse()]);

        $instance = new class {
            use FetchAndStoreUserWeather;
        };

        $actionMock = $this->getMockBuilder(StoreUserWeather::class)->getMock();

        $actionMock->expects($this->once())
            ->method('execute')
            ->willReturn(true);

        $this->assertTrue($instance->fetchAndStoreWeatherData(
            user: User::factory()->create(),
            weatherApi: $this->app[WeatherApi::class],
            action: $actionMock,
        ));
    }
}
