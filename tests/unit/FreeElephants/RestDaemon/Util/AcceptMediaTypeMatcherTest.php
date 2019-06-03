<?php

namespace FreeElephants\RestDaemon\Util;

use FreeElephants\AbstractTestCase;

class AcceptMediaTypeMatcherTest extends AbstractTestCase
{
    /**
     * @dataProvider provideValidMediaTypes
     * @test
     */
    public function match_sameMediaTypes_returnTrue(string $firstType, string $secondType): void
    {
        $matched = AcceptMediaTypeMatcher::match($firstType, $secondType);

        $this->assertTrue($matched);
    }

    /**
     * @dataProvider provideInvalidMediaTypes
     * @test
     */
    public function match_differentMediaTypes_returnFalse(string $firstType, string $secondType): void
    {
        $matched = AcceptMediaTypeMatcher::match($firstType, $secondType);

        $this->assertFalse($matched);
    }

    public function provideValidMediaTypes(): array
    {
        return [
            ['audio/midi', 'audio/midi'],
            ['audio/*', 'audio/midi'],
            ['audio/*', 'audio/mpeg'],
            ['*/*', 'audio/midi'],
            ['*', 'audio/midi'],
        ];
    }

    public function provideInvalidMediaTypes(): array
    {
        return [
            ['audio/midi', 'application/json'],
            ['audio/midi', 'audio/mpeg'],
            ['audio/*', 'application/json'],
        ];
    }
}
