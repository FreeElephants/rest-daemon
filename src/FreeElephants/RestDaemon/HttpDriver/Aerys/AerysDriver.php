<?php

namespace FreeElephants\RestDaemon\HttpDriver\Aerys;

use Aerys\Host;
use Aerys\Router;
use FreeElephants\RestDaemon\Endpoint\EndpointInterface;
use FreeElephants\RestDaemon\HttpDriver\HttpDriverInterface;
use FreeElephants\RestDaemon\HttpDriver\HttpServerConfig;
use FreeElephants\RestDaemon\Middleware\Collection\EndpointMiddlewareCollectionInterface;
use function Aerys\initServer;

/**
 * @author samizdam <samizdam@inbox.ru>
 */
class AerysDriver implements HttpDriverInterface
{
    /**
     * @var Host
     */
    private $aerysHost;

    public function configure(
        HttpServerConfig $config,
        array $endpoints,
        EndpointMiddlewareCollectionInterface $middlewareCollection
    ) {
        $aerysHost = new Host();
        $aerysHost->expose($config->getHttpHost(), $config->getPort());

        $router = $this->buildRouter($endpoints, $middlewareCollection);
        $aerysHost->use($router);
        $this->aerysHost = $aerysHost;
        return $aerysHost;
    }

    public function run()
    {
        \Amp\Loop::run(function () {
            $arrayOfAerysHostInstances = [$this->aerysHost]; // see Aerys\Host documentation
            $arrayOfAerysOptions = []; // see Aerys\Options documentation
            $logger = new StdoutLogger();
            $server = initServer($logger, $arrayOfAerysHostInstances, $arrayOfAerysOptions);
            $server->start();
        });
    }

    /**
     * @param array|EndpointInterface[] $endpoints
     * @param EndpointMiddlewareCollectionInterface $middlewareCollection
     * @return Router
     */
    private function buildRouter(array $endpoints, EndpointMiddlewareCollectionInterface $middlewareCollection): Router
    {
        $router = new Router();
        foreach ($endpoints as $endpoint) {
            foreach ($endpoint->getMethodHandlers() as $method => $handler) {
                $handler->setMiddlewareCollection($middlewareCollection);
                $handlerWrapper = new HandlerWrapper($handler);
                $router->route($method, $endpoint->getPath(), $handlerWrapper);
            }
        }

        return $router;
    }

    /**
     * @internal be careful: it's strong dependency without cross-vendor adapting: pre-configured Ratchet or Aerys instance
     * @return Host
     */
    public function getRawInstance()
    {
        return $this->aerysHost;
    }

    public function getVendorName(): string
    {
        return \Aerys\SERVER_TOKEN;
    }
}