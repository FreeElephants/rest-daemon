<?php

use FreeElephants\RestDaemon\Endpoint\CallableEndpointMethodHandlerWrapper;
use RestDeamon\Example\Endpoint\Greeting\GetAttributeHandler;
use RestDeamon\Example\Endpoint\Greeting\GetHandler as GreetingGetHandler;
use RestDeamon\Example\Endpoint\Greeting\PostHandler;
use RestDeamon\Example\Endpoint\Index\GetHandler;
use RestDeamon\Example\Endpoint\Reusable\HelloHandler;

return [
    'endpoints' => [
        '/' => [
            'name' => 'Index Endpoint',
            'handlers' => [
                'GET' => GetHandler::class,
            ],
        ],
        '/greeting' => [
            'name' => 'Greeting by name in params',
            'handlers' => [
                'GET' => GreetingGetHandler::class,
                'POST' => PostHandler::class,
            ],
        ],
        '/greeting/{name}' => [
            'name' => 'Greeting by name in path',
            'handlers' => [
                'GET' => GetAttributeHandler::class
            ]
        ],
        '/hello' => [
            'name' => 'Hello World',
            'handlers' => [
                'GET' => HelloHandler::class
            ],
        ],
        '/exception' => [
            'name' => '',
            'handlers' => [
                'GET' => new CallableEndpointMethodHandlerWrapper(function () {
                    throw new \LogicException("Logic exception");
                })
            ],
        ],
    ],
    'modules' => [
        '/api/v1' => [
            'name' => 'Api ver.1',
            'endpoints' => [
                '/hello' => [
                    'name' => 'Hello World',
                    'handlers' => [
                        'GET' => HelloHandler::class
                    ],
                ],
            ],
        ],
        '/api/v2' => [
            'name' => 'Api ver.2',
            'endpoints' => [
                '/hello' => [
                    'name' => 'Hello World',
                    'handlers' => [
                        'GET' => HelloHandler::class
                    ],
                ],
            ],
        ],
    ],
];