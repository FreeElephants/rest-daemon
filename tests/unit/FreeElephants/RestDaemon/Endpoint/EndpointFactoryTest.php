<?php

namespace FreeElephants\RestDaemon\Endpoint;

use FreeElephants\AbstractTestCase;
use FreeElephants\RestDaemon\Endpoint\Exception\InvalidCongurationValueException;
use Psr\Container\ContainerInterface;

class EndpointFactoryTest extends AbstractTestCase
{

    public function testInvalidAllowHeadersValue()
    {
        $di = $this->createMock(ContainerInterface::class);
        $factory = new EndpointFactory($di);

        $this->expectException(InvalidCongurationValueException::class);

        $factory->buildEndpoint('/', [
            'handles' => [],
            'allowHeaders' => 42
        ]);

    }
}