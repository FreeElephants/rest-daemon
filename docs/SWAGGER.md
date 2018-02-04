# Swagger Integration

You can use [Swagger](https://swagger.io/) for document your RESTful API. Rest Daemon project use [zircote/swagger-php](https://github.com/zircote/swagger-php) implementation of annotations. 

## In Your Code

### Use in Runtime

```php
<?php
$generator = new \FreeElephants\RestDaemon\Integration\Swagger\RouterGenerator();
$routerConfig = $generator->getRouterConfig($directoryForScanning);

# and use as RestServer router configuration
$server = (new \FreeElephants\RestDaemon\RestServerBuilder())->buildServer($routerConfig);
$server->run();
```

### Use with File Caching

```php
<?php
const ROUTES_FILENAME = 'router.php';

if(file_exists(ROUTES_FILENAME)) {
    $routerConfig = require ROUTES_FILENAME;
} else {
    $generator = new \FreeElephants\RestDaemon\Integration\Swagger\RouterGenerator();    
    $routerConfig = $generator->getRouterConfig($directoryForScanning);
    file_put_contents(ROUTES_FILENAME, var_export($routerConfig, true));
}

$server = (new \FreeElephants\RestDaemon\RestServerBuilder())->buildServer($routerConfig);
$server->run();
```

