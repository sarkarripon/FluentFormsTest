<?php
namespace Tests\Acceptance;

use Codeception\Example;
use Facebook\WebDriver\WebDriverBy;
use Tests\Support\AcceptanceTester;
use Tests\Support\Factories\DataProvider\FormData;
use Tests\Support\Helper\Acceptance\IntegrationHelper as Integration;
use Tests\Support\Selectors\FieldSelectors;
use Tests\Support\Selectors\FluentFormsSelectors;
use Facebook\WebDriver\Remote\RemoteWebDriver;

class PreCheckCest
{
    use Integration;
    public function _before(AcceptanceTester $I): void
    {
        $I->wpLogin();
    }

   public function check_test(AcceptanceTester $I): void
   {
       $I->amOnPage("wp-admin/admin.php?page=fluent_forms&form_id=550&route=settings&sub_route=form_settings#/all-integrations/2583/platformly");

       $otherFieldsArray = [
           'Address Line 1'=>'{inputs.address_1.address_line_1}',
           'Address Line 2'=>'{inputs.address_1.address_line_2}',
           'City'=>'{inputs.address_1.city}',
           'State'=>'{inputs.address_1.state}',
           'Zip'=>'{inputs.address_1.zip}',

       ];
//       foreach ($otherFieldsArray as $fieldLabel => $fieldValue) {
//
//
//       }

       $I->clicked(FluentFormsSelectors::addField);
       $I->click(FluentFormsSelectors::fieldLabel(1));
       $I->wait(2);
       $I->moveMouseOver("//div[@x-placement='bottom-start']//span[contains(normalize-space(),'Address Line 1')]");



//       $I->executeInSelenium(function (RemoteWebDriver $webdriver) {
//              $element = $webdriver->findElement(WebDriverBy::xpath("//span[normalize-space()='City']"));
//              $element->click('City');
//
//       });

       $I->clicked(FluentFormsSelectors::selectField);

       $I->fillField(FluentFormsSelectors::mapField(4), '{inputs.address_1.address_line_1}');


       exit();

   }

}