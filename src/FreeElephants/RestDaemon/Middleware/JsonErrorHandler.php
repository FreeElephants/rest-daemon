<?php

namespace FreeElephants\RestDaemon\Middleware;

use Psr\Http\Message\RequestInterface as Request;
use Psr\Http\Message\ResponseInterface as Response;

/**
 * @author samizdam <samizdam@inbox.ru>
 */
class JsonErrorHandler
{

    public function __invoke(Request $request, Response $response, callable $next)
    {
        try {
            $response = $next($request, $response);
        } catch (\Throwable $e) {
            $response = $response->withStatus(500);
            $data = [
                'message' => $e->getMessage(),
                'code' => $e->getCode(),
                'file' => $e->getFile(),
                'line' => $e->getLine(),
            ];
            $response->getBody()->write(json_encode($data, JSON_PRETTY_PRINT));
        }
        return $response;
    }
}