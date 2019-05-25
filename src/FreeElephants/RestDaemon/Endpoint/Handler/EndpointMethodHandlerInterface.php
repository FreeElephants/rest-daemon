<?php

namespace FreeElephants\RestDaemon\Endpoint\Handler;

use FreeElephants\RestDaemon\Endpoint\EndpointInterface;
use FreeElephants\RestDaemon\Middleware\Collection\EndpointMiddlewareCollectionInterface;
use FreeElephants\RestDaemon\Middleware\MiddlewareInterface;
use Psr\Http\Message\ResponseInterface;
use Psr\Http\Message\ServerRequestInterface;
use Psr\Http\Message\UriInterface;

/**
 * @author samizdam <samizdam@inbox.ru>
 */
interface EndpointMethodHandlerInterface extends MiddlewareInterface
{

    /**
     * @deprecated will be make protected or private.
     * @param ServerRequestInterface $request
     * @return ResponseInterface
     */
    public function handle(ServerRequestInterface $request): ResponseInterface;

    public function setMiddlewareCollection(EndpointMiddlewareCollectionInterface $endpointMiddlewareCollection);

    public function getMiddlewareCollection(): EndpointMiddlewareCollectionInterface;

    public function getBaseServerUri(ServerRequestInterface $request): UriInterface;

    public function getEndpoint(): EndpointInterface;

    public function setEndpoint(EndpointInterface $endpoint);
}