<?php

namespace FreeElephants\RestDaemon\Middleware\Json;

use FreeElephants\RestDaemon\Middleware\MiddlewareInterface;
use Psr\Http\Message\ResponseInterface;
use Psr\Http\Message\ServerRequestInterface;

/**
 * @author samizdam <samizdam@inbox.ru>
 */
class ErrorHandler implements MiddlewareInterface
{

    public function __invoke(
        ServerRequestInterface $request,
        ResponseInterface $response,
        callable $next
    ): ResponseInterface
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