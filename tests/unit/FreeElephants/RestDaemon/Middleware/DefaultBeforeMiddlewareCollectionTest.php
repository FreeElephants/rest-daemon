<?php

namespace FreeElephants\RestDaemon\Middleware;

/**
 * @author samizdam <samizdam@inbox.ru>
 */
class DefaultBeforeMiddlewareCollectionTest extends \PHPUnit_Framework_TestCase
{

    public function testDefaultMiddlewareInstances()
    {
        $stack = new DefaultBeforeMiddlewareCollection();
        self::assertInstanceOf(ContentTypeSetter::class, $stack->offsetGet(MiddlewareRole::CONTENT_TYPE_SETTER));
    }
}