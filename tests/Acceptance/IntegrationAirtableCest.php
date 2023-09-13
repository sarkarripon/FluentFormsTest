<?php


namespace Tests\Acceptance;

use Tests\Support\AcceptanceTester;
use Tests\Support\Helper\Acceptance\Integrations\Airtable;

class IntegrationAirtableCest
{
    use Airtable;
    public function _before(AcceptanceTester $I): void
    {
        $I->loadDotEnvFile();
//        $I->loginWordpress();

    }

    // tests
    public function test_airtable_push_data(AcceptanceTester $I)
    {
        $jvj = $this->fetchData();
        print_r($jvj);



    }
}
