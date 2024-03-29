<?php

return [
    'default' => env('DB_CONNECTION', 'mongodb'),
    'connections' => [
        'testing' => [
            'driver' => 'mongodb',
            'host' => env('DB_HOST', 'localhost'),
            'port' => env('DB_PORT', 27017),
            'database' => env('DB_DATABASE', 'eppyk_test'),
            'username' => env('DB_USERNAME', ''),
            'password' => env('DB_PASSWORD', ''),
            'options' => [],
        ],
        'mongodb' => [
            'driver' => 'mongodb',
            'host' => env('DB_HOST', 'localhost'),
            'port' => env('DB_PORT', 27017),
            'database' => env('DB_DATABASE', 'eppyk'),
            'username' => env('DB_USERNAME', ''),
            'password' => env('DB_PASSWORD', ''),
            'options' => [],
        ],
    ],
    'migrations' => 'migrations',
];