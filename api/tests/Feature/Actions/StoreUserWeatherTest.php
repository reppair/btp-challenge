<?php

namespace Tests\Feature\Actions;

use App\Actions\FetchAndStoreUserWeather;
use App\Actions\StoreUserWeather;
use App\Models\User;
use App\Models\UserWeather;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Illuminate\Support\Facades\Http;
use Tests\OpenWeatherOneCallHelper;
use Tests\TestCase;

class StoreUserWeatherTest extends TestCase
{
    use RefreshDatabase;

    /** @test */
    public function it_will_create_user_weather_record_if_it_doesnt_exist(): void
    {
        $helper = OpenWeatherOneCallHelper::make();

        Http::fake([$helper->getApiEndpoint() => $helper->successfulResponse()]);

        $user = User::factory()->create();

        $weatherData = $this->app[FetchAndStoreUserWeather::class]->fetchWeatherData($user);

        $this->assertDatabaseCount('user_weather', 0);

        $this->assertTrue($this->app[StoreUserWeather::class]->execute($user, $weatherData));

        $this->assertDatabaseCount('user_weather', 1);
    }

    /** @test */
    public function it_will_update_the_existing_user_weather_record_for_a_user(): void
    {
        $helper = OpenWeatherOneCallHelper::make();

        Http::fake([$helper->getApiEndpoint() => $helper->successfulResponse()]);

        $user = User::factory()->has(UserWeather::factory(), 'weather')->create();

        $weatherData = $this->app[FetchAndStoreUserWeather::class]->fetchWeatherData($user);

        $this->assertDatabaseCount('user_weather', 1);

        $this->assertNotEquals($user->weather->data, $weatherData->toArray());

        $this->assertTrue($this->app[StoreUserWeather::class]->execute($user, $weatherData));

        $this->assertDatabaseCount('user_weather', 1);

        $this->assertEquals($user->weather->fresh()->data, $weatherData->toArray());
    }
}
