<?php

namespace RestDaemon\Example\Endpoint\Reusable;

use FreeElephants\RestDaemon\Endpoint\Handler\AbstractEndpointMethodHandler;
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
        "message": "Hello from ' . $this->getEndpoint()->getName() . '",
        "baseServerUri": "' . $this->getBaseServerUri($request) . '",
        "baseEndpointPath": "' . $this->getEndpoint()->getPath() . '"
    }');
        return $next($request, $response);
    }
}