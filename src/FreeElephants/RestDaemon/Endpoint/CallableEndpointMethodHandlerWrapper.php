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
class CallableEndpointMethodHandlerWrapper implements EndpointMethodHandlerInterface
{
    /**
     * @var callable
     */
    private $func;

    /**
     * @var Relay
     */
    private $relay;

    /**
     * CallableEndpointMethodHandlerWrapper constructor.
     * function(RequestInterface $request, ResponseInterface $response): ResponseInterface {
     *      // your logic
     * }
     * @param callable $func
     */
    public function __construct(callable $func)
    {
        $this->func = $func;
    }

    public function handle(ServerRequestInterface $request): ResponseInterface
    {
        return $this->relay->__invoke($request, new Response());
    }

    public function setMiddlewareCollection(EndpointMiddlewareCollectionInterface $endpointMiddlewareCollection)
    {
        $relayBuilder = new RelayBuilder();
        $this->relay = $relayBuilder->newInstance($endpointMiddlewareCollection->wrapInto($this->func));
    }
}