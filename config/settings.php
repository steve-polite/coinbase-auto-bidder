<?php

return [
    'settings_list' => [
        'MAIN_CURRENCY' => [
            'default' => 'EUR'
        ],
        'LANGUAGE' => [
            'default' => 'en',
        ],
        'DEFAULT_DATETIME_FORMAT' => [
            'default' => 'Y-m-d H:i:s',
        ],
        'DISPLAY_TIMEZONE' => [
            'default' => 'utc',
        ]
    ],
    'allowed_languages' => ['en', 'it'],
    'currencies' => [
        'EUR' => [
            'code' => 'EUR',
            'symbol' => '€',
        ],
        'USD' => [
            'code' => 'USD',
            'symbol' => '$',
        ],
        'GBP' => [
            'code' => 'GBP',
            'symbol' => '£',
        ],
    ],
];
