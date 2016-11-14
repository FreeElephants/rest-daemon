<?php

namespace FreeElephants\RestDaemon\HttpAdapter\Aerys2Zend;

use Aerys\Request;
use Zend\Diactoros\CallbackStream;
use Zend\Diactoros\ServerRequest as ZendServerRequest;
use Zend\Diactoros\Stream;
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
        $uri = new Uri($request->getUri());
        $method = $request->getMethod();
        $headers = $request->getAllHeaders();
        $cookies = [];
        $queryParams = $request->getAllParams();
        $parsedBody = [];
        $protocol = $request->getProtocolVersion();
        parent::__construct($serverParams, $uploadedFiles, $uri, $method, 'php://memory', $headers, $cookies, $queryParams,
            $parsedBody, $protocol);
    }
}