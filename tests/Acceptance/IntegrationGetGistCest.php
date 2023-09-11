<?php


namespace Tests\Acceptance;

use Tests\Support\AcceptanceTester;
use Tests\Support\Helper\Acceptance\Integrations\GetGist;

class IntegrationGetGistCest
{
    use GetGist;
    public function _before(AcceptanceTester $I)
    {
        $I->loadDotEnvFile();
    }

    // tests
    public function test_getGist_push_data(AcceptanceTester $I)
    {
        $kjnvj = $this->fetchData("gebuj@gmail.com");
        dd($kjnvj);
    }
}
