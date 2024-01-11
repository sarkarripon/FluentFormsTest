<?php


namespace Tests\AdvancedFields;

use Tests\Support\AcceptanceTester;

class RepeatFieldCest
{
    public function _before(AcceptanceTester $I)
    {
        $I->loadDotEnvFile();
        $I->loginWordpress();
    }

    // tests
    public function test_repeat_field(AcceptanceTester $I)
    {

    }
}
