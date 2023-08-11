<?php

namespace Tests\Support\Helper\Acceptance\Integrations;

use Tests\Support\AcceptanceTester;
use Tests\Support\Helper\Pageobjects;
use Tests\Support\Selectors\FluentFormsSelectors;
use Tests\Support\Selectors\FluentFormsSettingsSelectors;

trait Activecampaign
{
    use IntegrationHelper;

    public function mapActivecampaignField(AcceptanceTester $I, array $otherFieldArray=null): void
    {
        $this->mapEmailInCommon($I, "Activecampaign Integration");
        if (isset($otherFieldArray) and !empty($otherFieldArray))
        {
            foreach ($otherFieldArray as $fieldLabel => $fieldValue)
            {
                $I->fillField(FluentFormsSelectors::commonFields($fieldLabel,'Select a Field or Type Custom value'), $fieldValue);

            }
        }
        $I->clicked(FluentFormsSelectors::saveFeed);

    }

    public function configureActivecampaign(AcceptanceTester $I, $integrationPositionNumber): void
    {
        $this->initiateIntegrationConfiguration($I,$integrationPositionNumber);

        $activecampaignPosition = 11;

        if ($integrationPositionNumber === $activecampaignPosition) {
            $isConfigured = $I->checkElement(FluentFormsSettingsSelectors::APIDisconnect);

            if (!$isConfigured) {
                $I->fillField(
                    FluentFormsSelectors::commonFields("ActiveCampaign API URL", "API URL"),
                    getenv("ACTIVECAMPAIGN_API_URL")
                );
                $I->fillField(
                    FluentFormsSelectors::commonFields("ActiveCampaign API Key", "API Key"),
                    getenv("ACTIVECAMPAIGN_API_KEY")
                );
                $I->clicked(FluentFormsSettingsSelectors::APISaveButton);
            }
            $this->configureApiSettings($I, "ActiveCampaign");
        }

    }
    public function fetchActivecampaignData(AcceptanceTester $I, string $emailToFetch)
    {
        for ($i = 0; $i < 8; $i++) {
            $remoteData = $this->fetchData($emailToFetch);
            if (empty($remoteData['contacts'])) {
                $I->wait(60, 'Activecampaign is taking too long to respond. Trying again...');
            } else {
                break;
            }
        }

        if (empty($remoteData['contacts'])) {
            $I->fail('Data not found for the search term: ' . $emailToFetch);
        }
        return $remoteData;
    }
    public function fetchData(string $emailToFetch)
    {
        $apiUrl = getenv("ACTIVECAMPAIGN_API_URL").'/api/3/contacts';

        $ch = curl_init();
        curl_setopt($ch, CURLOPT_URL, $apiUrl . '?email=' . urlencode($emailToFetch));
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
        curl_setopt($ch, CURLOPT_HTTPHEADER, [
            'Api-Token: ' . getenv("ACTIVECAMPAIGN_API_KEY"),
        ]);
        $response = curl_exec($ch);

        if (curl_errno($ch)) {
            echo 'cURL error: ' . curl_error($ch);
        }
        curl_close($ch);
        return json_decode($response, true);

    }

}