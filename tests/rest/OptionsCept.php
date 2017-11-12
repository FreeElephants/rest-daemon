<?php
$I = new RestTester($scenario);

$I->wantToTest('OPTIONS on routes ');

$I->sendOPTIONS('/hello');
$I->seeResponseCodeIs(200);

$I->seeHttpHeader('Allow', 'GET, OPTIONS');

$I->seeResponseEquals('');

$I->sendOPTIONS('/greeting');
$I->seeResponseCodeIs(200);
$I->seeHttpHeader('Allow', 'GET, OPTIONS, POST');
$I->seeResponseEquals('');


