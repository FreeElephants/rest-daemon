<?php

namespace FreeElephants\RestDaemon\Middleware\Json;

use FreeElephants\RestDaemon\Util\ParamsContainer;
use Psr\Http\Message\ResponseInterface;
use Psr\Http\Message\ServerRequestInterface;
use Zend\Diactoros\Response;
use Zend\Diactoros\ServerRequest;
use Zend\Diactoros\Stream;

/**
 * @author samizdam <samizdam@inbox.ru>
 */
class BodyParserTest extends \PHPUnit_Framework_TestCase
{

    public function testParseToDefaultParamsContainer()
    {
        $parser = new BodyParser();
        $body = new Stream('php://memory', 'rw');
        $body->write(<<<JSON
{
    "foo": "bar",
    "int_value": 100
}
JSON
        );
        $request = new ServerRequest([], [], null, null, $body);
        $response = $this->createMock(ResponseInterface::class);
        /**@var $requestWithParsedBody ServerRequestInterface */
        $requestWithParsedBody = null;
        $parser->__invoke($request, $response,
            function (ServerRequestInterface $request, $response) use (&$requestWithParsedBody) {
                $requestWithParsedBody = $request;
                return $response;
            });
        /**@var $actualBody ParamsContainer */
        $actualBody = $requestWithParsedBody->getParsedBody();
        self::assertSame('bar', $actualBody->get('foo'));
        self::assertSame(100, $actualBody->get('int_value'));
    }

    public function testParseInvalidJson()
    {
        $parser = new BodyParser();
        $body = new Stream('php://memory', 'rw');
        $body->write(<<<WRONG_JSON
{
    it's invalid Json!
}
WRONG_JSON
        );
        $request = new ServerRequest([], [], null, null, $body);
        /**@var $requestWithParsedBody ServerRequestInterface */
        $requestWithParsedBody = null;
        $response = $parser->__invoke($request, new Response(),
            function (ServerRequestInterface $request, $response) use (&$requestWithParsedBody) {
                $requestWithParsedBody = $request;
                return $response;
            });
        self::assertSame(400, $response->getStatusCode());
        /**@var $actualBody ParamsContainer */
        $actualBody = $requestWithParsedBody->getParsedBody();
        self::assertCount(0, $actualBody);
    }
}