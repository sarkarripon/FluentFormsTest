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

       $I->amOnPage("wp-admin/admin.php?page=fluent_forms&form_id=91&route=settings&sub_route=form_settings#/all-integrations/597/mailchimp");

       $I->waitForElement(FluentFormsSelectors::feedName,20);
       $I->fillField(FluentFormsSelectors::feedName,'Mailchimp Integration');
       $I->clicked(FluentFormsSelectors::SegmentDropDown);
       $I->clicked(FluentFormsSelectors::Segment);


       $I->clickOnText('Select Interest Category');
       $I->clickOnText('Authlab');
       $I->clickOnText('Select Interest');
       $I->clickOnText('fluentforms');

       $I->fillField(FluentFormsSelectors::mailchimpStaticTag,'US');

       $I->clickOnText('Enable Dynamic Tag');

       $dynamicTagArray = [
           'European' => ['names[First Name]', 'contains', 'John'],
       ];

       global $dynamicTagField;
       $dynamicTagField = 1;
       $dynamicTagValue = 1;
       foreach ($dynamicTagArray as $tag => $value)
       {
           $I->fillField(FluentFormsSelectors::mailchimpDynamicTag($dynamicTagField),$tag);

           $I->click(FluentFormsSelectors::ifClause($dynamicTagValue));
           $I->clickOnText($value[0]);

           $I->click(FluentFormsSelectors::ifClause($dynamicTagValue+1));
           $I->clickOnText($value[1]);

           $I->fillField(FluentFormsSelectors::dynamicTagValue($dynamicTagField),$value[2]);
           $I->click(FluentFormsSelectors::addDynamicTagField($dynamicTagField));
           $dynamicTagField++;
           $dynamicTagValue+=2;
       }
       $I->click(FluentFormsSelectors::removeDynamicTagField($dynamicTagField));

       $I->fillField(FluentFormsSelectors::mailchimpNote,'This is a test note');
       $I->clicked(FluentFormsSelectors::enableOption('Double Opt-in'));
       $I->clicked(FluentFormsSelectors::enableOption('ReSubscribe'));
       $I->clicked(FluentFormsSelectors::enableOption('VIP'));
       $I->clicked(FluentFormsSelectors::enableOption('Conditional Logics'));
       $I->clicked(FluentFormsSelectors::enableOption('Status'));

       exit();

   }

}