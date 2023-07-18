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

   public function check_test(AcceptanceTester $I, FluentFormsSelectors $fluentFormsSelectors)
   {
       $I->amOnPage("wp-admin/admin.php?page=fluent_forms&form_id=603&route=settings&sub_route=form_settings#/all-integrations/2905/platformly");

       $I->waitForElement(FluentFormsSelectors::feedName,20);
       if(!$I->checkElement(FluentFormsSelectors::conditionalLogicChecked))
       {
           $I->clicked(FluentFormsSelectors::conditionalLogicUnchecked);
       }
       $I->selectOption(FluentFormsSelectors::selectNotificationOption,'Any');
       $arrayForConditional= [
           'names[First Name]'=>['equal', 'John'],
           'names[Last Name]'=>['not equal', 'Doe'],
           'Email'=>['contains', '@gmail.com'],
       ];
       $I->click(FluentFormsSelectors::openConditionalFieldLable(1));
       $fluentFormsSelectors->clickOnText('names[First Name]');
       $I->click(FluentFormsSelectors::openConditionalFieldLable(2));
       $fluentFormsSelectors->clickOnText('equal');



       exit();


   }

}