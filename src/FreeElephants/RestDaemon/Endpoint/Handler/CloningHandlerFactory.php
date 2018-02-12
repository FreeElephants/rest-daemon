<?php

namespace FreeElephants\RestDaemon\Endpoint\Handler;

use Psr\Container\ContainerInterface;
use Psr\Log\LoggerAwareTrait;
use Psr\Log\NullLogger;

/**
 * @author samizdam <samizdam@inbox.ru>
 */
class CloningHandlerFactory implements HandlerFactoryInterface
{

    use LoggerAwareTrait;

    /**
     * @var ContainerInterface
     */
    private $di;

    public function __construct(ContainerInterface $di)
    {
        $this->logger = new NullLogger();
        $this->di = $di;
    }

    public function buildHandler(string $className): EndpointMethodHandlerInterface
    {
        $this->logger->debug(sprintf('Build handler %s', $className));

        return clone $this->di->get($className);
    }
}