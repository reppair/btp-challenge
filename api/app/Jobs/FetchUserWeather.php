<?php

namespace App\Jobs;

use App\Events\WeatherUpdated;
use App\Models\User;
use App\Services\Weather\WeatherApi;
use App\Traits\FetchAndStoreUserWeather;
use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Bus\Dispatchable;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Queue\SerializesModels;

class FetchUserWeather implements ShouldQueue
{
    use Dispatchable, InteractsWithQueue, Queueable, SerializesModels, FetchAndStoreUserWeather;

    protected array $usersWithFreshWeatherData = [];

    public function handle(WeatherApi $weatherApi): void
    {
        User::all()->each(function (User $user) use ($weatherApi) {
            $stored = $this->fetchAndStoreWeatherData($user, $weatherApi);

            if ($stored) {
                $this->usersWithFreshWeatherData[] = $user->id;
            }
        });

        if ($this->usersWithFreshWeatherData) {
            event(new WeatherUpdated(userIds: $this->usersWithFreshWeatherData));
        }
    }
}
