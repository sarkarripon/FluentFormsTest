<?php
namespace Tests\Acceptance;

use Codeception\Example;
use Tests\Support\AcceptanceTester;
use Tests\Support\Helper\Acceptance\Integrations\Platformly;
use Tests\Support\Selectors\FluentFormsAllEntries;
use Tests\Support\Selectors\FluentFormsSelectors;


class PreCheckCest
{

    public function _before(AcceptanceTester $I): void
    {
        $I->wpLogin();
    }

   public function check_test(AcceptanceTester $I)
   {

       $I->amOnPage("wp-admin/admin.php?page=fluent_forms&route=entries&form_id=40#/entries/25");
       $I->clicked(FluentFormsAllEntries::apiCalls);
       $I->waitForElement(FluentFormsAllEntries::noLogFound,10);
       $text = $I->grabTextFrom(FluentFormsAllEntries::noLogFound);
       echo $text;
//
//       if($example['dataState'] == 'valid')
//       {
//           $I->dontSee(FluentFormsAllEntries::noLogFound);
//           $I->assertStringContainsStringIgnoringCase('Success',$I->checkAPICallStatus('Success', FluentFormsAllEntries::logSuccessStatusText));
//       }
//       if ($example['dataState'] == 'invalid')
//       {
//           $I->seeElement(FluentFormsAllEntries::noLogFound);
//           $I->dontSee('Success',$I->checkAPICallStatus());
//       }




   }

}