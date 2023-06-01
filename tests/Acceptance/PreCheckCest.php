<?php
namespace Tests\Acceptance;

use Tests\Support\AcceptanceTester;
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
        $I->deleteExistingForms();
        $I->initiateNewForm();

        $requiredField = [
            'generalFields' =>['nameField','emailField','addressField' ,'phoneField'],
        ];
        $I->createFormField($requiredField);

        $I->click(FluentFormsSelectors::saveForm);
        $I->seeText("Success");
        $I->renameForm("Platformly Integration");

        $I->amOnPage(FluentFormsSelectors::fFormPage);
        exit();



        $I->deleteExistingPages();
        $I->createNewPage("Platformly Integration");
        $I->wantTo('Fill the form with sample data');
        $I->amOnUrl($pageUrl);

    }


}
