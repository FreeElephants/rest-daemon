<?php

namespace FreeElephants\RestDaemon\Middleware;

use Psr\Http\Message\ResponseInterface;
use Psr\Http\Message\ServerRequestInterface;

/**
 * @author samizdam <samizdam@inbox.ru>
 */
class CORSHeaderSetter implements MiddlewareInterface
{

    /**
     * @var array
     */
    private $accessControlAllowOrigins;

    public function __construct(array $accessControlAllowOrigins = ['*'])
    {
        $this->accessControlAllowOrigins = $accessControlAllowOrigins;
    }

    public function __invoke(
        ServerRequestInterface $request,
        ResponseInterface $response,
        callable $next
    ): ResponseInterface
    {
        return $next($request,
            $response->withAddedHeader('Access-Control-Allow-Origin', $this->accessControlAllowOrigins));
    }
}