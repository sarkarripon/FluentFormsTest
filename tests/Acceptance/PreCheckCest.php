<?php
namespace Tests\Acceptance;

use Tests\Support\AcceptanceTester;
use Tests\Support\Helper\Acceptance\DataFetcher;
use Tests\Support\Helper\Acceptance\Integrations\Mailchimp;
use Tests\Support\Helper\Acceptance\Integrations\Platformly;
use Tests\Support\Helper\Acceptance\Integrations\Zoho;
use Tests\Support\Selectors\FluentFormsSelectors;


class PreCheckCest
{

    public function _before(AcceptanceTester $I): void
    {
//        $I->wpLogin();
    }

   public function check_test(AcceptanceTester $I, Zoho $zoho ): void
   {
       print_r($zoho->fetchZohoData());

       exit();

   }

}