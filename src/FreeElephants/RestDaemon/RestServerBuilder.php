<?php

namespace FreeElephants\RestDaemon;

use FreeElephants\RestDaemon\Endpoint\EndpointFactoryInterface;
use FreeElephants\RestDaemon\Endpoint\EndpointInterface;
use FreeElephants\RestDaemon\Endpoint\Handler\HandlerFactoryInterface;
use FreeElephants\RestDaemon\Module\ModuleFactoryInterface;

/**
 * @author samizdam <samizdam@inbox.ru>
 */
class RestServerBuilder
{

    /**
     * @var ModuleFactoryInterface
     */
    private $moduleFactory;
    /**
     * @var RestServer
     */
    private $restServer;
    /**
     * @var EndpointFactoryInterface
     */
    private $endpointFactory;
    /**
     * @var HandlerFactoryInterface
     */
    private $handlerFactory;

    public function setServer(RestServer $restServer)
    {
        $this->restServer = $restServer;
    }

    public function setEndpointFactory(EndpointFactoryInterface $endpointFactory)
    {
        $this->endpointFactory = $endpointFactory;
    }

    public function setHandlerFactory(HandlerFactoryInterface $handlerFactory)
    {
        $this->handlerFactory = $handlerFactory;
    }

    public function setModuleFactory(ModuleFactoryInterface $moduleFactory)
    {
        $this->moduleFactory = $moduleFactory;
    }

    public function buildServer(array $routerConfig): RestServer
    {
        foreach ($routerConfig['modules'] as $basePath => $moduleConfig) {
            $module = $this->moduleFactory->buildModule($basePath, $moduleConfig);
            foreach ($moduleConfig['endpoints'] as $endpointBasePath => $endpointConfig) {
                /**@var $endpoint EndpointInterface */
                $endpoint = $this->endpointFactory->buildEndpoint($endpointBasePath, $endpointConfig);
                foreach ($endpointConfig['handlers'] as $method => $handlerClassName) {
                    if (is_object($handlerClassName)) {
                        $handler = $handlerClassName;
                    } else {
                        $handler = $this->handlerFactory->buildHandler($handlerClassName);
                    }
                    $endpoint->setMethodHandler($method, $handler);
                }
                $module->addEndpoint($endpoint);
            }
            $this->restServer->addModule($module);
        }
        foreach ($routerConfig['endpoints'] as $basePath => $endpointConfig) {
            $endpoint = $this->endpointFactory->buildEndpoint($basePath, $endpointConfig);
            foreach ($endpointConfig['handlers'] as $method => $handlerClassName) {
                if (is_object($handlerClassName)) {
                    $handler = $handlerClassName;
                } else {
                    $handler = $this->handlerFactory->buildHandler($handlerClassName);
                }
                $endpoint->setMethodHandler($method, $handler);
            }
            $this->restServer->addEndpoint($endpoint);
        }
        return $this->restServer;
    }
}