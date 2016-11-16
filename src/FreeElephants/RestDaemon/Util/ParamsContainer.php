<?php

namespace FreeElephants\RestDaemon\Util;

/**
 * @author samizdam <samizdam@inbox.ru>
 */
class ParamsContainer extends \ArrayObject
{

    public function __construct($params)
    {
        parent::__construct($params);
    }

    public function has($key): bool
    {
        return $this->offsetExists($key);
    }

    public function get($key, $defaultValue = null)
    {
        if ($this->has($key)) {
            $value = $this->offsetGet($key);
        } else {
            $value = $defaultValue;
        }

        return $value;
    }
}