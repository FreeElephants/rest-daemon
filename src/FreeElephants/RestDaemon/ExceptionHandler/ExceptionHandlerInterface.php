<?php

namespace FreeElephants\RestDaemon\ExceptionHandler;

use Psr\Http\Message\ResponseInterface;

/**
 * @author samizdam <samizdam@inbox.ru>
 */
interface ExceptionHandlerInterface
{
    public function handleException(\Exception $e): ResponseInterface;
}