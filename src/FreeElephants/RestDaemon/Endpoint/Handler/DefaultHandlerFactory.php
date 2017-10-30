<?php


namespace FreeElephants\RestDaemon\Endpoint\Handler;


use FreeElephants\RestDaemon\Endpoint\EndpointMethodHandlerInterface;

class DefaultHandlerFactory implements HandlerFactoryInterface
{

    public function buildHandler(string $className): EndpointMethodHandlerInterface
    {
        return new $className;
    }
}