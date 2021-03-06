<?php

namespace FreeElephants\RestDaemon\Endpoint;

use FreeElephants\AbstractTestCase;
use FreeElephants\RestDaemon\Endpoint\Handler\EndpointMethodHandlerInterface;

/**
 * @author samizdam <samizdam@inbox.ru>
 */
class BaseEndpointTest extends AbstractTestCase
{

    public function testGetMethodHandlers()
    {
        $endpoint = new BaseEndpoint('foo');
        $expected = $this->createMock(EndpointMethodHandlerInterface::class);
        $endpoint->setMethodHandler('GET', $expected);
        $actual = $endpoint->getMethodHandlers();
        self::assertArrayHasKey('GET', $actual);
        self::assertContains($expected, $actual);
    }

    public function testHasMethodHandler()
    {
        $endpoint = new BaseEndpoint('foo');
        $endpoint->setMethodHandlers(
            [
                'GET' => $this->createMock(EndpointMethodHandlerInterface::class),
            ]
        );
        self::assertTrue($endpoint->hasMethod('GET'));
    }

    public function testGetPath()
    {
        $endpoint = new BaseEndpoint('foo');
        self::assertSame('foo', $endpoint->getPath());
    }

    public function testGetDefaultName()
    {
        $endpoint = new BaseEndpoint('foo');
        self::assertSame('foo Endpoint', $endpoint->getName());
    }

    public function testGetName()
    {
        $endpoint = new BaseEndpoint('foo', 'Some name');
        self::assertSame('Some name', $endpoint->getName());
    }


}