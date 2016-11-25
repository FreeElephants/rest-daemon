<?php
$I = new RestTester($scenario);

$I->wantToTest('api reusable between modules endpoint and handlers');

$I->sendGET('/api/v2/hello');
$I->seeResponseContainsJson([
    'message' => 'Hello from Api ver.2: Hello World'
]);