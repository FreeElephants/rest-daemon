<?php


namespace FreeElephants\RestDaemon\Endpoint\Handler;


class DefaultHandlerFactory implements HandlerFactoryInterface
{

    public function buildHandler(string $className): EndpointMethodHandlerInterface
    {
        return new $className;
    }
}