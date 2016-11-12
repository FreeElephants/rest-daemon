<?php

namespace FreeElephants\RestDaemon\Middleware;

use Psr\Http\Message\RequestInterface;
use Psr\Http\Message\ResponseInterface;

/**
 * @author samizdam <samizdam@inbox.ru>
 */
class ContentTypeSetter
{
    /**
     * @var string
     */
    private $contentType;

    public function __construct(string $contentType)
    {
        $this->contentType = $contentType;
    }

    public function __invoke(RequestInterface $request, ResponseInterface $response, callable $next): ResponseInterface
    {
        return $next($request, $response->withHeader('Content-Type', $this->getContentType()));
    }

    public function getContentType(): string
    {
        return $this->contentType;
    }

}