<?php

namespace FreeElephants\RestDaemon\Middleware;

/**
 * @author samizdam <samizdam@inbox.ru>
 */
interface EndpointMiddlewareCollectionInterface
{
    public function getBefore(): MiddlewareCollectionInterface;

    public function getAfter(): MiddlewareCollectionInterface;

    public function wrapInto(callable $endpointMethodHandler): array;

}