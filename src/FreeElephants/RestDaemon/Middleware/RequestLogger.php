<?php

namespace FreeElephants\RestDaemon\Middleware;

use Psr\Http\Message\ResponseInterface;
use Psr\Http\Message\ServerRequestInterface;
use Psr\Log\LoggerAwareInterface;
use Psr\Log\LoggerAwareTrait;
use Psr\Log\LoggerInterface;
use Psr\Log\NullLogger;

class RequestLogger implements MiddlewareInterface, LoggerAwareInterface
{

    use LoggerAwareTrait;

    public function __construct(LoggerInterface $logger = null)
    {
        $this->setLogger($logger ?: new NullLogger());
    }

    public function __invoke(
        ServerRequestInterface $request,
        ResponseInterface $response,
        callable $next
    ): ResponseInterface {
        $this->logger->debug('Handle request', [
            'method' => $request->getMethod(),
            'protocol' => $request->getProtocolVersion(),
            'uri' => $request->getUri()->__toString(),
            'headers' => $request->getHeaders(),
            'cookies' => $request->getCookieParams(),
            'query' => $request->getQueryParams(),
            'attributes' => $request->getAttributes(),
            'server' => $request->getServerParams(),
        ]);

        return $next($request, $response);
    }
}