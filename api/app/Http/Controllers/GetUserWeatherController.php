<?php

namespace App\Http\Controllers;

use App\Http\Resources\UserWeatherCollection;
use App\Models\UserWeather;
use Illuminate\Http\Request;

class GetUserWeatherController extends Controller
{
    public function __invoke(Request $request): UserWeatherCollection
    {
        // todo: replace with a repository or a dedicated action class? Whatever, KISS (for now).

        if (! $request->has('user_ids')) {
            return UserWeatherCollection::make(UserWeather::all());
        }

        $validated = $request->validate(['user_ids' => 'required|string']);

        $userIds = explode(',', $validated['user_ids']);

        return UserWeatherCollection::make(UserWeather::whereIn('user_id', $userIds)->get());
    }
}
