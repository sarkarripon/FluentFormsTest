<?php


namespace Tests\Acceptance;

use Tests\Support\Helper\Acceptance\Integrations\ConstantContact;
use Tests\Support\AcceptanceTester;

class IntegrationConstantContactCest
{
    use ConstantContact;
    public function _before(AcceptanceTester $I)
    {
        $I->loadDotEnvFile();
//        $I->loginWordpress();
    }

    // tests
    public function test_constantcontact_push_data(AcceptanceTester $I)
    {
        $djfbhf = $this->fetchData("marigu@mailinator.com");
        dd($djfbhf);
    }


}
