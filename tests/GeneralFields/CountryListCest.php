<?php


namespace Tests\GeneralFields;

use Tests\Support\AcceptanceTester;

class CountryListCest
{
    public function _before(AcceptanceTester $I)
    {
        $I->loadDotEnvFile();
        $I->loginWordpress();
    }

    // tests
    public function test_country_list(AcceptanceTester $I)
    {


    }
}
