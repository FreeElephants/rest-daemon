<?php

namespace FreeElephants\RestDaemon\Endpoint;

use FreeElephants\RestDaemon\Endpoint\Handler\OptionsMethodHandler;
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

    private $addOptionsHandler = true;

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

        if ($this->addOptionsHandler) {
            $options = array_keys($endpointConfig['handlers']);
            if (empty($options['OPTIONS'])) {
                $options[] = 'OPTIONS';
                sort($options);
                $endpoint->setMethodHandler('OPTIONS', new OptionsMethodHandler($options));
            }
        }

        return $endpoint;
    }

    public function setAddOptionsHandler(bool $addOptionsHandler)
    {
        $this->addOptionsHandler = $addOptionsHandler;
    }
}