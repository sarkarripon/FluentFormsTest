<?php
namespace Tests\Acceptance;

use Google\Exception;
use Tests\Support\AcceptanceTester;
use Tests\Support\Helper\Acceptance\DataFetcher;
use Tests\Support\Helper\Acceptance\Integrations\Googlesheet;
use Tests\Support\Helper\Acceptance\Integrations\Mailchimp;
use Tests\Support\Helper\Acceptance\Integrations\Platformly;
use Tests\Support\Helper\Acceptance\Integrations\Zoho;
use Tests\Support\Selectors\FluentFormsSelectors;


class PreCheckCest
{

    public function _before(AcceptanceTester $I)
    {
        $I->env();
        $I->wpLogin();
    }

    /**
     * @throws Exception
     */
    public function check_test(AcceptanceTester $I, Googlesheet $sheet): void
   {
//       $sheet->configureGoogleSheet(25);

        $I->loginGoogle();

   }

}