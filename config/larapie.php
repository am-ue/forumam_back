<?php

return [
    'group' => [
        'as'         => 'api.',
        'domain'     =>  env('API_SUBDOMAIN','api').'.'.env('APP_DOMAIN', 'localhost'),
        'middleware' => 'api',
    ],

    'resources' => [
        'categories' => [
            'model' => \App\Models\Category::class,
            'router_options' => [
                'only' => ['index', 'show'],
            ],
        ],
        'companies' => [
            'model' => \App\Models\Company::class,
            'router_options' => [
                'only' => ['index', 'show'],
            ],
        ],
        'posts' => [
            'model' => \App\Models\Post::class,
            'router_options' => [
                'only' => ['index', 'show'],
            ],
        ],
    ],
];