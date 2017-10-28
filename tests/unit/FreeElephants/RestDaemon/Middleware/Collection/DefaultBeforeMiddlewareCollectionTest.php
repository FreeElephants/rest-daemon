<?php

namespace FreeElephants\RestDaemon\Middleware\Collection;

use FreeElephants\AbstractTestCase;
use FreeElephants\RestDaemon\Middleware\ContentTypeSetter;
use FreeElephants\RestDaemon\Middleware\MiddlewareRole;

/**
 * @author samizdam <samizdam@inbox.ru>
 */
class DefaultBeforeMiddlewareCollectionTest extends AbstractTestCase
{

    public function testDefaultMiddlewareInstances()
    {
        $stack = new DefaultBeforeMiddlewareCollection();
        self::assertInstanceOf(ContentTypeSetter::class, $stack->offsetGet(MiddlewareRole::CONTENT_TYPE_SETTER));
    }
}