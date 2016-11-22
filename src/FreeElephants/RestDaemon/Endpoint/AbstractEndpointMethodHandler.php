<?php

namespace FreeElephants\RestDaemon\Endpoint;

use FreeElephants\RestDaemon\Middleware\Collection\EndpointMiddlewareCollectionInterface;
use Psr\Http\Message\ResponseInterface;
use Psr\Http\Message\ServerRequestInterface;
use Relay\Relay;
use Relay\RelayBuilder;
use Zend\Diactoros\Response;

/**
 * @author samizdam <samizdam@inbox.ru>
 */
abstract class AbstractEndpointMethodHandler implements EndpointMethodHandlerInterface
{

    /**
     * @var Relay
     */
    private $relay;

    public function handle(ServerRequestInterface $request): ResponseInterface
    {
        return $this->relay->__invoke($request, new Response());
    }

    abstract public function __invoke(
        ServerRequestInterface $request,
        ResponseInterface $response,
        callable $next
    ): ResponseInterface;

    public function setMiddlewareCollection(EndpointMiddlewareCollectionInterface $endpointMiddlewareCollection)
    {
        $relayBuilder = new RelayBuilder();
        $this->relay = $relayBuilder->newInstance($endpointMiddlewareCollection->wrapInto([$this, '__invoke']));
    }
}