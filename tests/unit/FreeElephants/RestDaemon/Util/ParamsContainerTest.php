<?php

namespace FreeElephants\RestDaemon\Util;

/**
 * @author samizdam <samizdam@inbox.ru>
 */
class ParamsContainerTest extends \PHPUnit_Framework_TestCase
{

    public function testGet()
    {
        $container = new ParamsContainer(['foo' => 'bar']);
        self::assertSame('bar', $container->get('foo'));
    }
}