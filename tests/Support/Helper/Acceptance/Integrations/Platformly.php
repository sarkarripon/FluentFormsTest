<?php
namespace Tests\Support\Helper\Acceptance\Integrations;

use Tests\Support\Helper\Pageobjects;
use Tests\Support\Selectors\FluentFormsAddonsSelectors;
use Tests\Support\Selectors\FluentFormsSelectors;
use Tests\Support\Selectors\FluentFormsSettingsSelectors;

class Platformly extends Pageobjects
{

    public function mapPlatformlyFields(string $optionalField=null, array $otherFields=[], array $staticTag=[], array $dynamicTag=[], array $conditionalLogic=[], string $conditionState=null): void
    {
        $general = new General($this->I);
        $general->mapEmailInCommon("Platformly Integration");

        if (isset($optionalField) and !empty($optionalField)){
            $optionalFieldArr = [
                'First Name' => '{inputs.names.first_name}',
                'Last Name' => '{inputs.names.last_name}',
                'Phone Number' => '{inputs.phone}',
            ];
            foreach ($optionalFieldArr as $key => $value) {
                $this->I->fillByJS(FluentFormsSelectors::commonFields($key),$value);
            }
        }

        if (isset($otherFields) and !empty($otherFields))
        {
            $counter = 1;
            foreach ($otherFields as $fieldValuePosition => $fieldValue)
            {
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
        }

        if (isset($staticTag) and !empty($staticTag)){
            $this->I->clicked(FluentFormsSelectors::contactTag);
            foreach ($staticTag as $tag)
            {
                $this->I->clickByJS("//span[normalize-space()='$tag']");
            }
        }

        if (isset($dynamicTag) and !empty($dynamicTag))
        {
            $this->I->clicked(FluentFormsSelectors::enableDynamicTag);

            $general->mapDynamicTag('yes',$dynamicTag);

//            global $dynamicTagField;
//            $dynamicTagField = 1;
//            $dynamicTagValue = 1;
//            foreach ($dynamicTag as $key => $value)
//            {
//                $this->I->clicked(FluentFormsSelectors::setTag($dynamicTagField));
//                $this->I->clickOnText($key);
//
//                $this->I->click(FluentFormsSelectors::ifClause($dynamicTagValue));
//                $this->I->clickOnText($value[0]);
//
//                $this->I->click(FluentFormsSelectors::ifClause($dynamicTagValue+1));
//                $this->I->clickOnText($value[1]);
//
//                $this->I->fillField(FluentFormsSelectors::dynamicTagValue($dynamicTagField),$value[2]);
//                $this->I->click(FluentFormsSelectors::addDynamicTagField($dynamicTagField));
//                $dynamicTagField++;
//                $dynamicTagValue+=2;
//            }
//            $this->I->click(FluentFormsSelectors::removeDynamicTagField($dynamicTagField));
        }

        if(isset($conditionalLogic) and !empty($conditionalLogic))
        {
            if(!$this->I->checkElement(FluentFormsSelectors::conditionalLogicChecked))
            {
                $this->I->clicked(FluentFormsSelectors::conditionalLogicUnchecked);
            }
                if (isset($conditionState) and !empty($conditionState))
                {
                    $this->I->selectOption(FluentFormsSelectors::selectNotificationOption,$conditionState);
                }
            global $fieldCounter;
            $fieldCounter = 1;
            $labelCounter = 1;
            foreach ($conditionalLogic as $key => $value)
            {
                $this->I->click(FluentFormsSelectors::openConditionalFieldLabel($labelCounter));
                $this->I->clickOnText($key);

                $this->I->click(FluentFormsSelectors::openConditionalFieldLabel($labelCounter+1));
                $this->I->clickOnText($value[0]);

                $this->I->fillField(FluentFormsSelectors::conditionalFieldValue($fieldCounter),$value[1]);
                $this->I->click(FluentFormsSelectors::addConditionalField($fieldCounter));
                $fieldCounter++;
                $labelCounter+=2;
            }
            $this->I->click(FluentFormsSelectors::removeConditionalField($fieldCounter));
        }

        $this->I->clickWithLeftButton(FluentFormsSelectors::saveFeed);
        $this->I->wait(2);
    }
//    public function configurePlatformlyApiSettings($searchKey): void
//    {
//        $this->I->amOnPage(FluentFormsSelectors::fFormPage);
//        $this->I->waitForElement(FluentFormsSelectors::mouseHoverMenu,10);
//        $this->I->moveMouseOver(FluentFormsSelectors::mouseHoverMenu);
//        $this->I->clicked(FluentFormsSelectors::formSettings);
//        $this->I->clicked(FluentFormsSelectors::allIntegrations);
//        $this->I->clicked(FluentFormsSelectors::addNewIntegration);
//        $this->I->fillField(FluentFormsSelectors::searchIntegration,$searchKey);
//        $this->I->clicked(FluentFormsSelectors::searchResult);
//
//    }

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
     * @return void
     */

    public function configurePlatformly($integrationPositionNumber): void
    {
        $general = new General($this->I);
        $general->initiateIntegrationConfiguration($integrationPositionNumber);

        if($integrationPositionNumber == 12)
        {
            $saveSettings = $this->I->checkElement(FluentFormsSettingsSelectors::APIDisconnect);

            if (!$saveSettings) // Check if the platformly integration is already configured.
            {
                $this->I->waitForElement(FluentFormsSettingsSelectors::PlatformlyApiKey,10);
                $this->I->fillField(FluentFormsSettingsSelectors::PlatformlyApiKeyField,getenv('PLATFORMLY_API_KEY'));
                $this->I->waitForElement(FluentFormsSettingsSelectors::PlatformlyProjectID,5);
                $this->I->fillField(FluentFormsSettingsSelectors::PlatformlyProjectID,getenv('PLATFORMLY_PROJECT_ID'));
                $this->I->clicked(FluentFormsSettingsSelectors::APISaveButton);
            }
            $general->configureApiSettings("Platformly");
        }

    }
    public function fetchPlatformlyData($email): string
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
            CURLOPT_POSTFIELDS => 'api_key='.getenv('PLATFORMLY_API_KEY').'&action=fetch_contact&value={"email":"' . $email . '"}',
            CURLOPT_HTTPHEADER => array(
                'Content-Type: application/x-www-form-urlencoded'
            ),
        ));
        $response = curl_exec($curl);
        curl_close($curl);

        $remoteData = json_decode($response);
        if (property_exists($remoteData, 'status')) {
            for ($i = 0; $i < 8; $i++) {
                $remoteData = json_decode($response);
                if (property_exists($remoteData, 'status')) {
                    $this->I->wait(15,'Platformly is taking too long to respond. Trying again...');
                } else {
                    break;
                }
            }
        }
        if (property_exists($remoteData, 'status')) {
            $this->I->fail('Contact with '.$email.' not found in Platformly');
        }
        return $remoteData;

    }





}

