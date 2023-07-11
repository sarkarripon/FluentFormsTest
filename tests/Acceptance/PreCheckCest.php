<?php
namespace Tests\Acceptance;

use Tests\Support\AcceptanceTester;
use Tests\Support\Helper\Acceptance\Integrations\Platformly;
use Tests\Support\Selectors\FluentFormsSelectors;


class PreCheckCest
{

    public function _before(AcceptanceTester $I): void
    {
        $I->wpLogin();
    }

   public function check_test(AcceptanceTester $I, Platformly $integration)
   {
       $I->amOnPage("/wp-admin/admin.php?page=fluent_forms&form_id=600&route=settings&sub_route=form_settings#/all-integrations/2884/platformly");

       $I->waitForElement(FluentFormsSelectors::feedName,20);
       $I->clicked(FluentFormsSelectors::enableDynamicTag);

       exit();


   }

}