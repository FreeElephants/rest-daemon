<?php

namespace FreeElephants\RestDaemon;

use Guzzle\Http\Message\RequestInterface;
use Guzzle\Http\Message\Response;

/**
 * @author samizdam <samizdam@inbox.ru>
 */
interface MethodHandlerInterface
{

    public function handle(RequestInterface $request = null): Response;
}