<?php

namespace FreeElephants\RestDaemon\Endpoint\Handler;

use Psr\Http\Message\ResponseInterface;
use Psr\Http\Message\ServerRequestInterface;

/**
 * @author samizdam <samizdam@inbox.ru>
 */
class CallableEndpointMethodHandlerWrapper extends AbstractEndpointMethodHandler
{
    /**
     * @var callable
     */
    private $func;

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

    public function __invoke(
        ServerRequestInterface $request,
        ResponseInterface $response,
        callable $next
    ): ResponseInterface
    {
        return call_user_func($this->func, $request, $response, $next);
    }
}