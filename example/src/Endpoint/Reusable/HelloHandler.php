<?php

namespace RestDeamon\Example\Endpoint\Reusable;

use FreeElephants\RestDaemon\Endpoint\AbstractEndpointMethodHandler;
use Psr\Http\Message\ResponseInterface;
use Psr\Http\Message\ServerRequestInterface;

/**
 * @author samizdam <samizdam@inbox.ru>
 */
class HelloHandler extends AbstractEndpointMethodHandler
{

    public function __invoke(
        ServerRequestInterface $request,
        ResponseInterface $response,
        callable $next
    ): ResponseInterface
    {
        $response->getBody()->write('{
        "message": "Hello from ' . $this->getEndpoint()->getName() . '"
    }');
        return $next($request, $response);
    }
}