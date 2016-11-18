<?php

namespace FreeElephants\RestDaemon\HttpAdapter\Guzzle2Zend;

use Guzzle\Http\Message\EntityEnclosingRequest;
use Guzzle\Http\Message\Header;
use Zend\Diactoros\ServerRequest as ZendServerRequest;
use Zend\Diactoros\Uri;

/**
 * @author samizdam <samizdam@inbox.ru>
 */
class ServerRequest extends ZendServerRequest
{
    public function __construct(EntityEnclosingRequest $request)
    {
        $serverParams = $_SERVER;
        $uploadedFiles = [];
        $uri = new Uri($request->getUrl());
        $method = $request->getMethod();
        $body = $request->getBody()->getStream();
        $parsedBody = [];
        $headers = [];
        /**@var $header Header*/
        foreach ($request->getHeaders()->getAll() as $header) {
            $headers[$header->getName()] = $header->toArray();
        }
        $cookies = [];
        $queryParams = $request->getQuery()->getAll();
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