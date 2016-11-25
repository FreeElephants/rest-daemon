<?php
$I = new RestTester($scenario);

$I->wantToTest('api module support');

$I->sendGET('/api/v1/hello');
$I->seeResponseContainsJson([
    'message' => 'Hello from Api ver.1: Hello World',
    'baseServerUri' => 'http://127.0.0.1:8080/',
    'baseEndpointPath' => '/api/v1/hello'
]);