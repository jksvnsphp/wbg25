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

    'mailgun' => [
        'domain' => env('MAILGUN_DOMAIN'),
        'secret' => env('MAILGUN_SECRET'),
        'endpoint' => env('MAILGUN_ENDPOINT', 'api.mailgun.net'),
        'scheme' => 'https',
    ],

    'postmark' => [
        'token' => env('POSTMARK_TOKEN'),
    ],

    'ses' => [
        'key' => env('AWS_ACCESS_KEY_ID'),
        'secret' => env('AWS_SECRET_ACCESS_KEY'),
        'region' => env('AWS_DEFAULT_REGION', 'us-east-1'),
    ],
    'twilio' => [
    'sid' => env('TWILIO_SID'),
    'token' => env('TWILIO_AUTH_TOKEN'),
    'from' => env('TWILIO_PHONE'),
],

    'paypal' => [
        'mode'    => env('PAYPAL_MODE', 'sandbox'), // Can be 'sandbox' or 'live'. Default is 'sandbox'
        'sandbox' => [
            'client_id'         => env('PAYPAL_SANDBOX_API_CLIENT_ID', ''),
            'client_secret'     => env('PAYPAL_SANDBOX_API_SECRET', ''),
            'app_id'            => env('PAYPAL_SANDBOX_APP_ID', ''),
        ],
        'live' => [
            'client_id'         => env('PAYPAL_LIVE_API_CLIENT_ID', ''),
            'client_secret'     => env('PAYPAL_LIVE_API_SECRET', ''),
            'app_id'            => env('PAYPAL_LIVE_APP_ID', ''),
        ],

        'payment_action' => env('PAYPAL_PAYMENT_ACTION', 'Sale'), // Can be 'Sale', 'Authorization' or 'Order'. Default is 'Sale'
        'currency'       => env('PAYPAL_CURRENCY', 'EUR'),
        'notify_url'     => env('PAYPAL_NOTIFY_URL', ''), // Change this accordingly for your application.
        'locale'         => env('PAYPAL_LOCALE', 'en_US'), // PayPal pages to match the language on your website.
        'validate_ssl'   => env('PAYPAL_VALIDATE_SSL', true), // Validate SSL when creating api client.
    ],

];
