<?php

namespace FreeElephants\RestDaemon\HttpAdapter\Guzzle2Zend;

use Psr\Http\Message\RequestInterface;
use Zend\Diactoros\ServerRequest as ZendServerRequest;

/**
 * @author samizdam <samizdam@inbox.ru>
 */
class ServerRequest extends ZendServerRequest
{
    public function __construct(RequestInterface $request)
    {
        $serverParams = $_SERVER;
        $uploadedFiles = [];
        $uri = $request->getUri();
        $method = $request->getMethod();
        $body = $request->getBody();
        $parsedBody = [];
        $headers = [];
        foreach ($request->getHeaders() as $name => $values) {
            $headers[$name] = $values;
        }
        $cookies = [];
        parse_str($request->getUri()->getQuery(), $queryParams);
        $protocol = $request->getProtocolVersion();
        parent::__construct(
            $serverParams,
            $uploadedFiles,
            $uri,
            $method,
            $body,
            $headers,
            $cookies,
            $queryParams,
            $parsedBody,
            $protocol);
    }
}