<?php

namespace FreeElephants\RestDaemon\HttpDriver\Aerys;

use Aerys\Host;
use FreeElephants\AbstractTestCase;
use FreeElephants\RestDaemon\HttpDriver\HttpServerConfig;
use FreeElephants\RestDaemon\Middleware\Collection\EndpointMiddlewareCollectionInterface;

class AerysDriverTest extends AbstractTestCase
{

    public function testConfigure()
    {
        $driver = new AerysDriver();
        $host = $driver->configure(new HttpServerConfig(), [], $this->createMock(EndpointMiddlewareCollectionInterface::class));
        $this->assertInstanceOf(Host::class, $host);
    }
}