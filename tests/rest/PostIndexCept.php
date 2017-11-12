<?php
$I = new RestTester($scenario);
$I->wantToTest('Method Not Allowed response. ');
$I->sendPOST('/');
$I->seeResponseCodeIs(405);

// TODO remove if after aerys update with https://github.com/amphp/aerys/pull/205
if ($I->isPoweredByAerys()) {
    $I->seeHttpHeader('Allow', 'OPTIONS,GET');
} else {
    $I->seeHttpHeader('Allow', 'OPTIONS, GET');
}
