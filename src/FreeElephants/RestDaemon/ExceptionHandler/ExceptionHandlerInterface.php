<?php

namespace FreeElephants\RestDaemon\ExceptionHandler;

use Guzzle\Http\Message\Response;

/**
 * @author samizdam <samizdam@inbox.ru>
 */
interface ExceptionHandlerInterface
{

    public function handleError(\Exception $exception): Response;
}