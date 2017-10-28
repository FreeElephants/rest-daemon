<?php

namespace FreeElephants\RestDaemon\Module;


use FreeElephants\AbstractTestCase;

class ModuleFactoryTest extends AbstractTestCase
{

    public function testBuild_with_path_and_name_only()
    {
        $factory = new ModuleFactory();
        $module = $factory->buildModule('/api/v1', ['name' => 'Api v.1 module']);
        $this->assertSame('/api/v1', $module->getPath());
        $this->assertSame('Api v.1 module', $module->getName());
    }

    public function testBuild_with_path_and_without_name()
    {
        $factory = new ModuleFactory();
        $module = $factory->buildModule('/api/v1', []);
        $this->assertSame('/api/v1', $module->getPath());
        $this->assertSame('/api/v1', $module->getName());
    }
}