<?php

declare(strict_types=1);

return [
    'theme' => 'laravel',
    'title' => 'Governance SaaS Enterprise API',
    'description' => 'Comprehensive API for enterprise governance integration.',
    'base_url' => config('app.url'),
    'logo' => session('tenant')?->logo_path ? Storage::url(session('tenant')->logo_path) : false,
    'auth' => [
        'enabled' => true,
        'default' => true,
        'in' => 'bearer',
        'name' => 'Authorization',
        'use_value' => env('SCRIBE_AUTH_KEY'),
        'placeholder' => '{YOUR_AUTH_KEY}',
        'extra_info' => 'You can retrieve your API key from the developer settings in your dashboard.',
    ],
    'routes' => [
        [
            'match' => [
                'prefixes' => ['api/*'],
                'domains' => ['*'],
            ],
            'apply' => [
                'headers' => [
                    'Content-Type' => 'application/json',
                    'Accept' => 'application/json',
                ],
            ],
        ],
    ],
];
