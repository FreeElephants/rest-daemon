<?php
$I = new RestTester($scenario);

$I->wantToTest('api module support');

$I->sendGET('/api/v1/hello');
$I->seeResponseContainsJson([
    'message' => 'Hello from Api ver.1: Hello World'
]);