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

   public function check_test(AcceptanceTester $I, Platformly $platformly)
   {

       $I->amOnPage('wp-admin/admin.php?page=fluent_forms&form_id=91&route=settings&sub_route=form_settings#/all-integrations/0/mailchimp');

       $I->waitForElement(FluentFormsSelectors::feedName,20);
       $I->fillField(FluentFormsSelectors::feedName,'Mailchimp Integration');
       $I->clicked(FluentFormsSelectors::SegmentDropDown);
       $I->clicked(FluentFormsSelectors::Segment);



       exit();

   }

}