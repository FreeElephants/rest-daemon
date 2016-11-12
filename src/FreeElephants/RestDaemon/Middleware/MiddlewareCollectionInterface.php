<?php

namespace FreeElephants\RestDaemon\Middleware;

/**
 * @author samizdam <samizdam@inbox.ru>
 */
interface MiddlewareCollectionInterface extends \ArrayAccess
{

    public function getArrayCopy();

}