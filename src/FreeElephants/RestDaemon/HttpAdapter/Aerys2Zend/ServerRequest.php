<?php

namespace FreeElephants\RestDaemon\HttpAdapter\Aerys2Zend;

use Aerys\Request;
use Psr\Http\Message\UriInterface;
use Zend\Diactoros\ServerRequest as ZendServerRequest;
use Zend\Diactoros\Uri;


/**
 * @author samizdam <samizdam@inbox.ru>
 */
class ServerRequest extends ZendServerRequest
{
    public function __construct(Request $request)
    {
        $serverParams = $_SERVER;
        $uploadedFiles = [];
        $uri = $this->mapUri($request);
        $method = $request->getMethod();
        $headers = $request->getAllHeaders();
        $cookies = [];
        $queryParams = $request->getAllParams();
        $parsedBody = [];
        $protocol = $request->getProtocolVersion();
        parent::__construct(
            $serverParams,
            $uploadedFiles,
            $uri,
            $method,
            'php://memory',
            $headers,
            $cookies,
            $queryParams,
            $parsedBody,
            $protocol);
    }

    private function mapUri(Request $request): UriInterface
    {
        $uri = new Uri($request->getUri());
        $connectionInfo = $request->getConnectionInfo();
        $scheme = $connectionInfo['is_encrypted'] ? 'https' : 'http';
        $host = $connectionInfo['server_addr'];
        $port = $connectionInfo['server_port'];
        return $uri->withScheme($scheme)->withHost($host)->withPort($port);
    }
}