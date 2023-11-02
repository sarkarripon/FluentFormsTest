<?php


namespace Tests\GeneralFields;

use Tests\Support\AcceptanceTester;

class AddressFieldCest
{
    public function _before(AcceptanceTester $I)
    {
        $I->loadDotEnvFile();
        $I->loginWordpress();
    }

    // tests
    public function test_address_field(AcceptanceTester $I)
    {

    }
}
