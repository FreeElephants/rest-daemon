<?php

namespace FreeElephants\RestDaemon;

use Psr\Http\Message\RequestInterface;
use Psr\Http\Message\ResponseInterface;
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
    private $middlewareStack = [];

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
        $response = new Response();
        $middlewareStack = $this->middlewareStack;
        if(count($this->middlewareStack)) {
            while ($middleware = array_pop($middlewareStack)) {
                $next = count($middlewareStack) ? $middlewareStack[0] : function() use ($response) {
                    return $response;
                };
                $response = $middleware($request, $response, $next);
            }
        }

        return call_user_func($this->func, $request, $response);
    }

    public function setMiddlewareStack(array $middlewareStack)
    {
        $this->middlewareStack = $middlewareStack;
    }
}