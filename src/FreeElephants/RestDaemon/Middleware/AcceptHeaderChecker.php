<?php

namespace FreeElephants\RestDaemon\Middleware;

use Psr\Http\Message\RequestInterface as Request;
use Psr\Http\Message\ResponseInterface as Response;
use Zend\Http\Header\Accept;

/**
 * @author samizdam <samizdam@inbox.ru>
 */
class AcceptHeaderChecker
{
    /**
     * @var string
     */
    private $acceptedType;

    public function __construct(string $acceptedType)
    {
        $this->acceptedType = $acceptedType;
    }

    public function __invoke(Request $request, Response $response, callable $next)
    {
        if ($this->isAccepted($request)) {
            return $next($request, $response);
        }

        return $response->withStatus(406);
    }

    private function isAccepted(Request $request): bool
    {
        $requestAcceptStrings = $request->hasHeader('Accept') ? $request->getHeader('Accept') : ['*/*'];
        $allowedAcceptHeader = Accept::fromString($this->acceptedType);
        $accept = false;
        foreach ($requestAcceptStrings as $value) {
            if ($allowedAcceptHeader->match($value)) {
                $accept = true;
                break;
            }
        }
        return $accept;
    }
}