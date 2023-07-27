<?php

namespace App\Console\Commands;

use App\Actions\FetchAndStoreUserWeatherAction;
use App\Models\User;
use Illuminate\Console\Command;

class FetchUserWeather extends Command
{
    protected $signature = 'fetch-weather';

    protected $description = 'Running this command will fetch weather data for our users from external API.';

    protected array $usersWithFreshWeatherData = [];

    public function handle(FetchAndStoreUserWeatherAction $fetchAndStoreUserWeather): int
    {
        $users = User::all();

        if ($users->isEmpty()) {
            $this->error('We have no users! :(');
            return Command::FAILURE;
        }

        $this->info("Fetching weather data for {$users->count()} users. It might take a bit!");

        $usersWithFreshWeatherData = $fetchAndStoreUserWeather->execute($users);

        if ($users->count() != count($usersWithFreshWeatherData)) {
            $this->error('Could not fetch weather data for some users, please try running the command again.');
            return Command::FAILURE;
        }

        $this->info('Weather data fetched successfully for all users!');

        return Command::SUCCESS;
    }
}
