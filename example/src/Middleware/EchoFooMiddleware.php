<?php

namespace RestDaemon\Example\Middleware;

use FreeElephants\RestDaemon\Middleware\MiddlewareInterface;
use Psr\Http\Message\ResponseInterface;
use Psr\Http\Message\ServerRequestInterface;

class EchoFooMiddleware implements MiddlewareInterface
{

    public function __invoke(
        ServerRequestInterface $request,
        ResponseInterface $response,
        callable $next
    ): ResponseInterface {
        echo 'foo';
        return $next($request, $response);
    }
}