<?php
namespace Tests\Acceptance;

use Tests\Support\AcceptanceTester;
use Tests\Support\Helper\Acceptance\DataFetcher;
use Tests\Support\Helper\Acceptance\Integrations\Mailchimp;
use Tests\Support\Helper\Acceptance\Integrations\Platformly;
use Tests\Support\Selectors\FluentFormsSelectors;


class PreCheckCest
{

    public function _before(AcceptanceTester $I): void
    {
        $I->wpLogin();
    }

   public function check_test(AcceptanceTester $I, DataFetcher $fetcher, Mailchimp $mailchimp, Platformly $platformly): void
   {

       $I->amOnPage("wp-admin/admin.php?page=fluent_forms&form_id=100&route=settings&sub_route=form_settings#/all-integrations/655/platformly");
//
//       $I->waitForElement(FluentFormsSelectors::integrationFeed,20);
//       $I->fillField(FluentFormsSelectors::integrationFeed,'Mailchimp Integration');
//       $I->clicked(FluentFormsSelectors::SegmentDropDown);
//       $I->clicked(FluentFormsSelectors::Segment);

       $otherFieldArray =[
              'Address' => '{inputs.address_1}',
              'Birthday' => '{inputs.birthday}',
              'First Name' => '{inputs.names.first_name}',
              'Last Name' => '{inputs.names.last_name}',
              'Phone Number' => '{inputs.phone}',
       ];
//       $mailchimp->mapMailchimpFields('yes',[],'');



//       $I->clicked(FluentFormsSelectors::enableOption('Enable Dynamic Tag Input'));
//
//       $dynamicTagArray = [
//           'European' => ['names[First Name]', 'contains', 'John'],
//       ];
//
//       global $dynamicTagField;
//       $dynamicTagField = 1;
//       $dynamicTagValue = 1;
//       foreach ($dynamicTagArray as $tag => $value)
//       {
//           $I->fillField(FluentFormsSelectors::dynamicTagField($dynamicTagField),$tag);
//
//           $I->click(FluentFormsSelectors::ifClause($dynamicTagValue));
//           $I->clickOnText($value[0]);
//
//           $I->click(FluentFormsSelectors::ifClause($dynamicTagValue+1));
//           $I->clickOnText($value[1]);
//
//           $I->fillField(FluentFormsSelectors::dynamicTagValue($dynamicTagField),$value[2]);
//           $I->click(FluentFormsSelectors::addDynamicTagField($dynamicTagField));
//           $dynamicTagField++;
//           $dynamicTagValue+=2;
//       }
//       $I->click(FluentFormsSelectors::removeDynamicTagField($dynamicTagField));
//
//       $I->fillField(FluentFormsSelectors::mailchimpNote,'This is a test note');
//
//       $I->clicked(FluentFormsSelectors::enableOption('Enable Double Opt-in'));
//       $I->clicked(FluentFormsSelectors::enableOption('Enable ReSubscription'));
//       $I->clicked(FluentFormsSelectors::enableOption('Mark as VIP Contact'));
//       $I->clicked(FluentFormsSelectors::enableOption('Enable conditional logic'));
//        echo $fetcher->fetchAPIData('platformly','kassulke.efrain@gmail.com');
//       $I->executeJS("document.querySelector('(//label[normalize-space()=\"First Name\"]/following::input[@placeholder=\"Select a Field or Type Custom value\"])[1]').value = 'Your value';");
       $I->fillByJS(FluentFormsSelectors::commonFields('First Name'),'{inputs.names.first_name}');




       exit();

   }

}