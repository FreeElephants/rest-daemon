<?php

namespace FreeElephants\RestDaemon\Middleware;

use FreeElephants\RestDaemon\Util\AcceptMediaTypeMatcher;
use Psr\Http\Message\ResponseInterface;
use Psr\Http\Message\ServerRequestInterface;

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

    public function __invoke(ServerRequestInterface $request, ResponseInterface $response, callable $next)
    {
        if ($this->isAccepted($request)) {
            return $next($request, $response);
        }

        return $response->withStatus(406);
    }

    private function isAccepted(ServerRequestInterface $request): bool
    {
        $requestAcceptStrings = $request->hasHeader('Accept') ? $request->getHeader('Accept') : ['*/*'];
        $accept = false;
        foreach ($requestAcceptStrings as $value) {
            if (AcceptMediaTypeMatcher::match($this->acceptedType, $value)) {
                $accept = true;
                break;
            }
        }
        return $accept;
    }
}