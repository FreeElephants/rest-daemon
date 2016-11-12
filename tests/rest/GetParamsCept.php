<?php 
$I = new RestTester($scenario);

$I->wantToTest('get params handling. ');

$I->sendGET('/greeting', [
    'name' => 'Foobarchik'
]);

$I->seeResponseCodeIs(200);
$I->seeResponseContainsJson([
    'hello' => 'Foobarchik!'
]);
