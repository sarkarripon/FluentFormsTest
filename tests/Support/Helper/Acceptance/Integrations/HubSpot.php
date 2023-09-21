<?php

namespace Tests\Support\Helper\Acceptance\Integrations;

use Tests\Support\AcceptanceTester;
use Tests\Support\Selectors\FluentFormsSelectors;
use Tests\Support\Selectors\FluentFormsSettingsSelectors;

trait HubSpot
{

    public function configureHubSpot(AcceptanceTester $I, string $integrationName)
    {
        $this->turnOnIntegration($I,$integrationName);
        $isSaveSettings = $I->checkElement(FluentFormsSettingsSelectors::APIDisconnect);
        if (!$isSaveSettings)
        {
            $I->filledField(FluentFormsSettingsSelectors::apiField('Hubspot Access Token'), getenv('HUBSPOT_ACCESS_TOKEN'));

            $I->clicked(FluentFormsSettingsSelectors::APISaveButton);
            $I->seeSuccess("Success");
        }
        $this->configureApiSettings($I,"HubSpot");
    }

    public function mapHubSpotFields(AcceptanceTester $I, array $fieldMapping, array $listOrService = null)
    {
        $this->mapEmailInCommon($I,"HubSpot Integration");
        $this->assignShortCode($I,$fieldMapping,'Map Fields');

        $I->clickWithLeftButton(FluentFormsSelectors::saveButton("Save Feed"));
        $I->seeSuccess('Integration successfully saved');
        $I->wait(1);
    }

    public function fetchHubSpotData(AcceptanceTester $I, string $searchTerm)
    {
        for ($i = 0; $i < 8; $i++) {
            $remoteData = $this->fetchData($searchTerm);
            if (empty($remoteData)) {
                $I->wait(30, 'Hubspot is taking too long to respond. Trying again...');
            } else {
                break;
            }
        }
        return $remoteData;
    }

    public function fetchData(string $searchTerm)
    {
        $accessToken = getenv('HUBSPOT_ACCESS_TOKEN');
        $url = "https://api.hubapi.com/crm/v3/objects/contacts";

        $curl = curl_init($url);

        curl_setopt($curl, CURLOPT_HTTPHEADER, [
            'authorization: Bearer ' . $accessToken,
        ]);
        curl_setopt($curl, CURLOPT_RETURNTRANSFER, true);

        $response = curl_exec($curl);

        if (curl_errno($curl)) {
            echo 'cURL Error: ' . curl_error($curl);
            return null;
        }

        curl_close($curl);

        $data = json_decode($response, true);

        if (isset($data['status']) && $data['status'] === 'error') {
            echo 'API Error: ' . $data['message'];
            return null;
        }
        foreach ($data['results'] as $subscriber) {
            if (isset($subscriber['properties']['email']) && $subscriber['properties']['email'] === $searchTerm) {
                return $subscriber;
            }
        }
        return null;
    }
}