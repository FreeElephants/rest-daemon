<?php

namespace FreeElephants\RestDaemon;

use FreeElephants\RestDaemon\Middleware\EndpointMiddlewareCollectionInterface;
use Psr\Http\Message\RequestInterface;
use Psr\Http\Message\ResponseInterface;

/**
 * @author samizdam <samizdam@inbox.ru>
 */
interface EndpointMethodHandlerInterface
{

    public function handle(RequestInterface $request): ResponseInterface;

    public function setMiddlewareCollection(EndpointMiddlewareCollectionInterface $endpointMiddlewareCollection);
}