<?php
namespace Tests\Acceptance;
use Tests\Support\AcceptanceTester;
use Tests\Support\Helper\Acceptance\Integrations\Activecampaign;
use Tests\Support\Helper\Acceptance\Integrations\IntegrationHelper;
use Tests\Support\Helper\Acceptance\Integrations\General;
use Tests\Support\Helper\Acceptance\Integrations\Googlesheet;
use Tests\Support\Helper\Acceptance\Integrations\Mailchimp;
use Tests\Support\Helper\Acceptance\Integrations\Platformly;
use Tests\Support\Helper\Acceptance\Integrations\Trello;


class PreCheckCest
{
    use IntegrationHelper;

    public function _before(AcceptanceTester $I): void
    {
        $I->env();
//        $I->wpLogin();
    }


    public function check_test(AcceptanceTester $I, Activecampaign $activecampaign, General $general, Googlesheet $googlesheet,
                               Trello $trello, Mailchimp $mailchimp, Platformly $platformly): void
    {
//        print_r($activecampaign->fetchActivecampaignData('qa@wpmanageninja.co'));
//        print_r($googlesheet->fetchGoogleSheetData('ugoldner@gmail.com'));
        print_r($trello->fetchTrelloData('Aut deleniti dolore.'));








    }


}