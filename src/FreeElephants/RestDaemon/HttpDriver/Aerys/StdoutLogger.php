<?php

namespace FreeElephants\RestDaemon\HttpDriver\Aerys;

/**
 * @author samizdam <samizdam@inbox.ru>
 */
class StdoutLogger extends \Aerys\Logger
{
    protected function output(string $message)
    {
        print $message . PHP_EOL;
    }
}