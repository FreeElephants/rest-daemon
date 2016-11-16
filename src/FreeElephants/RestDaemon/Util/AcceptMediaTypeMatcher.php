<?php

namespace FreeElephants\RestDaemon\Util;

use Zend\Http\Header\Accept;

/**
 * @author samizdam <samizdam@inbox.ru>
 */
class AcceptMediaTypeMatcher
{

    public static function match(string $allowed, string $given): bool
    {
        $allowedAcceptHeaders = Accept::fromString($allowed);
        return (bool)$allowedAcceptHeaders->match($given);
    }
}