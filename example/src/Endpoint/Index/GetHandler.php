<?php

namespace RestDeamon\Example\Endpoint\Index;

use FreeElephants\RestDaemon\Endpoint\AbstractEndpointMethodHandler;
use Psr\Http\Message\ResponseInterface;
use Psr\Http\Message\ServerRequestInterface;

/**
 * @author samizdam <samizdam@inbox.ru>
 */
class GetHandler extends AbstractEndpointMethodHandler
{

    public function __invoke(ServerRequestInterface $request, ResponseInterface $response, callable $next): ResponseInterface
    {
        $response = $response->withStatus(200);
        return $next($request, $response);
    }
}