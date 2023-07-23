<?php

namespace App\Console\Commands;

use App\Models\User;
use Illuminate\Console\Command;
use Illuminate\Support\Facades\Http;

class FetchWeatherData extends Command
{
    protected $signature = 'fetch-weather';

    protected $description = 'Running this command will fetch weather data for our users from external API.';

    protected array $usersWithoutWeatherData = [];

    protected string|null $apiKey;

    public function handle(): int
    {
        // Implement another API for redundancy or just as secondary option? For fun and to showcase some abstractions?
        $this->apiKey = config('weather.open-weather.key');

        if (! $this->apiKey) {
            $this->error('To run this command you need to set a weather API key first in your .env file.');
            return Command::INVALID;
        }

        $this->line('Fetching weather data for our users...');

        $this->withProgressBar(User::all(), function (User $user) {
            $this->fetchAndStoreWeatherData($user);
        });

        $this->newLine();

        if ($this->usersWithoutWeatherData) {
            $this->error('Could not fetch weather data for some users, please try running the command again.');
        }

        $this->info('Weather data fetched successfully for all users!');

        return Command::SUCCESS;
    }

    protected function fetchAndStoreWeatherData(User $user): void
    {
        // todo: refactor to something better later IF there is time for it..
        $response = Http::get(config('weather.open-weather.url'), [
            'lat' => $user->latitude,
            'lon' => $user->longitude,
            'appid' => $this->apiKey,
        ]);

        if (! $response->successful()) {
            // the command can be later improved by knowing the user ids missing data...
            $this->usersWithoutWeatherData[] = $user->id;
        }

        // let's keep it simple for now just store the entire response, since we don't know what data needs to be displayed
        $weather = $user->weather()->firstOrNew();
        $weather->data = $response->json();
        $weather->save();
    }
}
