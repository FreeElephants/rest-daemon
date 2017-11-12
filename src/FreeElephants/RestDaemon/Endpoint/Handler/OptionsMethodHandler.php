<?php

namespace FreeElephants\RestDaemon\Endpoint\Handler;

use Psr\Http\Message\ResponseInterface;
use Psr\Http\Message\ServerRequestInterface;

class OptionsMethodHandler extends AbstractEndpointMethodHandler
{

    /**
     * @var array
     */
    private $allowMethods;
    /**
     * @var bool
     */
    private $reflectRequestAllowHeaders;

    public function __construct(array $allowMethods, bool $reflectRequestAllowHeaders = false)
    {
        $this->allowMethods = $allowMethods;
        $this->reflectRequestAllowHeaders = $reflectRequestAllowHeaders;
    }

    public function __invoke(
        ServerRequestInterface $request,
        ResponseInterface $response,
        callable $next
    ): ResponseInterface {
        $allowMethodsHeaderValue = join(', ', $this->allowMethods);
        $response = $response->withAddedHeader('Allow', $allowMethodsHeaderValue);

        if ($request->hasHeader('Access-Control-Request-Method')) {
            $response = $response->withAddedHeader('Access-Control-Allow-Methods', $allowMethodsHeaderValue);
        }

        if ($request->hasHeader('Access-Control-Request-Headers')) {
            if ($this->reflectRequestAllowHeaders) {
                $response = $response->withAddedHeader('Access-Control-Allow-Headers',
                    $request->getHeader('Access-Control-Request-Headers'));
            } else {
                $response = $response->withAddedHeader('Access-Control-Allow-Headers',
                    join(', ', $this->getEndpoint()->getAllowHeaders()));
            }
        }

        return $next($request, $response);
    }
}