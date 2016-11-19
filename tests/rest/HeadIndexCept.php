<?php
$I = new RestTester($scenario);
$I->wantToTest('get index');
$I->sendHEAD('/');
$I->seeResponseCodeIs(204);