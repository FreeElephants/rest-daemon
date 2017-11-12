<?php

namespace FreeElephants\RestDaemon\Middleware\Collection;

use FreeElephants\RestDaemon\RestServer;

/**
 * @author samizdam <samizdam@inbox.ru>
 */
interface EndpointMiddlewareCollectionInterface
{
    public function getBefore(): MiddlewareCollectionInterface;

    public function getAfter(): MiddlewareCollectionInterface;

    public function wrapInto(callable $endpointMethodHandler): array;

    public function setServer(RestServer $restServer);

}