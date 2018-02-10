<?php 
$I = new CliTester($scenario);
$I->runShellCommand('bin/rest-deamon');
$I->seeInShellOutput('help');
$I->seeResultCodeIs(0);
