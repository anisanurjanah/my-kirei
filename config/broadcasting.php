<?php

return [

    'default' => env('BROADCAST_CONNECTION', 'null'),

    'connections' => [
        'pusher' => [
            'driver' => 'pusher',
            'key' => env('PUSHER_APP_KEY'),
            'secret' => env('PUSHER_APP_SECRET'),
            'app_id' => env('PUSHER_APP_ID'),
            'options' => [
                'cluster' => env('PUSHER_APP_CLUSTER'),
                'host' => '0c23-202-179-190-20.ngrok-free.app',
                'port' => env('PUSHER_PORT', 443),
                'scheme' => 'https',
                // 'host' => env('PUSHER_HOST', 'api-2b07-202-179-190-20.ngrok-free.app'),
                // 'host' => env('PUSHER_HOST') ?: 'api-'.env('PUSHER_APP_CLUSTER', 'mt1').'.pusher.com',
                // 'scheme' => env('PUSHER_SCHEME', 'https'),
                'encrypted' => true,
                'useTLS' => true
                // 'useTLS' => env('PUSHER_SCHEME', 'https') === 'https',
            ],
        ],

    ],

];
