<?php

return [

    'defaults' => [
        'guard' => 'web',       // default guard
        'passwords' => 'kasirs', // default password broker
    ],

    'guards' => [
        'web' => [
            'driver' => 'session',
            'provider' => 'kasirs',
        ],

        'kasir' => [
            'driver' => 'session',
            'provider' => 'kasirs',
        ],
    ],

    'providers' => [
        'users' => [
            'driver' => 'eloquent',
            'model' => App\Models\kasir::class,
        ],

        'kasirs' => [
            'driver' => 'eloquent',
            'model' => App\Models\Kasir::class,
        ],
    ],

    'passwords' => [
        'users' => [
            'provider' => 'users',
            'table' => 'password_resets',
            'expire' => 60,
            'throttle' => 60,
        ],

        'kasirs' => [
            'provider' => 'kasirs',
            'table' => 'password_resets',
            'expire' => 60,
            'throttle' => 60,
        ],
    ],

];
