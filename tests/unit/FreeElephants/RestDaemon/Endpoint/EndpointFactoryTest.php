<?php

namespace FreeElephants\RestDaemon\Endpoint;

use FreeElephants\AbstractTestCase;
use FreeElephants\RestDaemon\Endpoint\Exception\InvalidCongurationValueException;
use Psr\Container\ContainerInterface;
use Zend\Diactoros\Response;
use Zend\Diactoros\ServerRequest;

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

    public function testReflectingRequestAllowHeaderWithAutoCreatedOptionsHandler()
    {
        $di = $this->createMock(ContainerInterface::class);
        $factory = new EndpointFactory($di);

        $endpoint = $factory->buildEndpoint('/', [
            'handlers' => [],
            'allowHeaders' => '*',
        ]);

        $handlers = $endpoint->getMethodHandlers();
        $request = (new ServerRequest())->withHeader('Access-Control-Request-Headers', 'X-FOO, X-BAR');

        $response = $handlers['OPTIONS']->__invoke($request, new Response(), function ($request, $response) {
            return $response;
        });

        $this->assertContains('X-FOO, X-BAR', $response->getHeader('Access-Control-Allow-Headers'));
    }
}