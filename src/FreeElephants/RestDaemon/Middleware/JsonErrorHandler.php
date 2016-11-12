<?php

namespace FreeElephants\RestDaemon\Middleware;

use Psr\Http\Message\RequestInterface as Request;
use Psr\Http\Message\ResponseInterface as Response;
use Relay\MiddlewareInterface;

/**
 * @author samizdam <samizdam@inbox.ru>
 */
class JsonErrorHandler implements MiddlewareInterface
{
    
    public function __invoke(Request $request, Response $response, callable $next = null)
    {
        try {
            $response = $next($request, $response);
        } catch (\Throwable $e) {
            $response = $response->withStatus(500);
            $data = [
                'message' => $e->getMessage(),
                'code' => $e->getCode(),
            ];
            $response->getBody()->write(json_encode($data));
        }
        return $response;
    }
}