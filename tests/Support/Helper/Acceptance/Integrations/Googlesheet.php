<?php

namespace Tests\Support\Helper\Acceptance\Integrations;

use Google\Exception;
use Google_Client;
use Google_Service_Sheets;
use Tests\Support\Helper\Pageobjects;
use Tests\Support\Selectors\FluentFormsSettingsSelectors;

class Googlesheet extends Pageobjects
{

    public function configureGoogleSheet($integrationPositionNumber): void
    {
        $general = new General($this->I);
        $general->initiateIntegrationConfiguration($integrationPositionNumber);

        if ($integrationPositionNumber == 25) {
            $saveSettings = $this->I->checkElement(FluentFormsSettingsSelectors::APIDisconnect);

            if (!$saveSettings) // Check if the Google sheet integration is already configured.
            {
                $this->I->reloadIfElementNotFound(FluentFormsSettingsSelectors::googleSheetAccessCodeField);
                $this->I->click(FluentFormsSettingsSelectors::getAccessCode);
                $this->I->switchToNextTab();
                $this->I->filledField(FluentFormsSettingsSelectors::googleUserEmail, getenv("GOOGLE_USER"));

                $this->I->clicked(FluentFormsSettingsSelectors::googleNext);
                $this->I->filledField(FluentFormsSettingsSelectors::googlePass, getenv("GOOGLE_PASSWORD"));
                $this->I->clicked(FluentFormsSettingsSelectors::googleNext);

                $this->I->clicked(FluentFormsSettingsSelectors::googleContinue);
                $accessKey = $this->I->grabTextFrom(FluentFormsSettingsSelectors::grabCode);
                $this->I->switchToPreviousTab();
                $this->I->fillField(FluentFormsSettingsSelectors::googleSheetAccessCodeField, $accessKey);
                $this->I->clicked(FluentFormsSettingsSelectors::APISaveButton);

//                $this->I->seeSuccess('Your google sheet api key has been verfied and successfully set');

            }
            $general->configureApiSettings("Google");
        }

    }

    /**
     * @throws Exception
     */
    public function fetchGoogleSheetData(string $emailToSearch): array
    {
        for ($i = 0; $i < 5; $i++) {
            $expectedRow = $this->fetchData($emailToSearch);
            if (empty($expectedRow)) {
                $this->I->wait(3, 'Spreadsheet is taking too long to respond. Trying again...');
            }else{
                break;
            }
        }
        if (empty($expectedRow)) {
            $this->I->fail('The row with the email address ' . $emailToSearch . ' was not found in the spreadsheet.');
        }
        return $expectedRow;

    }
    /**
     * @throws Exception
     */
    public function fetchData(string $emailToSearch): array
    {
        $client = new Google_Client();
        $client->setApplicationName('Google Sheets API PHP');
        $client->setScopes(Google_Service_Sheets::SPREADSHEETS_READONLY);
        $client->setAuthConfig('tests/Support/Data/googlesheet.json'); // Path to the JSON credentials

        $service = new Google_Service_Sheets($client);
        $response = $service->spreadsheets_values->get(getenv("GOOGLE_SPREADSHEET_ID"), getenv("GOOGLE_SHEET_NAME_AND_RANGE"));
        $values = $response->getValues();

        $expectedRow = [];

        foreach ($values as $row) {
            if ($row[0] === $emailToSearch || $row[1] === $emailToSearch || $row[2] === $emailToSearch) {
                $expectedRow = $row;
            }
        }
        return $expectedRow;
    }
}
