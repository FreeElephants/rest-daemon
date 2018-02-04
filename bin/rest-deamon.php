<?php

use FreeElephants\RestDaemon\Console\Command\Generator\Swagger;
use Symfony\Component\Console\Application;
use Symfony\Component\Console\Input\ArgvInput;
use Symfony\Component\Console\Output\ConsoleOutput;

require_once __DIR__ . '/../vendor/autoload.php';

$app = new Application();
$command = new Swagger();
$app->add($command);
try {
    $input = new ArgvInput();
    $app->run($input, new ConsoleOutput());
} catch (Throwable $e) {
    echo $e->getMessage();
    exit(1);
}