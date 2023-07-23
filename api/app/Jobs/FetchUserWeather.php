<?php

namespace App\Jobs;

use App\Actions\StoreUserWeather;
use App\Models\User;
use App\Services\Weather\WeatherApi;
use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldBeUnique;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Bus\Dispatchable;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Queue\SerializesModels;

class FetchUserWeather implements ShouldQueue
{
    use Dispatchable, InteractsWithQueue, Queueable, SerializesModels;

    public function handle(WeatherApi $weatherApi): void
    {
        User::all()->each(function (User $user) use ($weatherApi) {
            $weatherData = $weatherApi
                ->latitude($user->latitude)
                ->longitude($user->longitude)
                ->getWeatherData();

           (new StoreUserWeather)->execute($user, $weatherData);
        });
    }
}
