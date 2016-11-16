<?php

namespace FreeElephants\RestDaemon\HttpDriver\Aerys;

use Aerys\Host;
use Aerys\Request;
use Aerys\Response;
use Aerys\Router;
use FreeElephants\RestDaemon\EndpointInterface;
use FreeElephants\RestDaemon\HttpAdapter\Aerys2Zend\ServerRequest;
use FreeElephants\RestDaemon\HttpDriver\HttpDriverInterface;
use FreeElephants\RestDaemon\HttpDriver\HttpServerConfig;
use FreeElephants\RestDaemon\Middleware\EndpointMiddlewareCollectionInterface;

/**
 * @author samizdam <samizdam@inbox.ru>
 */
class AerysDriver implements HttpDriverInterface
{
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

        \Amp\run(function () {
            $arrayOfAerysHostInstances = [$this->aerysHost]; // see Aerys\Host documentation
            $arrayOfAerysOptions = []; // see Aerys\Options documentation
            $logger = new class extends \Aerys\Logger
            {
                protected function output(string $message)
                {
                    print "$message\n"; // log to stdout
                }
            };
            $server = (new \Aerys\Bootstrapper(function () use ($arrayOfAerysHostInstances) {
                return $arrayOfAerysHostInstances;
            }))->init($logger, $arrayOfAerysOptions);

            $server->start(); // returns a Promise which gets resolved after complete startup
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
                $router->route($method, $endpoint->getPath(),
                    function (Request $req, Response $resp) use ($handler) {
                        $request = new ServerRequest($req);
                        $requestBody = yield $req->getBody();
                        $request->getBody()->write($requestBody);
                        $request->getBody()->rewind();
                        $response = $handler->handle($request);
                        $resp->setStatus($response->getStatusCode());
                        $resp->setReason($response->getReasonPhrase());
                        foreach ($response->getHeaders() as $name => $values) {
                            foreach ($values as $value) {
                                $resp->addHeader($name, $value);
                            }
                        }
                        $response->getBody()->rewind();
                        $resp->end($response->getBody()->getContents());
                    });
            }
        }
        return $router;
    }
}