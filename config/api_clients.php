<?php

return [

    // Default client if header/accept not provided
    'default' => env('API_DEFAULT_CLIENT', 'appa'),

    // You can support both ways:
    // 1) X-Client header (easy for mobile apps)
    // 2) Accept vendor media type (best API style)
    'header' => 'X-Client',

    // Vendor accept types -> client key
    'accept' => [
        'application/vnd.myapi.appa+json' => 'appa',
        'application/vnd.myapi.appb+json' => 'appb',
    ],

    // Client profiles (what response shape they want)
    'clients' => [
        'appa' => [
            'profile' => 'compact',
        ],
        'appb' => [
            'profile' => 'full',
        ],
    ],
];
