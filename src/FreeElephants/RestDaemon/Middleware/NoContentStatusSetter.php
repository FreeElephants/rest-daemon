<?php

namespace FreeElephants\RestDaemon\Middleware;

use Psr\Http\Message\ResponseInterface;
use Psr\Http\Message\ServerRequestInterface;

/**
 * @author samizdam <samizdam@inbox.ru>
 */
class NoContentStatusSetter implements MiddlewareInterface
{

    public function __invoke(
        ServerRequestInterface $request,
        ResponseInterface $response,
        callable $next
    ): ResponseInterface
    {
        if ($response->getStatusCode() === 200 && $request->getMethod() === 'HEAD') {
            $response = $response->withStatus(204);
        }
        return $next($request, $response);
    }
}