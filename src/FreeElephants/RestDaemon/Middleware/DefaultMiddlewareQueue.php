<?php

namespace FreeElephants\RestDaemon\Middleware;

/**
 * @author samizdam <samizdam@inbox.ru>
 */
class DefaultMiddlewareQueue extends \ArrayObject
{

    protected $defaultMiddleware = [];

    public function __construct(\Traversable $additionalMiddleware = [])
    {
        $middleware = array_merge($this->defaultMiddleware, iterator_to_array($additionalMiddleware));
        parent::__construct($middleware);
    }
}