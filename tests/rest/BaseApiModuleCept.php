<?php
$I = new RestTester($scenario);

$I->wantToTest('default api module');

$I->sendGET('/hello');
$I->seeResponseContainsJson([
    'message' => 'Hello from Default Api Module: Hello World',
    'baseEndpointPath' => '/hello'
]);