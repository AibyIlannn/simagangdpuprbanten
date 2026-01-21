<?php

return [
    'defaults' => [
        'guard' => 'web',
        'passwords' => 'users',
    ],

    'guards' => [
        'web' => [
            'driver' => 'session',
            'provider' => 'users',
        ],

        'superadmin' => [
            'driver' => 'session',
            'provider' => 'superadmins',
        ],

        'admin' => [
            'driver' => 'session',
            'provider' => 'admins',
        ],

        'kordinator' => [
            'driver' => 'session',
            'provider' => 'kordinators',
        ],
    ],

    'providers' => [
        'users' => [
            'driver' => 'eloquent',
            'model' => App\Models\User::class,
        ],

        'superadmins' => [
            'driver' => 'eloquent',
            'model' => App\Models\SuperAdmin::class,
        ],

        'admins' => [
            'driver' => 'eloquent',
            'model' => App\Models\Admin::class,
        ],

        'kordinators' => [
            'driver' => 'eloquent',
            'model' => App\Models\Kordinator::class,
        ],
    ],

    'passwords' => [
        'users' => [
            'provider' => 'users',
            'table' => 'password_reset_tokens',
            'expire' => 60,
            'throttle' => 60,
        ],
    ],

    'password_timeout' => 10800,
];