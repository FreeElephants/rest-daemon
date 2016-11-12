<?php 
$I = new RestTester($scenario);

$I->wantToTest('exception handling. ');

$I->sendGET('/exception');

$I->seeResponseCodeIs(500);
$I->seeHttpHeader('Content-Type', 'application/json');
$I->seeResponseContainsJson([
    'message' => 'Logic exception'
]);
