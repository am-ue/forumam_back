<?php

return [
    'group' => [
        'as'         => 'api.',
        'domain'     => config('app.api_subdomain').'.'.config('app.domain'),
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
