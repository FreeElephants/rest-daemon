<?php

namespace FreeElephants\RestDaemon\Endpoint;

use FreeElephants\RestDaemon\Middleware\Collection\EndpointMiddlewareCollectionInterface;
use Psr\Http\Message\ResponseInterface;
use Psr\Http\Message\ServerRequestInterface;
use Psr\Http\Message\UriInterface;

/**
 * @author samizdam <samizdam@inbox.ru>
 */
interface EndpointMethodHandlerInterface
{

    public function handle(ServerRequestInterface $request): ResponseInterface;

    public function setMiddlewareCollection(EndpointMiddlewareCollectionInterface $endpointMiddlewareCollection);

    public function getBaseServerUri(ServerRequestInterface $request): UriInterface;

    public function getEndpoint(): EndpointInterface;

    public function setEndpoint(EndpointInterface $endpoint);
}