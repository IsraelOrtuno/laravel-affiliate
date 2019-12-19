<?php

return [
    'cookie' => [
        'name' => 'referrer',
        'duration' => null // In minutes. null = forever
    ],

    'parameters' => ['ref'],

    'user_model' => '\\App\\User',

    'manage_referrals' => true,

    'tracking_parameters' => [
        'utm_source', 'utm_campaign', 'utm_medium', 'utm_content', 'utm_term'
    ]
];
