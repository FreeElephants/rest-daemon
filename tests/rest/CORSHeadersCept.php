<?php
$I = new RestTester($scenario);
$I->wantToTest('CORS Headers. ');
$I->sendHEAD('/');
$I->seeHttpHeader('Access-Control-Allow-Origin', '*');
