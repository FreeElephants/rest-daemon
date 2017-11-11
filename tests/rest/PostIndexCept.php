<?php
$I = new RestTester($scenario);
$I->wantToTest('Method Not Allowed response. ');
$I->sendPOST('/');
$I->seeResponseCodeIs(405);
$I->seeHttpHeader('Allow', 'OPTIONS, GET');