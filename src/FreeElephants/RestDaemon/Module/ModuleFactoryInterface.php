<?php

namespace FreeElephants\RestDaemon\Module;

/**
 * @author samizdam <samizdam@inbox.ru>
 */
interface ModuleFactoryInterface
{
    public function buildModule(string $modulePath, array $moduleConfig): ApiModuleInterface;
}