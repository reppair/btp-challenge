<?php

namespace App\Http\Resources;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class UserWeatherResource extends JsonResource
{
    /**
     * Transform the resource into an array.
     *
     * @return array<string, mixed>
     */
    public function toArray(Request $request): array
    {
        /** @var $data \App\Services\Weather\WeatherData */
        $data = $this->data;

        return [
            'id' => $this->id,
            'timezone' => $data->timezone,
            'current_temp' => $data->currentTemp,
            'current_uvi' => $data->currentUvi,
            'current_wind_speed' => $data->currentWindSpeed,
            'current_weather_desc' => $data->currentWeatherDesc,
            'daily_temp_min' => $data->dailyTempMin,
            'daily_temp_max' => $data->dailyTempMax,
            'daily_temp_day' => $data->dailyTempDay,
            'daily_temp_night' => $data->dailyTempNight,
            'daily_uvi' => $data->dailyUvi,
            'daily_wind_speed' => $data->dailyWindSpeed,
            'daily_summary' => $data->dailySummary,
        ];
    }
}
