<?php

namespace FreeElephants\RestDaemon\Integration\Swagger;

use FreeElephants\AbstractTestCase;

class RouterGeneratorTest extends AbstractTestCase
{

    public function testGetRoutes()
    {
        $generator = new RouterGenerator();
        $this->assertSame([
            'endpoints' => [
                '/' => [
                    'name' => 'Root Resource',
                    'handlers' => [
                        'GET' => 'Example\Swagger\RootResourceHandler::class',
                    ],
                ],
            ],
        ],
            $generator->getRouterConfig(__DIR__ . '/../../../../../../example/swagger/'));

    }
}