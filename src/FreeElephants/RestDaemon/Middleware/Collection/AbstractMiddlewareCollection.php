<?php

namespace FreeElephants\RestDaemon\Middleware\Collection;

use FreeElephants\RestDaemon\RestServer;

/**
 * @author samizdam <samizdam@inbox.ru>
 */
abstract class AbstractMiddlewareCollection extends \ArrayObject implements MiddlewareCollectionInterface
{

    protected $defaultBeforeMiddlewareMap;

    /**
     * @var RestServer
     */
    protected $server;

    public function __construct(RestServer $restServer, $additionalMiddleware = [])
    {
        $this->setServer($restServer);
        $middleware = array_merge($this->getDefaultMiddleware(), $additionalMiddleware);
        parent::__construct($middleware);
    }

    abstract protected function getDefaultMiddleware(): array;

    public function setServer(RestServer $restServer)
    {
        $this->server = $restServer;
    }
}