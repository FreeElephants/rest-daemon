<?php

namespace FreeElephants\RestDaemon;

use FreeElephants\RestDaemon\Middleware\EndpointMiddlewareCollectionInterface;

/**
 * @author samizdam <samizdam@inbox.ru>
 */
interface RestServerInterface
{
    public function addEndpoint(EndpointInterface $endpoint);

    public function run();

    public function setMiddlewareCollection(EndpointMiddlewareCollectionInterface $middlewareCollection);

    public function getMiddlewareCollection(): EndpointMiddlewareCollectionInterface;
}