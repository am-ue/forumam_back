<?php

return [
    'group' => [
        'as'         => 'api.',
        'domain'     => env('API_SUBDOMAIN', 'api') . '.' . env('APP_DOMAIN', 'localhost'),
        'middleware' => 'api',
    ],

    'resources' => [
        'categories' => [
            'model'          => \App\Models\Category::class,
            'router_options' => [
                'only' => ['index'],
            ],
        ],
        'companies'  => [
            'model'          => \App\Models\Company::class,
            'router_options' => [
                'only' => ['index'],
            ],
        ],
        'posts'      => [
            'model'          => \App\Models\Post::class,
            'router_options' => [
                'only' => ['index'],
            ],
        ],
        'config-variables'      => [
            'model'          => \App\Models\ConfigVariable::class,
            'router_options' => [
                'only' => ['index'],
            ],
        ],
    ],
];
