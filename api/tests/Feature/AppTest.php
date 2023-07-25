<?php

namespace Tests\Feature;

use App\Models\User;
use App\Models\UserWeather;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Testing\Fluent\AssertableJson;
use Tests\TestCase;

class AppTest extends TestCase
{
    use RefreshDatabase;

    protected function setUp(): void
    {
        parent::setUp();

        User::factory(20)->create();
    }

    /** @test */
    public function the_application_returns_a_successful_response(): void
    {
        $response = $this->get('/');

        $response->assertStatus(200);
    }

    /** @test */
    public function database_works(): void
    {
        $this->assertEquals(20, User::all()->count());

        // we don't really want to seed that table right now
        $this->assertEquals(0, UserWeather::all()->count());
    }

    /** @test */
    public function it_returns_a_list_of_users(): void
    {
        $this->getJson('/')
            ->assertJson(fn (AssertableJson $json) =>
                $json->has('users', 20)
                    ->where('users.0.weather', null)
            );
    }

    /** @test */
    public function user_weather_is_included_by_default(): void
    {
        User::each(fn (User $user) => UserWeather::factory()->for($user)->create());

        $this->getJson('/')
            ->assertJson(fn (AssertableJson $json) =>
                $json->has('users', 20)
                    ->where('users.19.weather.id', 20)
                    ->where('users.19.weather.data', fn ($data) => $data !== null)
            );
    }
}
