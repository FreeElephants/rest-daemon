<?php
$I = new RestTester($scenario);

$I->wantToTest('get params handling. ');

$I->sendGET('/greeting/Foobarchik');

$I->seeResponseCodeIs(200);
$I->seeResponseContainsJson([
    'hello' => 'Foobarchik!'
]);