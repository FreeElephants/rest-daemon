<?php 
$I = new CliTester($scenario);

$I->runShellCommand('bin/rest-deamon  generate:routes:swagger example');

$I->seeInShellOutput("<?php");
$I->seeInShellOutput("return [");
$I->seeInShellOutput("  'endpoints' => [");
$I->seeInShellOutput("      '/' => [");
$I->seeInShellOutput("          'name' => 'Root Resource',");
$I->seeInShellOutput("           'handlers' => [");
$I->seeInShellOutput("                'GET' => \Example\Swagger\RootResourceHandler::class,");
