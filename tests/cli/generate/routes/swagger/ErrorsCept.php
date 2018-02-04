<?php 
$I = new CliTester($scenario);
$I->runShellCommand('bin/rest-deamon generate:routes:swagger dir', false);
$I->seeInShellOutput('`dir not is directory`');

$I->seeResultCodeIs(1);
