<?php

namespace FreeElephants\RestDaemon;

use FreeElephants\RestDaemon\Endpoint\EndpointInterface;
use FreeElephants\RestDaemon\Exception\InvalidArgumentException;
use FreeElephants\RestDaemon\HttpDriver\Aerys\AerysDriver;
use FreeElephants\RestDaemon\HttpDriver\HttpDriverInterface;
use FreeElephants\RestDaemon\HttpDriver\HttpServerConfig;
use FreeElephants\RestDaemon\HttpDriver\Ratchet\RatchetDriver;
use FreeElephants\RestDaemon\HttpDriver\ReactHttp\ReactDriver;
use FreeElephants\RestDaemon\Middleware\Collection\DefaultEndpointMiddlewareCollection;
use FreeElephants\RestDaemon\Middleware\Collection\EndpointMiddlewareCollectionInterface;
use FreeElephants\RestDaemon\Module\ApiModuleInterface;
use FreeElephants\RestDaemon\Module\BaseApiModule;

/**
 * @author samizdam <samizdam@inbox.ru>
 */
class RestServer
{
    const DEFAULT_HTTP_DRIVER = self::REACT_HTTP_DRIVER;
    const REACT_HTTP_DRIVER = ReactDriver::class;
    const RATCHET_HTTP_DRIVER = RatchetDriver::class;
    const AERYS_HTTP_DRIVER = AerysDriver::class;

    /**
     * @var EndpointMiddlewareCollectionInterface
     */
    private $middlewareCollection;
    /**
     * @var HttpDriverInterface
     */
    private $httpDriver;
    /**
     * @var HttpServerConfig
     */
    private $config;
    /**
     * @var array|ApiModuleInterface[] $modules
     */
    private $modules = [];

    /**
     * @var ApiModuleInterface
     */
    private $baseModule;

    public function __construct(
        string $httpHost = HttpServerConfig::DEFAULT_HTTP_HOST,
        int $port = HttpServerConfig::DEFAULT_HTTP_PORT,
        string $address = HttpServerConfig::DEFAULT_ADDRESS,
        array $allowedOrigins = HttpServerConfig::DEFAULT_ALLOWED_ORIGINS,
        string $httpDriverClass = self::DEFAULT_HTTP_DRIVER,
        ApiModuleInterface $baseModule = null
    ) {
        $this->config = new HttpServerConfig($httpHost, $port, $address, $allowedOrigins);
        $this->httpDriver = $this->buildHttpDriver($httpDriverClass);
        $this->setBaseModule($baseModule ?: new BaseApiModule('/', 'Default Api Module'));
    }

    public function setBaseModule(ApiModuleInterface $baseModule)
    {
        $this->baseModule = $baseModule;
        $this->addModule($baseModule);
    }

    public function addEndpoint(EndpointInterface $endpoint)
    {
        $this->baseModule->addEndpoint($endpoint);
    }

    /**
     * Use $rawDriverBeforeRunHook function for low level vendor specific driver manipulation:
     *  - function(Ratchet\App|Aerys\Host $rawInstance, RestServer $restServer)
     * @param callable|null $rawDriverBeforeRunHook
     */
    public function run(callable $rawDriverBeforeRunHook = null)
    {
        $endpoints = [];
        foreach ($this->modules as $module) {
            $endpoints = array_merge($module->getEndpoints(), $endpoints);
        }
        $this->httpDriver->configure($this->config, $endpoints, $this->getMiddlewareCollection());
        if ($rawDriverBeforeRunHook) {
            $rawDriverBeforeRunHook($this->httpDriver->getRawInstance(), $this);
        }
        cli_set_process_title('rest-daemon');
        $this->httpDriver->run();
    }

    protected function buildHttpDriver(string $httpDriverClass): HttpDriverInterface
    {
        if (!class_exists($httpDriverClass)) {
            $exceptionMessage = sprintf('Driver class `%s` not found. ', $httpDriverClass);
            throw new InvalidArgumentException($exceptionMessage);
        }
        return new $httpDriverClass;
    }

    public function setMiddlewareCollection(EndpointMiddlewareCollectionInterface $middlewareCollection)
    {
        $middlewareCollection->setServer($this);
        $this->middlewareCollection = $middlewareCollection;
    }

    public function getMiddlewareCollection(): EndpointMiddlewareCollectionInterface
    {
        if (empty($this->middlewareCollection)) {
            $middlewareCollection = new DefaultEndpointMiddlewareCollection($this);
            $this->middlewareCollection = $middlewareCollection;
        }
        return $this->middlewareCollection;
    }

    public function addModule(ApiModuleInterface $module)
    {
        $this->modules[$module->getPath()] = $module;
    }

    /**
     * @return array|ApiModuleInterface[]
     */
    public function getModules(): array
    {
        return $this->modules;
    }

    public function getConfig(): HttpServerConfig
    {
        return $this->config;
    }

    public function setConfig(HttpServerConfig $config)
    {
        $this->config = $config;
    }

    /**
     * @return HttpDriverInterface|RatchetDriver|AerysDriver
     */
    public function getHttpDriver(): HttpDriverInterface
    {
        return $this->httpDriver;
    }

}