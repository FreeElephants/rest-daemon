<?php 
$I = new RestTester($scenario);
$I->wantToTest('get index');
$I->sendGET('/');
$I->seeResponseCodeIs(200);
$I->seeHttpHeader('Content-type', 'application/json');