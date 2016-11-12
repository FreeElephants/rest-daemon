<?php

namespace FreeElephants\RestDaemon\Middleware;

/**
 * @author samizdam <samizdam@inbox.ru>
 */
abstract class AbstractMiddlewareCollection extends \ArrayObject implements MiddlewareCollectionInterface
{

    protected $defaultBeforeMiddlewareMap;
    
    public function __construct($additionalMiddleware = [])
    {
        $middleware = array_merge($this->getDefaultMiddleware(), $additionalMiddleware);
        parent::__construct($middleware);
    }

    abstract protected function getDefaultMiddleware(): array;
}