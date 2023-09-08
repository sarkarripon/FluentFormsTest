<?php


namespace Tests\Acceptance;

use Tests\Support\AcceptanceTester;

class IntegrationTwilioCest
{
    public function _before(AcceptanceTester $I)
    {
        $I->loadDotEnvFile();
//        $I->loginWordpress();
    }

    // tests
    public function tryToTest(AcceptanceTester $I)
    {

    }
}
