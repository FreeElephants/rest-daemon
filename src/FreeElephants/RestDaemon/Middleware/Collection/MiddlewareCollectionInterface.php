<?php

namespace FreeElephants\RestDaemon\Middleware\Collection;

/**
 * @author samizdam <samizdam@inbox.ru>
 */
interface MiddlewareCollectionInterface extends \ArrayAccess
{

    public function getArrayCopy();

}