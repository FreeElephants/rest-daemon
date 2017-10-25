<?php

namespace FreeElephants\RestDaemon\Endpoint;

use Psr\Container\ContainerInterface;

/**
 * @author samizdam <samizdam@inbox.ru>
 */
class EndpointFactory implements EndpointFactoryInterface
{

    /**
     * @var ContainerInterface
     */
    private $di;

    public function __construct(ContainerInterface $di)
    {
        $this->di = $di;
    }

    public function buildEndpoint(string $endpointPath, array $endpointConfig): EndpointInterface
    {
        $name = $endpointConfig['name'];
        $endpoint = new BaseCustomizableMiddlewareScopeEndpoint($endpointPath, $name);
        $middlewareClasses = isset($endpointConfig['middleware']) ? $endpointConfig['middleware'] : [];
        foreach ($middlewareClasses as $middlewareClassName) {
            $middleware = $this->di->get($middlewareClassName);
            $endpoint->addEndpointScopeBeforeMiddleware($middleware);
        }
        return $endpoint;
    }
}