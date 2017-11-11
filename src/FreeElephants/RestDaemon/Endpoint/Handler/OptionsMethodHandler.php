<?php

namespace FreeElephants\RestDaemon\Endpoint\Handler;

use Psr\Http\Message\ResponseInterface;
use Psr\Http\Message\ServerRequestInterface;

class OptionsMethodHandler extends AbstractEndpointMethodHandler
{

    /**
     * @var array
     */
    private $options;

    public function __construct(array $options)
    {
        $this->options = $options;
    }

    public function __invoke(
        ServerRequestInterface $request,
        ResponseInterface $response,
        callable $next
    ): ResponseInterface {
        $response = $response->withAddedHeader('Allow', join(', ', $this->options));
        return $next($request, $response);
    }
}