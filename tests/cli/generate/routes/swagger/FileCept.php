<?php
$I = new CliTester($scenario);

$outputFile = 'tests/_output/routes.php';
if (file_exists('tests/_output/routes.php')) {
    unlink('tests/_output/routes.php');
}

$I->runShellCommand('bin/rest-deamon  generate:routes:swagger example tests/_output/routes.php');

\PHPUnit\Framework\Assert::assertFileEquals('tests/_fixtures/routes.php', $outputFile);
