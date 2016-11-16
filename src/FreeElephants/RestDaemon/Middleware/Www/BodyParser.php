<?php

namespace FreeElephants\RestDaemon\Middleware\Www;

use FreeElephants\RestDaemon\Middleware\AbstractBodyParser;
use Psr\Http\Message\ResponseInterface;
use Psr\Http\Message\ServerRequestInterface;

/**
 * @author samizdam <samizdam@inbox.ru>
 */
class BodyParser extends AbstractBodyParser
{

    public function __invoke(
        ServerRequestInterface $request,
        ResponseInterface $response,
        callable $next
    ): ResponseInterface
    {
        $request->getBody()->rewind();
        parse_str($request->getBody()->getContents(), $params);
        $containerizedData = $this->wrapParamsToContainer($params);
        $requestWithParsedBody = $request->withParsedBody($containerizedData);
        return $next($requestWithParsedBody, $response);
    }
}