<?php

return [

    /**
     * Open Weather API configuration.
     */
    'open-weather' => [
        'key' => env('OPEN_WEATHER_KEY'),

        'one-call' => [
            'url' => 'https://api.openweathermap.org/data/3.0/onecall',
        ],
    ],

];
