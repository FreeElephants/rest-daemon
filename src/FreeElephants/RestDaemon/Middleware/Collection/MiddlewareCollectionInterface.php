<?php

namespace FreeElephants\RestDaemon\Middleware\Collection;

use FreeElephants\RestDaemon\RestServer;

/**
 * @author samizdam <samizdam@inbox.ru>
 */
interface MiddlewareCollectionInterface extends \ArrayAccess
{

    public function getArrayCopy();

    public function setServer(RestServer $restServer);
}