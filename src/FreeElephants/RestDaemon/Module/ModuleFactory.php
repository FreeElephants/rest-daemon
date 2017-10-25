<?php

namespace FreeElephants\RestDaemon\Module;

/**
 * @author samizdam <samizdam@inbox.ru>
 */
class ModuleFactory implements ModuleFactoryInterface
{

    public function buildModule(string $modulePath, array $moduleConfig): ApiModuleInterface
    {
        $moduleName = $moduleConfig['name'];
        $module = new BaseApiModule($modulePath, $moduleName);
        return $module;
    }
}