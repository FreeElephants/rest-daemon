<?php
$I = new RestTester($scenario);

$I->wantToTest('get params handling. ');

$I->haveHttpHeader('Content-Type', 'application/x-www-form-urlencoded');
$I->sendPOST('/greeting', [
    'name' => 'Post Foobarchik'
]);

$I->seeResponseCodeIs(200);
$I->seeResponseContainsJson([
    'hello' => 'Post Foobarchik!'
]);
