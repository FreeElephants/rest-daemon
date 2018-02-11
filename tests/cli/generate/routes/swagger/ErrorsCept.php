<?php 
$I = new CliTester($scenario);
$I->runShellCommand('bin/rest-daemon generate:routes:swagger no-existed-dir', false);
$I->seeResultCodeIs(1);
