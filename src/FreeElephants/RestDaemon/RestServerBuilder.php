<?php

namespace FreeElephants\RestDaemon;

use FreeElephants\RestDaemon\Endpoint\EndpointFactory;
use FreeElephants\RestDaemon\Endpoint\EndpointFactoryInterface;
use FreeElephants\RestDaemon\Endpoint\EndpointInterface;
use FreeElephants\RestDaemon\Endpoint\Handler\DefaultHandlerFactory;
use FreeElephants\RestDaemon\Endpoint\Handler\HandlerFactoryInterface;
use FreeElephants\RestDaemon\Exception\MissingDependencyException;
use FreeElephants\RestDaemon\HttpDriver\HttpServerConfig;
use FreeElephants\RestDaemon\Module\ModuleFactory;
use FreeElephants\RestDaemon\Module\ModuleFactoryInterface;
use Psr\Container\ContainerInterface;
use Psr\Log\LoggerAwareInterface;
use Psr\Log\LoggerAwareTrait;
use Psr\Log\NullLogger;

/**
 * @author samizdam <samizdam@inbox.ru>
 */
class RestServerBuilder implements LoggerAwareInterface
{

    use LoggerAwareTrait;

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

    /**
     * @throws MissingDependencyException
     */
    public function __construct(
        ContainerInterface $container = null,
        EndpointFactoryInterface $endpointFactory = null,
        HandlerFactoryInterface $handlerFactory = null,
        ModuleFactoryInterface $moduleFactory = null,
        RestServer $restServer = null
    ) {
        $this->logger = new NullLogger();
        $this->assertDependenciesAdequacy($endpointFactory, $container);
        $this->setEndpointFactory($endpointFactory ?: new EndpointFactory($container));
        $this->setHandlerFactory($handlerFactory ?: new DefaultHandlerFactory());
        $this->setModuleFactory($moduleFactory ?: new ModuleFactory());
        $this->setServer($restServer ?: new RestServer());
    }

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

    public function buildServer(array $routerConfig, HttpServerConfig $httpServerConfig = null): RestServer
    {
        $this->logger->debug('Build server', $routerConfig);
        $this->restServer->setLogger($this->logger);
        $this->handlerFactory->setLogger($this->logger);
        $this->endpointFactory->setLogger($this->logger);

        if ($httpServerConfig) {
            $this->restServer->setConfig($httpServerConfig);
        }

        foreach ($this->getModulesConfig($routerConfig) as $basePath => $moduleConfig) {
            $module = $this->moduleFactory->buildModule($basePath, $moduleConfig);
            foreach ($this->getEndpointsConfig($moduleConfig) as $endpointBasePath => $endpointConfig) {
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

        foreach ($this->getEndpointsConfig($routerConfig) as $basePath => $endpointConfig) {
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

    private function getModulesConfig(array $routerConfig): array
    {
        if (isset($routerConfig['modules']) && is_array($routerConfig['modules'])) {
            return $routerConfig['modules'];
        } else {
            return [];
        }
    }

    private function getEndpointsConfig(array $routerConfig): array
    {
        if (isset($routerConfig['endpoints']) && is_array($routerConfig['endpoints'])) {
            return $routerConfig['endpoints'];
        } else {
            return [];
        }
    }

    private function assertDependenciesAdequacy(
        EndpointFactoryInterface $endpointFactory = null,
        ContainerInterface $container = null
    ) {
        if (!$endpointFactory && !$container) {
            throw new MissingDependencyException('For instantiate EndpointFactory PSR-11 container instance is required. ');
        }
    }

    public function getEndpointFactory(): EndpointFactoryInterface
    {
        return $this->endpointFactory;
    }
}