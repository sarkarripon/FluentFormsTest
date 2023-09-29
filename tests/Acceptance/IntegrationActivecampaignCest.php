<?php

namespace Tests\Acceptance;

use Codeception\Attribute\Group;
use Tests\Support\Helper\Acceptance\Integrations\Activecampaign;
use Tests\Support\Helper\Acceptance\Integrations\FieldCustomizer;
use Tests\Support\Helper\Acceptance\Integrations\IntegrationHelper;
use Tests\Support\AcceptanceTester;
use Tests\Support\Factories\DataProvider\DataGenerator;
use Tests\Support\Factories\DataProvider\ShortCodes;
use Tests\Support\Selectors\FieldSelectors;
use Tests\Support\Selectors\FluentFormsSelectors;

class IntegrationActivecampaignCest
{
    use IntegrationHelper, Activecampaign, ShortCodes, DataGenerator, FieldCustomizer;

    public function _before(AcceptanceTester $I): void
    {
        $I->loadDotEnvFile();
        $I->loginWordpress();
    }

    #[Group('Integration')]
    public function test_activecampaign_push_data(AcceptanceTester $I): void
    {
        $pageName = __FUNCTION__ . '_' . rand(1, 100);

        $listOrService = ['ActiveCampaign List' => 'Master Contact List'];
        $customName = [
            'email' => 'Email Address',
            'simpleText' => ['First Name', 'Last Name', 'Organization Name'],
            'phone' => 'Phone Number',
        ];

        // Prepare the form
        $this->prepareForm($I, $pageName, [
            'generalFields' => ['email', 'simpleText', 'phone'],
        ], true, $customName);

        // Configure ActiveCampaign
        $this->configureActivecampaign($I, "ActiveCampaign");

        // Build field mapping
        $fieldMapping = $this->buildArrayWithKey($customName);
//        print_r($fieldMapping);

        // Map ActiveCampaign field
        $this->mapActivecampaignField($I, $fieldMapping, $listOrService);

        // Prepare the page
        $this->preparePage($I, $pageName);

        $fillableDataArr = [
            'Email Address' => 'email',
            'First Name' => 'firstName',
            'Last Name' => 'lastName',
            'Phone Number' => 'phoneNumber',
            'Organization Name' => 'company',
        ];

        // Generate fake data
        $fakeData = $this->generatedData($fillableDataArr);

        // Fill the form with fake data
        foreach ($fakeData as $selector => $value) {
            $I->tryToFilledField(FluentFormsSelectors::fillAbleArea($selector), $value);
        }

        // Submit the form
        $I->clicked(FieldSelectors::submitButton);

        // Fetch ActiveCampaign data
        $remoteData = $this->fetchActivecampaignData($I, $fakeData['Email Address']);

        // Retry to submit the form again if data not found
        if (empty($remoteData['contacts'])) {
            $I->amOnPage('/' . $pageName);

            $fakeData = $this->generatedData($fillableDataArr);

            // Fill the form with fake data
            foreach ($fakeData as $selector => $value) {
                $I->tryToFilledField(FluentFormsSelectors::fillAbleArea($selector), $value);
            }

            // Submit the form
            $I->clicked(FieldSelectors::submitButton);

            // Fetch ActiveCampaign data again
            $remoteData = $this->fetchActivecampaignData($I, $fakeData['Email Address']);
        }

        if (!empty($remoteData)) {
            $I->checkValuesInArray($remoteData, [
                $fakeData['Email Address'],
                $fakeData['First Name'],
                $fakeData['Last Name'],
                $fakeData['Phone Number'],
            ]);
            echo " Hurray.....! Data found in ActiveCampaign";
        }else{
            $I->fail("Could not fetch data from ActiveCampaign");
        }
    }
}
