<?php

namespace Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\UserWeather>
 */
class UserWeatherFactory extends Factory
{
    public function definition(): array
    {
        return [
            'data' => $this->weatherData(),
        ];
    }

    protected function weatherData(): array
    {
        return [
            "lat" => 17.6522,
            "lon" => 127.2504,
            "daily" => [
                [
                    "dt" => 1690081200,
                    "pop" => 1,
                    "uvi" => 11.47,
                    "rain" => 10.44,
                    "temp" => [
                        "day" => 301.53,
                        "eve" => 301.71,
                        "max" => 302.12,
                        "min" => 300.73,
                        "morn" => 301.72,
                        "night" => 300.73,
                    ],
                    "clouds" => 100,
                    "sunset" => 1690106876,
                    "moonset" => 1690119900,
                    "summary" => "Expect a day of partly cloudy with rain",
                    "sunrise" => 1690059998,
                    "weather" => [
                        [
                            "id" => 501,
                            "icon" => "10d",
                            "main" => "Rain",
                            "description" => "moderate rain",
                        ],
                    ],
                    "humidity" => 84,
                    "moonrise" => 1690075260,
                    "pressure" => 1005,
                    "wind_deg" => 61,
                    "dew_point" => 298.64,
                    "wind_gust" => 23.4,
                    "feels_like" => [
                        "day" => 306.95,
                        "eve" => 307.27,
                        "morn" => 306.53,
                        "night" => 305.03,
                    ],
                    "moon_phase" => 0.16,
                    "wind_speed" => 18.01,
                ],
                [
                    "dt" => 1690167600,
                    "pop" => 1,
                    "uvi" => 3.48,
                    "rain" => 64.37,
                    "temp" => [
                        "day" => 300.64,
                        "eve" => 301.24,
                        "max" => 301.62,
                        "min" => 299.71,
                        "morn" => 300.34,
                        "night" => 301.08,
                    ],
                    "clouds" => 100,
                    "sunset" => 1690193260,
                    "moonset" => 1690208220,
                    "summary" => "There will be rain today",
                    "sunrise" => 1690146418,
                    "weather" => [
                        [
                            "id" => 502,
                            "icon" => "10d",
                            "main" => "Rain",
                            "description" => "heavy intensity rain",
                        ],
                    ],
                    "humidity" => 91,
                    "moonrise" => 1690164480,
                    "pressure" => 995,
                    "wind_deg" => 118,
                    "dew_point" => 299,
                    "wind_gust" => 37.82,
                    "feels_like" => [
                        "day" => 305.46,
                        "eve" => 306.82,
                        "morn" => 304.2,
                        "night" => 306.17,
                    ],
                    "moon_phase" => 0.19,
                    "wind_speed" => 29.56,
                ],
                [
                    "dt" => 1690254000,
                    "pop" => 1,
                    "uvi" => 3.34,
                    "rain" => 75.49,
                    "temp" => [
                        "day" => 301.06,
                        "eve" => 301.77,
                        "max" => 302.19,
                        "min" => 300.65,
                        "morn" => 301.04,
                        "night" => 301.93,
                    ],
                    "clouds" => 100,
                    "sunset" => 1690279643,
                    "moonset" => 1690296660,
                    "summary" => "There will be rain today",
                    "sunrise" => 1690232839,
                    "weather" => [
                        [
                            "id" => 502,
                            "icon" => "10d",
                            "main" => "Rain",
                            "description" => "heavy intensity rain",
                        ],
                    ],
                    "humidity" => 89,
                    "moonrise" => 1690253820,
                    "pressure" => 996,
                    "wind_deg" => 155,
                    "dew_point" => 299.06,
                    "wind_gust" => 40.6,
                    "feels_like" => [
                        "day" => 306.45,
                        "eve" => 308.06,
                        "morn" => 306.06,
                        "night" => 308.56,
                    ],
                    "moon_phase" => 0.23,
                    "wind_speed" => 32.15,
                ],
                [
                    "dt" => 1690340400,
                    "pop" => 1,
                    "uvi" => 11.16,
                    "rain" => 12.07,
                    "temp" => [
                        "day" => 302.04,
                        "eve" => 302.05,
                        "max" => 302.29,
                        "min" => 301.6,
                        "morn" => 301.83,
                        "night" => 302.29,
                    ],
                    "clouds" => 100,
                    "sunset" => 1690366026,
                    "moonset" => 1690385340,
                    "summary" => "There will be rain today",
                    "sunrise" => 1690319259,
                    "weather" => [
                        [
                            "id" => 500,
                            "icon" => "10d",
                            "main" => "Rain",
                            "description" => "light rain",
                        ],
                    ],
                    "humidity" => 86,
                    "moonrise" => 1690343280,
                    "pressure" => 1004,
                    "wind_deg" => 181,
                    "dew_point" => 299.34,
                    "wind_gust" => 19.21,
                    "feels_like" => [
                        "day" => 308.9,
                        "eve" => 308.94,
                        "morn" => 308.25,
                        "night" => 309.29,
                    ],
                    "moon_phase" => 0.25,
                    "wind_speed" => 16.13,
                ],
                [
                    "dt" => 1690426800,
                    "pop" => 1,
                    "uvi" => 12.67,
                    "rain" => 18.53,
                    "temp" => [
                        "day" => 302.45,
                        "eve" => 302,
                        "max" => 302.53,
                        "min" => 301.97,
                        "morn" => 302.32,
                        "night" => 302.29,
                    ],
                    "clouds" => 100,
                    "sunset" => 1690452407,
                    "moonset" => 0,
                    "summary" => "There will be rain today",
                    "sunrise" => 1690405679,
                    "weather" => [
                        [
                            "id" => 501,
                            "icon" => "10d",
                            "main" => "Rain",
                            "description" => "moderate rain",
                        ],
                    ],
                    "humidity" => 82,
                    "moonrise" => 1690432980,
                    "pressure" => 1006,
                    "wind_deg" => 191,
                    "dew_point" => 298.99,
                    "wind_gust" => 12.38,
                    "feels_like" => [
                        "day" => 309.22,
                        "eve" => 308.11,
                        "morn" => 309.07,
                        "night" => 307.84,
                    ],
                    "moon_phase" => 0.29,
                    "wind_speed" => 10.66,
                ],
                [
                    "dt" => 1690513200,
                    "pop" => 1,
                    "uvi" => 13,
                    "rain" => 5,
                    "temp" => [
                        "day" => 302.32,
                        "eve" => 302.13,
                        "max" => 302.34,
                        "min" => 302.08,
                        "morn" => 302.34,
                        "night" => 302.26,
                    ],
                    "clouds" => 100,
                    "sunset" => 1690538787,
                    "moonset" => 1690474260,
                    "summary" => "Expect a day of partly cloudy with rain",
                    "sunrise" => 1690492099,
                    "weather" => [
                        [
                            "id" => 500,
                            "icon" => "10d",
                            "main" => "Rain",
                            "description" => "light rain",
                        ],
                    ],
                    "humidity" => 77,
                    "moonrise" => 1690522980,
                    "pressure" => 1004,
                    "wind_deg" => 116,
                    "dew_point" => 297.72,
                    "wind_gust" => 6.66,
                    "feels_like" => [
                        "day" => 307.7,
                        "eve" => 307.2,
                        "morn" => 307.32,
                        "night" => 307.33,
                    ],
                    "moon_phase" => 0.33,
                    "wind_speed" => 5.87,
                ],
                [
                    "dt" => 1690599600,
                    "pop" => 1,
                    "uvi" => 13,
                    "rain" => 6.66,
                    "temp" => [
                        "day" => 302.12,
                        "eve" => 302.02,
                        "max" => 302.27,
                        "min" => 301.92,
                        "morn" => 302.13,
                        "night" => 301.92,
                    ],
                    "clouds" => 60,
                    "sunset" => 1690625167,
                    "moonset" => 1690563660,
                    "summary" => "The day will start with partly cloudy through the late morning hours, transitioning to rain",
                    "sunrise" => 1690578518,
                    "weather" => [
                        [
                            "id" => 500,
                            "icon" => "10d",
                            "main" => "Rain",
                            "description" => "light rain",
                        ],
                    ],
                    "humidity" => 79,
                    "moonrise" => 1690613160,
                    "pressure" => 1001,
                    "wind_deg" => 4,
                    "dew_point" => 298.22,
                    "wind_gust" => 8.11,
                    "feels_like" => [
                        "day" => 307.59,
                        "eve" => 307.74,
                        "morn" => 307.41,
                        "night" => 307.46,
                    ],
                    "moon_phase" => 0.36,
                    "wind_speed" => 7.49,
                ],
                [
                    "dt" => 1690686000,
                    "pop" => 1,
                    "uvi" => 13,
                    "rain" => 9.2,
                    "temp" => [
                        "day" => 302.21,
                        "eve" => 301.97,
                        "max" => 302.27,
                        "min" => 301.63,
                        "morn" => 302,
                        "night" => 301.63,
                    ],
                    "clouds" => 100,
                    "sunset" => 1690711545,
                    "moonset" => 1690653480,
                    "summary" => "There will be rain today",
                    "sunrise" => 1690664938,
                    "weather" => [
                        [
                            "id" => 500,
                            "icon" => "10d",
                            "main" => "Rain",
                            "description" => "light rain",
                        ],
                    ],
                    "humidity" => 83,
                    "moonrise" => 1690703460,
                    "pressure" => 1000,
                    "wind_deg" => 227,
                    "dew_point" => 299.02,
                    "wind_gust" => 20.3,
                    "feels_like" => [
                        "day" => 308.74,
                        "eve" => 308.24,
                        "morn" => 307.48,
                        "night" => 307.63,
                    ],
                    "moon_phase" => 0.4,
                    "wind_speed" => 14.47,
                ],
            ],
        ];
    }
}