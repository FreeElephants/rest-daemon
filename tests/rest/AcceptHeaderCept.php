<?php
$I = new RestTester($scenario);

$I->wantToTest('accept media type header ');

$I->haveHttpHeader('Accept', '*/*');
$I->sendGET('/greeting');

$I->seeResponseCodeIs(200);
$I->seeHttpHeader('Content-Type', 'application/json');

//////
$I->haveHttpHeader('Accept', 'application/json');
$I->sendGET('/greeting');

$I->seeResponseCodeIs(200);
$I->seeHttpHeader('Content-Type', 'application/json');

//////
$I->haveHttpHeader('Accept', 'text/yaml, */*');
$I->sendGET('/greeting');

$I->seeResponseCodeIs(200);
$I->seeHttpHeader('Content-Type', 'application/json');

//////
$I->haveHttpHeader('Accept', 'text/yaml');
$I->sendGET('/greeting');

$I->seeResponseCodeIs(406);
$I->seeHttpHeader('Content-Type', 'application/json');

