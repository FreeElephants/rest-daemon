<?php

namespace FreeElephants\RestDaemon;

use Psr\Http\Message\RequestInterface;
use Psr\Http\Message\ResponseInterface;
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

    private $middleware;
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

    public function handle(RequestInterface $request): ResponseInterface
    {
        return $this->relay->__invoke($request, new Response());
    }

    public function setMiddleware($before, $after = [])
    {
        $middleware = array_merge($before, [$this->func], $after);
        $relayBuilder = new RelayBuilder();
        $this->relay = $relayBuilder->newInstance($middleware);
    }
}