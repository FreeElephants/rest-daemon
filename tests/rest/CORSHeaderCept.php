<?php
$I = new RestTester($scenario);
$I->wantToTest('CORS Header. ');
$I->sendHEAD('/');
$I->seeHttpHeader('Access-Control-Allow-Origin', '*');