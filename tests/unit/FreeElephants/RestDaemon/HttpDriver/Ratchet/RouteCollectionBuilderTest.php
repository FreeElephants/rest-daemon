<?php

namespace FreeElephants\RestDaemon\HttpDriver\Ratchet;

use FreeElephants\AbstractTestCase;
use FreeElephants\RestDaemon\Endpoint\BaseEndpoint;
use FreeElephants\RestDaemon\Endpoint\Handler\EndpointMethodHandlerInterface;
use FreeElephants\RestDaemon\Middleware\Collection\EndpointMiddlewareCollectionInterface;

class RouteCollectionBuilderTest extends AbstractTestCase
{

    public function testBuildEndpointsRouteCollection()
    {
        $builder = new RouteCollectionBuilder();
        $endpoint = new BaseEndpoint('/', 'Root');
        $handler = $this->createMock(EndpointMethodHandlerInterface::class);
        /**@var EndpointMethodHandlerInterface $handler */
        $endpoint->setMethodHandler('GET', $handler);
        /**@var EndpointMiddlewareCollectionInterface $middlewareCollection */
        $middlewareCollection = $this->createMock(EndpointMiddlewareCollectionInterface::class);
        $collection = $builder->buildEndpointsRouteCollection([$endpoint], $middlewareCollection, 'localhost');
        $route = $collection->get('GET:Root');
        codecept_debug($collection);
        $this->assertSame('/', $route->getPath());
        $this->assertSame('localhost', $route->getHost());
        $this->assertSame(['GET'], $route->getMethods());
    }


}