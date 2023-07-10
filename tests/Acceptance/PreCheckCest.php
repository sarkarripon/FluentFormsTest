<?php
namespace Tests\Acceptance;

use Tests\Support\AcceptanceTester;
use Tests\Support\Helper\Acceptance\Integrations\platformly;


class PreCheckCest
{

    public function _before(AcceptanceTester $I): void
    {
        $I->wpLogin();
    }

   public function check_test(AcceptanceTester $I, Platformly $integration): void
   {
//       $I->amOnPage("wp-admin/admin.php?page=fluent_forms&form_id=589&route=settings&sub_route=form_settings#/all-integrations/2808/platformly");




       exit();


   }

}