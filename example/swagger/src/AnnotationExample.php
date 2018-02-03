<?php

namespace Example\Swagger;

use FreeElephants\RestDaemon\Endpoint\EndpointInterface;
use FreeElephants\RestDaemon\Endpoint\Handler\EndpointMethodHandlerInterface;
use FreeElephants\RestDaemon\Middleware\Collection\EndpointMiddlewareCollectionInterface;
use Psr\Http\Message\ResponseInterface;
use Psr\Http\Message\ServerRequestInterface;
use Psr\Http\Message\UriInterface;
use Swagger\Annotations as SWG;

/**
 * Class RootResourceHandler
 * @package Example\Swagger
 *
 * @SWG\Info(
 *     title="Example of Swagger Annotations for FreeElephants\RestDaemon Router Generator",
 *     version="1.0.0"
 * )
 */
class RootResourceHandler implements EndpointMethodHandlerInterface
{

    /**
     * Root Resource
     * @SWG\Get(
     *     path="/",
     *     @SWG\Response(
     *       response="200",
     *       description="Root Resource"
     *     )
     * )
     * @deprecated will be make protected or private.
     * @param ServerRequestInterface $request
     * @return ResponseInterface
     */
    public function handle(ServerRequestInterface $request): ResponseInterface
    {
        // TODO: Implement handle() method.
    }

    public function setMiddlewareCollection(EndpointMiddlewareCollectionInterface $endpointMiddlewareCollection)
    {
        // TODO: Implement setMiddlewareCollection() method.
    }

    public function getBaseServerUri(ServerRequestInterface $request): UriInterface
    {
        // TODO: Implement getBaseServerUri() method.
    }

    public function getEndpoint(): EndpointInterface
    {
        // TODO: Implement getEndpoint() method.
    }

    public function setEndpoint(EndpointInterface $endpoint)
    {
        // TODO: Implement setEndpoint() method.
    }

    public function __invoke(
        ServerRequestInterface $request,
        ResponseInterface $response,
        callable $next
    ): ResponseInterface {
        // TODO: Implement __invoke() method.
    }
}