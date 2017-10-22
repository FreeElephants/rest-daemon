<?php

namespace FreeElephants\DI\Exception;

use Psr\Container\NotFoundExceptionInterface;

/**
 * @author samizdam <samizdam@inbox.ru>
 */
class EntryNotFoundException extends OutOfBoundsException implements NotFoundExceptionInterface
{

}