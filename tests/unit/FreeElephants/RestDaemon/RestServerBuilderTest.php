<?php

namespace FreeElephants\RestDaemon;

use FreeElephants\AbstractTestCase;
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
                '/api/module1' => [
                    'name' => 'module1',
                ],
                '/api/module2' => [
                    'name' => 'module2',
                ],
            ],
        ]);

        $this->assertCount(3, $server->getModules(), 'Application shoud contains 1 base (default) and 2 added modules. ');
    }
}