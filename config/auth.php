<?php

return [

    
    'defaults' => [
        'guard' => 'web',
        'passwords' => 'hocviens',
    ],


    'guards' => [
        'web' => [
            'driver' => 'session',
            'provider' => 'hocviens',
        ],
        'giangvien' => [
            'driver' => 'session',
            'provider' => 'giangviens',
        ],
        'admin' => [
            'driver' => 'session',
            'provider' => 'admins',
        ],
    ],



    'providers' => [
        'hocviens' => [
            'driver' => 'eloquent',
            'model' => App\Models\HocVien::class,
        ],
        'giangviens' => [
            'driver' => 'eloquent',
            'model' => App\Models\GiangVien::class,
        ],
        'admins' => [
            'driver' => 'eloquent',
            'model' => App\Models\Admin::class,
        ],
    ],


    'passwords' => [
        'hocviens' => [
            'provider' => 'hocviens',
            'table' => 'password_resets',
            'expire' => 60,
            'throttle' => 60,
        ],
        'giangviens' => [
            'provider' => 'giangviens',
            'table' => 'password_resets',
            'expire' => 60,
            'throttle' => 60,
        ],
        'admins' => [
            'provider' => 'admins',
            'table' => 'password_resets',
            'expire' => 60,
            'throttle' => 60,
        ],
    ],

    'password_timeout' => 10800,

];