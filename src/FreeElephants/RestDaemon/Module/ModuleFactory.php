<?php

namespace FreeElephants\RestDaemon\Module;

/**
 * @author samizdam <samizdam@inbox.ru>
 */
class ModuleFactory implements ModuleFactoryInterface
{

    public function buildModule(string $modulePath, array $moduleConfig): ApiModuleInterface
    {
        $moduleName = $this->getModuleName($modulePath, $moduleConfig);
        $module = new BaseApiModule($modulePath, $moduleName);
        return $module;
    }

    private function getModuleName(string $modulePath, array $moduleConfig): string
    {
        if (isset($moduleConfig['name'])) {
            return (string)$moduleConfig['name'];
        } else {
            return $modulePath;
        }

    }
}