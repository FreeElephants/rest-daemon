<?php

namespace FreeElephants\RestDaemon\Middleware\Json;

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
        $data = json_decode($request->getBody()->getContents(), JSON_OBJECT_AS_ARRAY);
        if (json_last_error() !== JSON_ERROR_NONE) {
            $data = [];
            $response = $response->withStatus(400, 'Invalid Json: ' . json_last_error_msg());
        }
        $containerizedData = $this->wrapParamsToContainer($data);
        $requestWithParsedBody = $request->withParsedBody($containerizedData);
        return $next($requestWithParsedBody, $response);
    }
}