<?php

return [
    'register' => [
        RestDaemon\Example\Endpoint\Index\GetHandler::class,
        RestDaemon\Example\Endpoint\Greeting\GetHandler::class,
        RestDaemon\Example\Endpoint\Greeting\PostHandler::class,
        RestDaemon\Example\Endpoint\Greeting\GetAttributeHandler::class,
        RestDaemon\Example\Endpoint\Reusable\HelloHandler::class,
    ],
];
