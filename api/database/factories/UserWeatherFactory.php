<?php

namespace Database\Factories;

use App\Models\User;
use App\Services\Weather\WeatherApi;
use App\Services\Weather\WeatherData;
use Illuminate\Database\Eloquent\Factories\Factory;
use Illuminate\Support\Facades\Http;
use Tests\OpenWeatherOneCallHelper;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\UserWeather>
 */
class UserWeatherFactory extends Factory
{
    public function definition(): array
    {
        return [
            'user_id' => User::factory(),
            'data' => $this->getWeatherData(),
        ];
    }

    protected function getWeatherData(): WeatherData
    {
        $helper = OpenWeatherOneCallHelper::make();

        Http::fake([$helper->getApiEndpoint(true) => $helper->successfulResponse()]);

        return app(WeatherApi::class)
            ->setLatitude($helper->lat)
            ->setLongitude($helper->lon)
            ->getWeatherData();
    }
}
