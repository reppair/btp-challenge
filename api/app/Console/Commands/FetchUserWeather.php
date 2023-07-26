<?php

namespace App\Console\Commands;

use App\Actions\StoreUserWeather;
use App\Events\WeatherUpdated;
use App\Models\User;
use App\Services\Weather\WeatherApi;
use Illuminate\Console\Command;

class FetchUserWeather extends Command
{
    protected $signature = 'fetch-weather';

    protected $description = 'Running this command will fetch weather data for our users from external API.';

    protected array $usersWithFreshWeatherData = [];

    public function handle(WeatherApi $weatherApi): int
    {
        $this->line('Fetching weather data for our users...');

//        $this->withProgressBar(User::all(), function (User $user) use ($weatherApi) {
//            $stored = $this->fetchAndStoreWeatherData($user, $weatherApi, new StoreUserWeather);
//
//            if ($stored) {
//                $this->usersWithFreshWeatherData[] = $user->id;
//            }
//        });

        $this->newLine();

        event(new WeatherUpdated(userIds: $this->usersWithFreshWeatherData));

        if (count($this->usersWithFreshWeatherData) != User::count()) {
            $this->error('Could not fetch weather data for some users, please try running the command again.');
            return Command::FAILURE;
        }

        $this->info('Weather data fetched successfully for all users!');

        return Command::SUCCESS;
    }
}
