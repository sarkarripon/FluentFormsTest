<?php
namespace Tests\Support\Helper\Acceptance\Integrations;

use Tests\Support\Helper\Pageobjects;
use Tests\Support\Selectors\FluentFormsAddonsSelectors;
use Tests\Support\Selectors\FluentFormsSelectors;
use Tests\Support\Selectors\FluentFormsSettingsSelectors;

class Platformly extends Pageobjects
{

    public function mapPlatformlyFields(): void
    {
        global $tags;
        $this->I->waitForElement(FluentFormsSelectors::feedName,20);
        $this->I->fillField(FluentFormsSelectors::feedName,'Platformly Integration');

        $this->I->clicked(FluentFormsSelectors::plarformlySegmentDropDown);
        $this->I->clicked(FluentFormsSelectors::plarformlySegment);

        $this->I->clicked(FluentFormsSelectors::mapEmailDropdown);
        $this->I->clicked(FluentFormsSelectors::mapEmail);
        $this->I->fillField(FluentFormsSelectors::mapField(1),'{inputs.names.first_name}');
        $this->I->fillField(FluentFormsSelectors::mapField(2),'{inputs.names.last_name}');
        $this->I->fillField(FluentFormsSelectors::mapField(3),'{inputs.phone}');

        $otherFieldsArray = [
            2=>'{inputs.address_1.address_line_1}',
            3=>'{inputs.address_1.address_line_2}',
            4=>'{inputs.address_1.city}',
            5=>'{inputs.address_1.state}',
            6=>'{inputs.address_1.zip}',
            7=>'{inputs.address_1.country}',
        ];
        $counter = 1;
        foreach ($otherFieldsArray as $fieldValuePosition => $fieldValue) {
            $this->I->clicked(FluentFormsSelectors::openFieldLabel($counter));

            try {
                $this->I->executeJS(FluentFormsSelectors::jsForFieldLabelFromTop($fieldValuePosition));
            }catch (\Exception $e){
                $this->I->executeJS(FluentFormsSelectors::jsForFieldLabelFromBottom($fieldValuePosition));
                echo $e->getMessage();
            }

            $this->I->fillField(FluentFormsSelectors::fieldValue($counter), $fieldValue);
            $this->I->clicked(FluentFormsSelectors::addField($counter));
            $counter++;
        }

        $this->I->clicked(FluentFormsSelectors::contactTag);
        $this->I->clickByJS("//span[normalize-space()='$tags[0]']");
        $this->I->clickByJS("//span[normalize-space()='$tags[1]']");


        $this->I->clickWithLeftButton(FluentFormsSelectors::saveFeed);
        $this->I->wait(2);
    }


    public function configurePlatformlyApiSettings($searchKey): void
    {
        $this->I->amOnPage(FluentFormsSelectors::fFormPage);
        $this->I->waitForElement(FluentFormsSelectors::mouseHoverMenu,10);
        $this->I->moveMouseOver(FluentFormsSelectors::mouseHoverMenu);
        $this->I->clicked(FluentFormsSelectors::formSettings);
        $this->I->clicked(FluentFormsSelectors::allIntegrations);
        $this->I->clicked(FluentFormsSelectors::addNewIntegration);
        $this->I->fillField(FluentFormsSelectors::searchIntegration,$searchKey);
        $this->I->clicked(FluentFormsSelectors::searchResult);

    }

    /**
     *
     * [!] This is the positions of the integrations in the list.
     * Use the position number to turn on the integration.
     *
     * * User Registration or Update = 1
     * * Landing Pages = 2
     * * Quiz Module = 3
     * * Inventory Module = 4
     * * Post/CPT Creation = 5
     * * Webhooks = 6
     * * Zapier = 7
     * * Mailchimp = 8
     * * Campaign Monitor = 9
     * * GetResponse = 10
     * * ActiveCampaign = 11
     * * Platformly = 12
     * * Trello = 13
     * * Drip = 14
     * * Sendinblue = 15
     * * Zoho = 16
     * * iContact = 17
     * * MooSend = 18
     * * SendFox = 19
     * * ConvertKit = 20
     * * Twilio = 21
     * * ClickSend = 22
     * * Constant Contact = 23
     * * HubSpot = 24
     * * Google Sheets = 25
     * * PipeDrive = 26
     * * MailerLite = 27
     * * GitGist = 28
     * * CleverReach = 29
     * * Salesforce = 30
     * * AmoCRM = 31
     * * OnePageCRM = 32
     * * Airtable = 33
     * * Mailjet = 34
     * * Insightly = 35
     * * Mailster = 36
     * * Automizy = 37
     * * Salesflare = 38
     * * Telegram = 39
     * * Discord = 40
     * * Slack = 41
     *
     *
     *
     * @param $integrationPositionNumber
     * @param $api
     * @param $projectID
     * @return void
     */

    public function configureIntegration($integrationPositionNumber, $api, $projectID): void
    {
        $this->I->amOnPage(FluentFormsAddonsSelectors::integrationsPage);

        $element = $this->I->checkElement("(//div[@class='ff_card_footer'])[{$integrationPositionNumber}]//i[@class='el-icon-setting']");

        if (!$element)
        {
            $this->I->clickWithLeftButton("(//span[@class='el-switch__core'])[{$integrationPositionNumber}]");
        }

        $this->I->clickWithLeftButton("(//DIV[@class='ff_card_footer_group'])[{$integrationPositionNumber}]//I[@class='el-icon-setting']");


        if($integrationPositionNumber == 12)
        {
            $saveSettings = $this->I->checkElement(FluentFormsSettingsSelectors::disconnectPlatformly);

            if (!$saveSettings) // Check if the platformly integration is already configured.
            {
                $this->I->waitForElement(FluentFormsSettingsSelectors::platformlyApiKey,5);
                $this->I->fillField(FluentFormsSettingsSelectors::platformlyApiKey,$api);
                $this->I->waitForElement(FluentFormsSettingsSelectors::platformlyProjectID,5);
                $this->I->fillField(FluentFormsSettingsSelectors::platformlyProjectID,$projectID);
                $this->I->clicked(FluentFormsSettingsSelectors::platformlySaveButton);
            }
            $this->configurePlatformlyApiSettings("Platformly");
        }

    }
    public function fetchDataFromPlatformly($api, $email): string
    {
        $curl = curl_init();
        curl_setopt_array($curl, array(
            CURLOPT_URL => 'https://api.platform.ly',
            CURLOPT_RETURNTRANSFER => true,
            CURLOPT_ENCODING => '',
            CURLOPT_MAXREDIRS => 10,
            CURLOPT_TIMEOUT => 0,
            CURLOPT_FOLLOWLOCATION => true,
            CURLOPT_HTTP_VERSION => CURL_HTTP_VERSION_1_1,
            CURLOPT_CUSTOMREQUEST => 'POST',
            CURLOPT_POSTFIELDS => 'api_key='.$api.'&action=fetch_contact&value={"email":"' . $email . '"}',
            CURLOPT_HTTPHEADER => array(
                'Content-Type: application/x-www-form-urlencoded'
            ),
        ));
        $response = curl_exec($curl);
        curl_close($curl);

        return $response;

    }





}

