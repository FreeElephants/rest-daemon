<?php declare(strict_types=1);

namespace FreeElephants\RestDaemon\HttpDriver\Aerys;

use Aerys\Request;
use Aerys\Response;
use FreeElephants\AbstractTestCase;
use FreeElephants\RestDaemon\Endpoint\Handler\EndpointMethodHandlerInterface;

class HandlerWrapperTest extends AbstractTestCase
{
    /** @test */
    public function invoke_AerysRequestAndResponse_generatorReturned(): void
    {
        /** @var EndpointMethodHandlerInterface $handler */
        $handler = $this->createMock(EndpointMethodHandlerInterface::class);
        $handleWrapper = new HandlerWrapper($handler);
        /** @var Request $request */
        $request = $this->createMock(Request::class);
        /** @var Response $response */
        $response = $this->createMock(Response::class);
        $routeParams = ['foo' => 'bar'];

        $result = $handleWrapper($request, $response, $routeParams);

        $this->assertInstanceOf(\Generator::class, $result);
    }
}
