<?php

namespace RestDeamon\Example\Endpoint\Index;

use FreeElephants\RestDaemon\Endpoint\EndpointMethodHandlerInterface;
use FreeElephants\RestDaemon\Middleware\EndpointMiddlewareCollectionInterface;
use Psr\Http\Message\RequestInterface;
use Psr\Http\Message\ResponseInterface;

/**
 * @author samizdam <samizdam@inbox.ru>
 */
class GetHandler implements EndpointMethodHandlerInterface
{

    public function handle(RequestInterface $request): ResponseInterface
    {
        // TODO: Implement handle() method.
    }

    public function setMiddlewareCollection(EndpointMiddlewareCollectionInterface $endpointMiddlewareCollection)
    {
        // TODO: Implement setMiddlewareCollection() method.
    }
}