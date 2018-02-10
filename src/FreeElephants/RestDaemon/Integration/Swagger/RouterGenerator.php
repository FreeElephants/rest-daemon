<?php

namespace FreeElephants\RestDaemon\Integration\Swagger;

use Swagger\Annotations\Operation;
use Swagger\Annotations\Path;

class RouterGenerator
{

    public function getRouterConfig($dir): array
    {
        $dir = realpath($dir);

        $routes = [
            'endpoints' => [],
        ];
        $paths = (\Swagger\scan($dir))->paths;
        foreach ($paths as $path) {
            $handlers = [];
            foreach ([
                         'GET',
                         'OPTIONS',
                         'POST',
                         'HEAD',
                         'PUT',
                         'DELETE',
                         'PATCH',
                         'LINK'
                     ] as $methodName) {
                $operation = $this->getOperationByMethodName($path, $methodName);
                if (!$operation instanceof UndefinedOperation) {
                    $context = $operation->_context;
                    $fullHandlerClassName = sprintf('%s\\%s', $context->namespace, $context->class);
                    $handlers[$methodName] = $fullHandlerClassName;
                }
            }
            $routes['endpoints'][$path->path] = [
                'name' => $path->_context->phpdocContent(),
                'handlers' => $handlers,
            ];
        }

        return $routes;
    }

    private function getOperationByMethodName(Path $path, string $methodName): Operation
    {
        $propertyName = strtolower($methodName);
        if (property_exists($path, $propertyName) && $operation = $path->{$propertyName}) {
            return $operation;
        }

        return new UndefinedOperation();
    }
}