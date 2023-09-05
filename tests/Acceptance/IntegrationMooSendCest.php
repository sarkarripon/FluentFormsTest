<?php


namespace Tests\Acceptance;

use Tests\Support\Helper\Acceptance\Integrations\MooSend;
use Tests\Support\AcceptanceTester;

class IntegrationMooSendCest
{
    use MooSend;
    public function _before(AcceptanceTester $I): void
    {
        $I->loadDotEnvFile();
    }

    // tests
    public function test_mooSend_push_data(AcceptanceTester $I): void
    {
        $CDJ= $this->fetchData('ponyvi@gmail.com');
        print_r($CDJ);


    }
}
