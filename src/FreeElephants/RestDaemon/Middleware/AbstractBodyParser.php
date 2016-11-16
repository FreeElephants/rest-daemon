<?php

namespace FreeElephants\RestDaemon\Middleware;

use FreeElephants\RestDaemon\Util\ParamsContainer;

/**
 * @author samizdam <samizdam@inbox.ru>
 */
abstract class AbstractBodyParser implements MiddlewareInterface
{
    const DEFAULT_CONTAINER_CLASS = ParamsContainer::class;

    /**
     * @var
     */
    private $parameterContainer;

    public function __construct($parameterContainer = self::DEFAULT_CONTAINER_CLASS)
    {
        $this->parameterContainer = $parameterContainer;
    }

    protected function wrapParamsToContainer(array $data)
    {
        return new $this->parameterContainer($data);
    }

}