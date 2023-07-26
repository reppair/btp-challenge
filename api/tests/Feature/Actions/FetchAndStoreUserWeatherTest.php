<?php

namespace Tests\Feature\Actions;

use App\Actions\CanStoreUserWeather;
use App\Actions\FetchAndStoreUserWeather;
use App\Events\WeatherUpdated;
use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Support\Facades\Event;
use Illuminate\Support\Facades\Http;
use Illuminate\Support\Facades\Log;
use Mockery\MockInterface;
use Tests\OpenWeatherOneCallHelper;
use Tests\TestCase;

class FetchAndStoreUserWeatherTest extends TestCase
{
    use RefreshDatabase;

    /** @test */
    public function it_will_fetch_and_store_user_weather(): void
    {
        $users = User::factory()->count(5)->create();

        $helper = OpenWeatherOneCallHelper::make();

        Event::fake();

        Http::fake([$helper->getApiEndpoint() => $helper->successfulResponse()]);

        $this->app[FetchAndStoreUserWeather::class]->execute($users);

        $this->assertDatabaseCount('user_weather', 5);

        Event::assertDispatched(
            WeatherUpdated::class,
            fn (WeatherUpdated $event) => $users->pluck('id')->toArray() === $event->userIds,
        );
    }

    /** @test */
    public function it_wont_fire_a_weather_updated_event_if_no_weather_updates_were_stored(): void
    {
        $users = User::factory()->count(5)->create();

        $helper = OpenWeatherOneCallHelper::make();

        Event::fake();

        Http::fake([$helper->getApiEndpoint() => $helper->unauthorizedResponse()]);

        $this->app[FetchAndStoreUserWeather::class]->execute($users);

        Event::assertNotDispatched(WeatherUpdated::class);
    }

    /** @test */
    public function it_will_catch_the_weather_api_runtime_exception_and_return_false(): void
    {
        $helper = OpenWeatherOneCallHelper::make();

        Http::fake([$helper->getApiEndpoint() => $helper->unauthorizedResponse()]);

        $spy = Log::spy();

        $this->assertFalse($this->app[FetchAndStoreUserWeather::class]->fetchWeatherData(User::factory()->create()));

        $spy->shouldHaveReceived('error');
    }

    /** @test */
    public function it_will_delegate_storing_the_weather_data_to_another_action(): void
    {
        $users = User::factory(3)->create();

        $helper = OpenWeatherOneCallHelper::make();

        Http::fake([$helper->getApiEndpoint() => $helper->successfulResponse()]);

        $this->mock(CanStoreUserWeather::class)
            ->shouldReceive('execute')
            ->times(3);

        $this->app[FetchAndStoreUserWeather::class]->execute($users);
    }

    /** @test */
    public function it_will_return_an_array_of_user_ids_whose_weather_data_got_updated(): void
    {
        $users = User::factory(3)->create();

        $helper = OpenWeatherOneCallHelper::make();

        Http::fake([$helper->getApiEndpoint() => $helper->successfulResponse()]);

        $this->mock(CanStoreUserWeather::class)
            ->shouldReceive('execute')
            ->times(3)
            ->andReturn(true);

        $updatedWeatherForUserIds = $this->app[FetchAndStoreUserWeather::class]->execute($users);

        $this->assertSame($users->pluck('id')->toArray(), $updatedWeatherForUserIds);
    }
}
