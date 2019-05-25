<?php

use FreeElephants\RestDaemon\Endpoint\Handler\CallableEndpointMethodHandlerWrapper;
use RestDaemon\Example\Endpoint\Greeting\GetAttributeHandler;
use RestDaemon\Example\Endpoint\Greeting\GetHandler as GreetingGetHandler;
use RestDaemon\Example\Endpoint\Greeting\PostHandler;
use RestDaemon\Example\Endpoint\Index\GetHandler;
use RestDaemon\Example\Endpoint\Reusable\HelloHandler;
use RestDaemon\Example\Middleware\EchoFooMiddleware;

return [
    // Endpoints in base (default or root) module:
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
                // You can set handler by method
                'GET' => GreetingGetHandler::class,
                'POST' => PostHandler::class,
            ],
            'allowHeaders' => [
                'X-Greeting',
                'X-Some-Not-Simple',
            ],
        ],
        // Symfony routes patterns are supported
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
            'allowHeaders' => '*',
        ],
        '/exception' => [
            'name' => '',
            'handlers' => [
                // You can use inline functions and instantiating for simple logic instead full-weight DI and implementation
                'GET' => new CallableEndpointMethodHandlerWrapper(function () {
                    throw new \LogicException("Logic exception");
                })
            ],
        ],
    ],
    'modules' => [
        // You can share same handler class between modules: every handler instance get different module context
        '/api/v1' => [
            'name' => 'Api ver.1',
            'endpoints' => [
                '/hello' => [
                    'name' => 'Hello World',
                    'handlers' => [
                        'GET' => HelloHandler::class
                    ],
                    'middleware' => [
                        EchoFooMiddleware::class,
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