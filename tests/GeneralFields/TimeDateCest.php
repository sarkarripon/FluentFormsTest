<?php


namespace Tests\GeneralFields;

use Tests\Support\AcceptanceTester;

class TimeDateCest
{
    public function _before(AcceptanceTester $I)
    {
        $I->loadDotEnvFile();
        $I->loginWordpress();
    }

    // tests
    public function test_date_time_field(AcceptanceTester $I)
    {


    }
}
