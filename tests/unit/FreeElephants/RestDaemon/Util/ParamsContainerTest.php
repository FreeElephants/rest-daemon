<?php

namespace FreeElephants\RestDaemon\Util;

use FreeElephants\AbstractTestCase;

/**
 * @author samizdam <samizdam@inbox.ru>
 */
class ParamsContainerTest extends AbstractTestCase
{

    public function testGet()
    {
        $container = new ParamsContainer(['foo' => 'bar']);
        self::assertSame('bar', $container->get('foo'));
    }
}