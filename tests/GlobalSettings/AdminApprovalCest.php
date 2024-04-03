<?php


namespace Tests\GlobalSettings;

use Tests\Support\AcceptanceTester;

class AdminApprovalCest
{
    public function _before(AcceptanceTester $I)
    {
        $I->loadDotEnvFile();
        $I->loginWordpress();
    }

    // tests
    public function test_admin_approval(AcceptanceTester $I)
    {



    }
}
