<?php

namespace App\Console\Commands;

use App\Actions\StoreUserWeather;
use App\Models\User;
use App\Services\Weather\WeatherApi;
use Illuminate\Console\Command;

class FetchUserWeather extends Command
{
    protected $signature = 'fetch-weather';

    protected $description = 'Running this command will fetch weather data for our users from external API.';

    protected array $usersWithoutWeatherData = [];

    public function handle(WeatherApi $weatherApi): int
    {
        $this->line('Fetching weather data for our users...');

        $this->withProgressBar(User::all(), fn (User $user) => $this->fetchAndStoreWeatherData($user, $weatherApi));

        $this->newLine();

        if ($this->usersWithoutWeatherData) {
            $this->error('Could not fetch weather data for some users, please try running the command again.');
        }

        $this->info('Weather data fetched successfully for all users!');

        return Command::SUCCESS;
    }

    protected function fetchAndStoreWeatherData(User $user, WeatherApi $weatherApi): void
    {
        $weatherData = $weatherApi
            ->latitude($user->latitude)
            ->longitude($user->longitude)
            ->getWeatherData();

        if (! $weatherData->isValid()) {
            // the command can be later improved by knowing the user ids missing data...
            $this->usersWithoutWeatherData[] = $user->id;

            return;
        }

        (new StoreUserWeather)->execute($user, $weatherData);
    }
}
