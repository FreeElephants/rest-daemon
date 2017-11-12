<?php

namespace FreeElephants\RestDaemon\Middleware\Collection;

use FreeElephants\AbstractTestCase;
use FreeElephants\RestDaemon\Middleware\ContentTypeSetter;
use FreeElephants\RestDaemon\Middleware\MiddlewareRole;
use FreeElephants\RestDaemon\RestServer;

/**
 * @author samizdam <samizdam@inbox.ru>
 */
class DefaultBeforeMiddlewareCollectionTest extends AbstractTestCase
{

    public function testDefaultMiddlewareInstances()
    {
        $stack = new DefaultBeforeMiddlewareCollection($this->createMock(RestServer::class));
        self::assertInstanceOf(ContentTypeSetter::class, $stack->offsetGet(MiddlewareRole::CONTENT_TYPE_SETTER));
    }
}