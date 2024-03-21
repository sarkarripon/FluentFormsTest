<?php


namespace Tests\GlobalSettings;

use Tests\Support\AcceptanceTester;

class DoubleOptInCest
{
    public function _before(AcceptanceTester $I)
    {
        $I->loadDotEnvFile();
        $I->loginWordpress();
    }

    // tests
    public function test_double_opt_in(AcceptanceTester $I)
    {

    }
}
