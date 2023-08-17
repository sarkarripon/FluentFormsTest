<?php


namespace Tests\Acceptance;

use Tests\Support\AcceptanceTester;
use Tests\Support\Helper\Acceptance\Integrations\IntegrationHelper;
use Tests\Support\Helper\Acceptance\Integrations\Zapier;

class IntegrationZapierCest
{
    use IntegrationHelper, Zapier;
    public function _before(AcceptanceTester $I)
    {
        $I->env();
        $I->wpLogin();
    }

    public function test_zapier_push_data(AcceptanceTester $I): void
    {
        $this->configureZapier($I, 7);
        exit();

    }


}
