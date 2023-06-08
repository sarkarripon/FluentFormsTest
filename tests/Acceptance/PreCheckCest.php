<?php
namespace Tests\Acceptance;

use Tests\Support\AcceptanceTester;
use Tests\Support\Selectors\FluentFormsAddonsSelectors;
use Tests\Support\Selectors\FluentFormsSelectors;
use Tests\Support\Selectors\FormFields;
use Tests\Support\Selectors\GlobalPageSelec;
use Tests\Support\Helper\Acceptance\Platformly;

class PreCheckCest
{
    public function _before(AcceptanceTester $I): void
    {
        $I->wpLogin();
    }

    public function PullData(Platformly $I)
    {
        $allData = json_decode($I->platformlyData("etlldnkbtzp@internetkeno.com"));
        echo $allData->first_name;

    }

    public function formcr(AcceptanceTester $I)
    {
        global $pageUrl;
        $formName = 'Platformly Integration';

        $I->deleteExistingForms();
        exit();
        $I->initiateNewForm();

        $requiredField = [
            'generalFields' =>['nameField','emailField','addressField' ,'phoneField'],
        ];
        $I->createFormField($requiredField);

        $I->click(FluentFormsSelectors::saveForm);
        $I->seeText("Success");
        $I->renameForm($formName);
        $I->wait(2);
        $I->configureIntegration('12','4XIamp9fiLokeugrcmxSLMQjoRyXyStw','2919');
//        $I->amOnPage("wp-admin/admin.php?page=fluent_forms&form_id=478&route=settings&sub_route=form_settings#/all-integrations/0/platformly");
        $I->waitForElement(FluentFormsSelectors::feedName,5);
        $I->fillField(FluentFormsSelectors::feedName,'Platformly Integration',2);
        $I->wait(2);
        $I->clicked(FluentFormsSelectors::plarformlySegmentDropDown);
        $I->clicked(FluentFormsSelectors::plarformlySegment);
        $I->wait(2);
        $I->clicked(FluentFormsSelectors::mapEmailDropdown);
        $I->clicked(FluentFormsSelectors::mapEmail);
        $I->fillField(FluentFormsSelectors::mapField(1),'{inputs.names.first_name}');
        $I->fillField(FluentFormsSelectors::mapField(2),'{inputs.names.last_name}');
        $I->fillField(FluentFormsSelectors::mapField(3),'{inputs.phone}');
        $I->clickWithLeftButton(FluentFormsSelectors::saveFeed);

        $I->deleteExistingPages();
        $I->createNewPage("Platformly Integration");
        $I->wantTo('Fill the form with sample data');
        $I->amOnUrl($pageUrl);

    }


}
