<?php
namespace Tests\Acceptance;

use Codeception\Example;
use Tests\Support\AcceptanceTester;
use Tests\Support\Factories\DataProvider\FormData;
use Tests\Support\Helper\Acceptance\IntegrationHelper as Integration;
use Tests\Support\Selectors\FieldSelectors;

class PreCheckCest
{
    use Integration;
    public function _before(AcceptanceTester $I): void
    {
        $I->wpLogin();
    }

    public function PullData()
    {
        $allData = json_decode($this->fetchPlatformlyData("etlldnkbtzp@internetkeno.com"));
        echo $allData->first_name;
    }


    /**
     * @dataProvider \Tests\Support\Factories\DataProvider\FormData::fieldData
     */
    public function formcr(AcceptanceTester $I, Example $example)
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
//        $I->configureIntegration('12','4XIamp9fiLokeugrcmxSLMQjoRyXyStw','2919');
//
//        $I->mapPlatformlyFields();
//
//        $I->deleteExistingPages();
//        $I->createNewPage($formName);
//        $I->wantTo('Fill the form with sample data');
//        $I->amOnUrl($pageUrl);
        $I->amOnPage('platformly-integration/');
        $I->wait(1);
        $I->fillField(FieldSelectors::first_name, ($example['first_name']));
        $I->fillField(FieldSelectors::last_name, ($example['last_name']));
        $I->fillField(FieldSelectors::email, ($example['email']));
        $I->fillField(FieldSelectors::address_line_1, ($example['address_line_1']));
        $I->fillField(FieldSelectors::address_line_2, ($example['address_line_2']));
        $I->fillField(FieldSelectors::city, ($example['city']));
        $I->fillField(FieldSelectors::state, ($example['state']));
        $I->fillField(FieldSelectors::zip, ($example['zip']));
        $I->selectOption(FieldSelectors::country, ($example['country']));
        $I->fillField(FieldSelectors::phone, ($example['phone']));
        $I->click(FieldSelectors::submitButton);



        exit();

    }


}
