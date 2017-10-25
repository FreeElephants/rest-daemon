<?php

return [
    'register' => [
        RestDeamon\Example\Endpoint\Index\GetHandler::class,
        RestDeamon\Example\Endpoint\Greeting\GetHandler::class,
        RestDeamon\Example\Endpoint\Greeting\PostHandler::class,
        RestDeamon\Example\Endpoint\Greeting\GetAttributeHandler::class,
        RestDeamon\Example\Endpoint\Reusable\HelloHandler::class,
    ],
];
