<?php

namespace FreeElephants\RestDaemon;

use FreeElephants\AbstractTestCase;
use FreeElephants\RestDaemon\HttpDriver\HttpServerConfig;
use FreeElephants\RestDaemon\Middleware\Collection\DefaultEndpointMiddlewareCollection;
use Psr\Container\ContainerInterface;

class RestServerBuilderTest extends AbstractTestCase
{

    public function testBuildServer_with_empty_config()
    {
        $builder = new RestServerBuilder($this->createMock(ContainerInterface::class));

        $server = $builder->buildServer([]);

        $this->assertCount(1, $server->getModules());
    }

    public function testBuildServer_from_modules()
    {
        $builder = new RestServerBuilder($this->createMock(ContainerInterface::class));

        $server = $builder->buildServer([
            'modules' => [
                '/api/module1' => [],
                '/api/module2' => [],
            ],
        ]);

        $this->assertCount(3, $server->getModules(),
            'Application should contains 1 base (default) and 2 added modules. ');
    }

    public function testBuildWithFullConfig()
    {
        $builder = new RestServerBuilder($this->createMock(ContainerInterface::class));

        $server = $builder->buildServer(require_once __DIR__ . '/routes.php');
        $this->assertCount(3, $server->getModules());
        $this->assertEquals(new HttpServerConfig(), $server->getConfig());
        $this->assertInstanceOf(RestServer::DEFAULT_HTTP_DRIVER, $server->getHttpDriver());
        $this->assertEquals(new DefaultEndpointMiddlewareCollection($server), $server->getMiddlewareCollection());
    }
}