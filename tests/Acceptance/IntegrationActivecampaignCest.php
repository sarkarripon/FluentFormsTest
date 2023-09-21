<?php
namespace Tests\Acceptance;

use Codeception\Attribute\Group;
use Tests\Support\Factories\DataProvider\DataGenerator;
use Tests\Support\Helper\Acceptance\Integrations\FieldCustomizer;
use Tests\Support\Helper\Acceptance\Integrations\IntegrationHelper;
use Tests\Support\AcceptanceTester;
use Tests\Support\Factories\DataProvider\ShortCodes;
use Tests\Support\Helper\Acceptance\Integrations\Activecampaign;
use Tests\Support\Selectors\FieldSelectors;
use Tests\Support\Selectors\FluentFormsSelectors;

class IntegrationActivecampaignCest
{
    use IntegrationHelper,Activecampaign,ShortCodes, DataGenerator, FieldCustomizer;
    public function _before(AcceptanceTester $I): void
    {
        $I->loadDotEnvFile(); $I->loginWordpress();
    }

    #[Group('Integration')]
    public function test_activecampaign_push_data(AcceptanceTester $I): void
    {
        $pageName = __FUNCTION__.'_'.rand(1,100);

        $listOrService =['ActiveCampaign List'=>'Master Contact List'];
        $customName=[
            'email'=>'Email Address',
            'simpleText'=>['First Name','Last Name','Organization Name'],
            'phone'=>'Phone Number',
        ];
        $this->prepareForm($I, $pageName, [
            'generalFields' => ['email','simpleText','phone'],
        ],'yes',$customName);

        $this->configureActivecampaign($I, "ActiveCampaign");
        $fieldMapping = $this->buildArrayWithKey($customName);
        print_r($fieldMapping);
        $this->mapActivecampaignField($I,$fieldMapping,$listOrService);
        $this->preparePage($I,$pageName);

        $fillAbleDataArr = [
            'Email Address'=>'email',
            'First Name'=>'firstName',
            'Last Name'=>'lastName',
            'Phone Number'=>'phoneNumber',
            'Organization Name'=>'company',
        ];
        $fakeData = $this->generatedData($fillAbleDataArr);
//        print_r($fakeData);
        foreach ($fakeData as $selector => $value) {
            $I->tryToFilledField(FluentFormsSelectors::fillAbleArea($selector), $value);
        }
        $I->clicked(FieldSelectors::submitButton);
        $remoteData = $this->fetchActivecampaignData($I,$fakeData['Email Address']);
//        print_r($remoteData['contacts']);

        // retry to submit form again if data not found
        if (empty($remoteData['contacts'])){
            $I->amOnPage('/' . $pageName);

            $fakeData = $this->generatedData($fillAbleDataArr);
            foreach ($fakeData as $selector => $value) {
                $I->tryToFilledField(FluentFormsSelectors::fillAbleArea($selector), $value);
            }
            $I->clicked(FieldSelectors::submitButton);
            $remoteData = $this->fetchActivecampaignData($I,$fakeData['Email Address']);
        }
        if (!empty($remoteData['contacts'])) {
            $contact = $remoteData['contacts'][0];
            $email = $contact['email'];
            $firstName = $contact['firstName'];
            $lastName = $contact['lastName'];
            $phone = $contact['phone'];

            $I->assertString([
                $fakeData['Email Address'] => $email,
                $fakeData['First Name'] => $firstName,
                $fakeData['Last Name'] => $lastName,
                $fakeData['Phone Number'] => $phone,
            ]);
        }
    }
}
