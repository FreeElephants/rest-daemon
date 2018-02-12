<?php 
$I = new CliTester($scenario);
$I->runShellCommand('bin/rest-daemon');
$I->seeInShellOutput('help');
$I->seeResultCodeIs(0);
