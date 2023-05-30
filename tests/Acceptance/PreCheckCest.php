<?php
namespace Tests\Acceptance;

use Tests\Support\AcceptanceTester;
use Tests\Support\Helper\Acceptance\Integrations\Platformly;
use Tests\Support\Helper\Acceptance\Selectors\FormFields;
use Tests\Support\Helper\Acceptance\Selectors\NewFormSelec;

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

        $I->initiateNewForm();

        $requiredField = [
            'generalFields' =>['nameField','emailField','addressField' ,'phoneField', 'timeDate'],
        ];
        $I->createFormField($requiredField);

        $I->click(FormFields::saveForm);
        $I->seeText("Success");
        $I->renameForm("Platformly Integration");

//        $I->deleteExistingPages();
        $I->createNewPage("Signup Form");
        $I->wantTo('Fill the form with sample data');
        $I->amOnUrl($pageUrl);

    }


}
