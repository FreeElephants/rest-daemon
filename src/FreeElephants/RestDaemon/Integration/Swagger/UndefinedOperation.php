<?php

namespace FreeElephants\RestDaemon\Integration\Swagger;

use Swagger\Annotations\Operation;

class UndefinedOperation extends Operation
{

    public function __construct(array $properties = [])
    {
        parent::__construct($properties);
    }

}