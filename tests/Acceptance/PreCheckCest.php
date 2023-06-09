<?php
namespace Tests\Acceptance;

use Tests\Support\AcceptanceTester;
use Tests\Support\Helper\Acceptance\IntegrationHelper as Integration;
use Tests\Support\Selectors\FluentFormsAddonsSelectors;
use Tests\Support\Selectors\FluentFormsSelectors;
use Tests\Support\Selectors\FormFields;
use Tests\Support\Selectors\GlobalPageSelec;

class PreCheckCest
{
    use Integration;
    public function _before(AcceptanceTester $I): void
    {
        $I->wpLogin();
    }

    public function PullData()
    {
//        $allData = json_decode($this->platformlyData("etlldnkbtzp@internetkeno.com"));
//        echo $allData->first_name;
    }

    public function formcr(AcceptanceTester $I)
    {
        global $pageUrl;
        $formName = 'Platformly Integration';

//        $I->deleteExistingForms();
//
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
        $I->configureIntegration('12','4XIamp9fiLokeugrcmxSLMQjoRyXyStw','2919');

//        $I->amOnPage("wp-admin/admin.php?page=fluent_forms&form_id=478&route=settings&sub_route=form_settings#/all-integrations/0/platformly");

//        $I->mapPlatformlyFields();
//
//        $I->deleteExistingPages();
//        $I->createNewPage($formName);
//        $I->wantTo('Fill the form with sample data');
//        $I->amOnUrl($pageUrl);
        exit();

    }


}
