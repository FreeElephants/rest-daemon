<?php

namespace FreeElephants\RestDaemon\Middleware;

use Zend\Diactoros\Response;
use Zend\Diactoros\ServerRequest;

/**
 * @author samizdam <samizdam@inbox.ru>
 */
class SuitableBodyParserTest extends \PHPUnit_Framework_TestCase
{

    public function testUnsupportedMediaType()
    {
        $middleware = new SuitableBodyParser();
        $request = new ServerRequest([], [], '', 'POST');
        $response = new Response();
        $response = $middleware->__invoke($request, $response, function(){});
        self::assertSame(415, $response->getStatusCode());
    }
}