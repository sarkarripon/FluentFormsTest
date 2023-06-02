<?php
namespace Tests\Acceptance;

use Tests\Support\AcceptanceTester;
use Tests\Support\Selectors\FluentFormsAddonsSelectors;
use Tests\Support\Selectors\FluentFormsSelectors;
use Tests\Support\Selectors\FormFields;
use Tests\Support\Selectors\GlobalPageSelec;

class PreCheckCest
{
    public function _before(AcceptanceTester $I): void
    {
        $I->wpLogin();
    }

//    public function PullData(Platformly $I)
//    {
//        $allData = json_decode($I->platformlyData("etlldnkbtzp@internetkeno.com"));
//        echo $allData->first_name;
//
//    }

    public function formcr(AcceptanceTester $I)
    {
        global $pageUrl;
        $formName = 'Platformly Integration';

//        $I->deleteExistingForms();
//        $I->initiateNewForm();
//
//        $requiredField = [
//            'generalFields' =>['nameField','emailField','addressField' ,'phoneField'],
//        ];
//        $I->createFormField($requiredField);
//
//        $I->click(FluentFormsSelectors::saveForm);
//        $I->seeText("Success");
//        $I->renameForm($formName);
//        $I->wait(2);
        $I->amOnPage(FluentFormsAddonsSelectors::integrationsPage);
//        $I->clickWithLeftButton(FluentFormsAddonsSelectors::turnOnIntegration(12));
        $I->integrationConfigurationSettings('12');


        exit();
        $I->amOnPage(FluentFormsSelectors::fFormPage);
        $I->wait(2);
        $I->moveMouseOver(FluentFormsSelectors::mouseHoverMenu);
        $I->clicked(FluentFormsSelectors::formSettings);
        $I->clicked(FluentFormsSelectors::allIntegrations);
        $I->clicked(FluentFormsSelectors::addNewIntegration);
        $I->moveMouseOver(FluentFormsSelectors::searchIntegration);
        $I->fillField(FluentFormsSelectors::searchIntegration,'Platformly');
        $I->clicked(FluentFormsSelectors::searchResult);





        exit();



        $I->deleteExistingPages();
        $I->createNewPage("Platformly Integration");
        $I->wantTo('Fill the form with sample data');
        $I->amOnUrl($pageUrl);

    }


}
