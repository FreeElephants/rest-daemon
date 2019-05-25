<?php


namespace FreeElephants\RestDaemon\Endpoint\Handler;

use FreeElephants\RestDaemon\Middleware\Collection\EndpointMiddlewareCollectionInterface;
use FreeElephants\RestDaemon\Middleware\Collection\MiddlewareCollectionInterface;
use FreeElephants\RestDaemon\RestServer;

class EmptyEndpointMiddlewareCollection implements EndpointMiddlewareCollectionInterface
{

    /**
     * EmptyEndpointMiddlewareCollection constructor.
     */
    public function __construct()
    {
    }

    public function getBefore(): MiddlewareCollectionInterface
    {
        // TODO: Implement getBefore() method.
    }

    public function getAfter(): MiddlewareCollectionInterface
    {
        // TODO: Implement getAfter() method.
    }

    public function wrapInto(callable $endpointMethodHandler): array
    {
        // TODO: Implement wrapInto() method.
    }

    public function setServer(RestServer $restServer)
    {
        // TODO: Implement setServer() method.
    }
}