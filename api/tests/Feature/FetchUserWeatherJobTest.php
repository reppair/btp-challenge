<?php

namespace Tests\Feature;

use App\Actions\FetchAndStoreUserWeather;
use App\Jobs\FetchUserWeather;
use App\Models\User;
use Illuminate\Database\Eloquent\Collection;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Support\Carbon;
use Illuminate\Support\Facades\Queue;
use Mockery;
use Mockery\MockInterface;
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
    public function it_will_call_an_action_class_to_do_the_work(): void
    {
        $users = User::factory(5)->create();

        $this->mock(FetchAndStoreUserWeather::class)
            ->shouldReceive('execute')
            ->once()
            ->with(Mockery::on(
                fn (Collection $actual) => $actual->diff($users)->isEmpty()
            ));

        FetchUserWeather::dispatch();
    }
}
