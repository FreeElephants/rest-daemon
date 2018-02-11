<?php

namespace FreeElephants;

use PHPUnit\Framework\TestCase;

abstract class AbstractTestCase extends TestCase
{
    const TEST_ROOT_DIR = __DIR__ . '/../../..';
    const EXAMPLES_DIR = self::TEST_ROOT_DIR . '/../../../examples';
}