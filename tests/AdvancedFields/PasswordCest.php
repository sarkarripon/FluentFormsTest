<?php


namespace Tests\AdvancedFields;

use Tests\Support\AcceptanceTester;

class PasswordCest
{
    public function _before(AcceptanceTester $I)
    {
        $I->loadDotEnvFile();
        $I->loginWordpress();
    }

    // tests
    public function test_password_field(AcceptanceTester $I)
    {
        

    }
}
