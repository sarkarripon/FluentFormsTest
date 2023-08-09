<?php

namespace Tests\Support\Helper\Acceptance\Integrations;

use Google\Exception;
use Google_Client;
use Google_Service_Sheets;
use Tests\Support\Helper\Pageobjects;
use Tests\Support\Selectors\FluentFormsSelectors;
use Tests\Support\Selectors\FluentFormsSettingsSelectors;

class Googlesheet extends Pageobjects
{

    public function mapGoogleSheetField(array $otherFieldArray): void
    {
        $this->I->waitForElement(FluentFormsSelectors::feedName, 30);
        $this->I->fillField(FluentFormsSelectors::feedName, 'Google Sheets');
        $this->I->fillField(FluentFormsSelectors::spreadSheetID, getenv("GOOGLE_SPREADSHEET_ID"));
        $this->I->fillField(FluentFormsSelectors::workSheetName, getenv("GOOGLE_SHEET_NAME"));

        global $fieldCounter;
        $fieldCounter = 1;
        $counter = 1;
        foreach ($otherFieldArray as $fieldLabel => $fieldValue)
        {
            $this->I->fillField(FluentFormsSelectors::fieldLabel($counter), $fieldLabel);
            $this->I->fillField(FluentFormsSelectors::fieldValue($counter), $fieldValue);
            $this->I->clicked(FluentFormsSelectors::addMappingField('Spreadsheet Fields',$counter));
            $counter++;
            $fieldCounter++;
        }
        $this->I->click(FluentFormsSelectors::removeMappingField('Spreadsheet Fields',$fieldCounter));
        $this->I->click(FluentFormsSelectors::saveFeed);
    }
    public function configureGoogleSheet($integrationPositionNumber): void
    {
        $general = new General($this->I);
        $general->initiateIntegrationConfiguration($integrationPositionNumber);

        if ($integrationPositionNumber == 25) {
            $saveSettings = $this->I->checkElement(FluentFormsSettingsSelectors::APIDisconnect);

            if ($saveSettings) // Check if the Google sheet integration is already configured.
            {
                $general->configureApiSettings("Google");
            }else{
                $this->I->fail('Please connect the Google sheet integration manually.');
            }

        }

    }

    /**
     * @throws Exception
     */
    public function fetchGoogleSheetData(string $emailToSearch): array
    {
        for ($i = 0; $i < 8; $i++) {
            $expectedRow = $this->fetchData($emailToSearch);
            if (empty($expectedRow)) {
                $this->I->wait(60, 'Spreadsheet is taking too long to respond. Trying again...');
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
