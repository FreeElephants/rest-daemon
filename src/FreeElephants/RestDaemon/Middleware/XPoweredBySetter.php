<?php

namespace FreeElephants\RestDaemon\Middleware;

use Psr\Http\Message\ResponseInterface;
use Psr\Http\Message\ServerRequestInterface;

class XPoweredBySetter implements MiddlewareInterface
{

    /**
     * @var string
     */
    private $xPoweredBy;

    public function __construct(string $xPoweredBy = '')
    {
        $this->xPoweredBy = $xPoweredBy;
    }

    public function __invoke(
        ServerRequestInterface $request,
        ResponseInterface $response,
        callable $next
    ): ResponseInterface {
        return $next($request, $response->withAddedHeader('X-Powered-By', $this->xPoweredBy));
    }
}