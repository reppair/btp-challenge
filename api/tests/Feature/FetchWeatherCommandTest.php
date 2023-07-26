<?php

namespace Tests\Feature;

use App\Actions\FetchAndStoreUserWeather;
use App\Console\Commands\FetchUserWeather;
use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Support\Facades\Http;
use Mockery\MockInterface;
use Tests\OpenWeatherOneCallHelper;
use Tests\TestCase;

class FetchWeatherCommandTest extends TestCase
{
    use RefreshDatabase;

    /** @test */
    public function it_will_fail_without_users(): void
    {
        OpenWeatherOneCallHelper::make();

        $this->artisan('fetch-weather')->assertFailed();
    }

    /** @test */
    public function it_will_delegate_the_work_to_an_action(): void
    {
        $users = User::factory()->count(5)->create();

        $this->mock(FetchAndStoreUserWeather::class)
            ->shouldReceive('execute')
            ->once()
            ->andReturn($users->pluck('id')->toArray());

        $this->artisan('fetch-weather')->assertSuccessful();
    }

    /** @test */
    public function it_will_fail_if_the_action_doesnt_return_the_same_amount_of_user_ids(): void
    {
        $users = User::factory()->count(5)->create();

        $this->mock(FetchAndStoreUserWeather::class)
            ->shouldReceive('execute')
            ->once()
            ->andReturn($users->pluck('id')->reject(fn ($id) => $id == 1)->toArray());

        $this->artisan('fetch-weather')->assertFailed();
    }
}
