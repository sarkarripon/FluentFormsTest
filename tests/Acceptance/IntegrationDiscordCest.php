<?php


namespace Tests\Acceptance;

use Tests\Support\Helper\Acceptance\Integrations\Discord;
use Tests\Support\AcceptanceTester;

class IntegrationDiscordCest
{
    use Discord;
    public function _before(AcceptanceTester $I)
    {
        $I->loadDotEnvFile();
//        $I->loginWordpress();
    }

    // tests
    public function test_discord_notification(AcceptanceTester $I)
    {
        $jhcg = $this->fetchData("");
        dd($jhcg);

    }
}
