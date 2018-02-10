<?php

return [
    'endpoints' => [
        '/' => [
            'name' => 'Root Resource',
            'handlers' => [
                'GET' => \Example\Swagger\RootResourceHandler::class,
            ],
        ],
    ],
];
