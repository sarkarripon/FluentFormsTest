<?php
namespace Tests\Acceptance;
use Tests\Support\AcceptanceTester;
use Tests\Support\Helper\Acceptance\Integrations\Activecampaign;
use Tests\Support\Helper\Acceptance\Integrations\IntegrationHelper;
use Tests\Support\Helper\Acceptance\Integrations\Googlesheet;
use Tests\Support\Helper\Acceptance\Integrations\Mailchimp;
use Tests\Support\Helper\Acceptance\Integrations\Platformly;
use Tests\Support\Helper\Acceptance\Integrations\Trello;


class PreCheckCest
{
    use IntegrationHelper;

    public function _before(AcceptanceTester $I): void
    {
//        $I->env();
//        $I->wpLogin();
    }


    public function check_test(AcceptanceTester $I): void
    {


    }


}