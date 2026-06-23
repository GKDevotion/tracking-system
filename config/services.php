<?php

return [

    /*
    |--------------------------------------------------------------------------
    | Third Party Services
    |--------------------------------------------------------------------------
    |
    | This file is for storing the credentials for third party services such
    | as Mailgun, Postmark, AWS and more. This file provides the de facto
    | location for this type of information, allowing packages to have
    | a conventional file to locate the various service credentials.
    |
    */

    'postmark' => [
        'key' => env('POSTMARK_API_KEY'),
    ],

    'resend' => [
        'key' => env('RESEND_API_KEY'),
    ],

    'ses' => [
        'key' => env('AWS_ACCESS_KEY_ID'),
        'secret' => env('AWS_SECRET_ACCESS_KEY'),
        'region' => env('AWS_DEFAULT_REGION', 'us-east-1'),
    ],

    'slack' => [
        'notifications' => [
            'bot_user_oauth_token' => env('SLACK_BOT_USER_OAUTH_TOKEN'),
            'channel' => env('SLACK_BOT_USER_DEFAULT_CHANNEL'),
        ],
    ],

    'twelvedata' => [
        'api_key'  => env('TWELVEDATA_API_KEY'),
        'base_url' => env('TWELVEDATA_BASE_URL', 'https://api.twelvedata.com'),
    ],

    'auto_signal' => [
        'enabled'      => env('AUTO_SIGNAL_ENABLED', false),
        'fire_chance'  => (int) env('AUTO_SIGNAL_FIRE_CHANCE', 50),
        'risk_reward'  => (float) env('AUTO_SIGNAL_RISK_REWARD', 2),
        'pairs'        => array_map('trim', explode(',', env('AUTO_SIGNAL_PAIRS', 'GBP/USD'))),
    ],

    'mt5' => [
        'bridge_url' => env('MT5_BRIDGE_URL'),
        'secret'     => env('MT5_SECRET'),
        'lots'       => (float) env('MT5_DEFAULT_LOTS', 0.01),
        'enabled'    => env('MT5_ENABLED', false),
    ],

];
