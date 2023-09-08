<?php


namespace Tests\Acceptance;

use Tests\Support\AcceptanceTester;
use Tests\Support\Helper\Acceptance\Integrations\ConvertKit;

class IntegrationCovertKitCest
{
    use ConvertKit;
    public function _before(AcceptanceTester $I)
    {
        $I->loadDotEnvFile();
//        $I->loginWordpress();
    }

    // tests
    public function test_convertKit_push_data(AcceptanceTester $I)
    {

        $kjnfdj = $this->fetchData('xisenavuji@gmail.com');
        dd($kjnfdj);
        
    }
}
