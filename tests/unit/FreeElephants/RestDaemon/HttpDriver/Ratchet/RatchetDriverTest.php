<?php

namespace FreeElephants\RestDaemon\HttpDriver\Ratchet;

use FreeElephants\AbstractTestCase;
use FreeElephants\RestDaemon\Endpoint\BaseEndpoint;
use FreeElephants\RestDaemon\HttpDriver\HttpServerConfig;
use FreeElephants\RestDaemon\Middleware\Collection\EndpointMiddlewareCollectionInterface;

class RatchetDriverTest extends AbstractTestCase
{

    public function testConfigure()
    {
        $this->markTestSkipped('See https://github.com/ratchetphp/Ratchet/issues/576. And another issue, that blocked this test is corrupted in React Tcp constructor 8843 port. ');
        $config = new HttpServerConfig('127.0.0.1', 9000);
        $driver = new RatchetDriver();
        $middlewareCollection = $this->createMock(EndpointMiddlewareCollectionInterface::class);
        $endpoint = new BaseEndpoint('/');
        $app = $driver->configure($config, [$endpoint], $middlewareCollection);
        $this->assertCount(1, $app->routes);
    }
}