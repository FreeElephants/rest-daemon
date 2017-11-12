<?php
$I = new RestTester($scenario);

$I->wantToTest('OPTIONS on routes ');

$I->haveHttpHeader('Access-Control-Request-Method', 'GET');
$I->haveHttpHeader('Access-Control-Request-Headers', 'X-HELLO');
$I->sendOPTIONS('/hello');

$I->seeResponseCodeIs(200);
$I->seeHttpHeader('Access-Control-Allow-Methods', 'GET, OPTIONS');
$I->seeHttpHeader('Access-Control-Allow-Headers', 'X-HELLO');
$I->seeHttpHeader('Allow', 'GET, OPTIONS');
$I->seeResponseEquals('');

$I->seeHttpHeader('Access-Control-Allow-Headers', 'X-HELLO');
$I->sendOPTIONS('/greeting');

$I->seeResponseCodeIs(200);
$I->seeHttpHeader('Access-Control-Allow-Headers', 'X-Greeting, X-Some-Not-Simple');
$I->seeHttpHeader('Allow', 'GET, OPTIONS, POST');
$I->seeResponseEquals('');


