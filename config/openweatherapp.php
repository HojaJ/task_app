<?php

return [
    'open_weather_api' => env('OPEN_WEATHER_MAP_API', 'https://api.openweathermap.org/data/2.5/weather'),
    'open_weather_api_key' => env('OPEN_WEATHER_MAP_API_KEY'),

    'open_weather_cities' => [
        'Abu Dhabi' => [
            'id' => 292968,
            'country' => 'AE',
            'coord' => [
                'lon' => 54.366669,
                'lat' => 24.466669
            ]
        ],
        'Dubai' => [
            'id' => 292223,
            'country' => 'AE',
            'coord' => [
                'lon' => 55.304722,
                'lat' => 25.258169
            ]
        ],
        'Sharjah' => [
            'id' => 292672,
            'country' => 'AE',
            'coord' => [
                'lon' => 55.403301,
                'lat' => 25.357309
            ]
        ],
        'London' => [
            'id' => 2643743,
            'country' => 'GB',
            'coord' => [
                'lon' => -0.12574,
                'lat' => 51.50853
            ]
        ],
        'New York' => [
            'id' => 5128638,
            'country' => 'US',
            'coord' => [
                'lon' => -75.499901,
                'lat' => 43.000351
            ]
        ],
        'Tokyo' => [
            'id' => 1850147,
            'country' => 'JP',
            'coord' => [
                'lon' => 139.691711,
                'lat' => 35.689499
            ]
        ]
    ]
];
