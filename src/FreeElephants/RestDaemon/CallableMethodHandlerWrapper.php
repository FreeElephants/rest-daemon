<?php

namespace FreeElephants\RestDaemon;

use Guzzle\Http\Message\RequestInterface;
use Guzzle\Http\Message\Response;

/**
 * @author samizdam <samizdam@inbox.ru>
 */
class CallableMethodHandlerWrapper implements MethodHandlerInterface
{
    /**
     * @var callable
     */
    private $func;

    public function __construct(callable $func)
    {
        $this->func = $func;
    }

    public function handle(RequestInterface $request = null): Response
    {
        return call_user_func($this->func, $request);
    }
}