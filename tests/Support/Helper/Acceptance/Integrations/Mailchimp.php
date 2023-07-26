<?php

namespace Tests\Support\Helper\Acceptance\Integrations;

use MailchimpMarketing\ApiClient;
use Tests\Support\Helper\Pageobjects;
use Tests\Support\Selectors\FluentFormsSelectors;
use Tests\Support\Selectors\FluentFormsSettingsSelectors;

class Mailchimp extends Pageobjects
{
    public function configureMailchimp($integrationPositionNumber, $api): void
    {
        $general = new General($this->I);
        $general->initiateIntegrationConfiguration($integrationPositionNumber);

        if ($integrationPositionNumber == 8) {
            $saveSettings = $this->I->checkElement(FluentFormsSettingsSelectors::APIDisconnect);

            if (!$saveSettings) // Check if the Mailchimp integration is already configured.
            {
                $this->I->waitForElement(FluentFormsSettingsSelectors::MailchimpApiKey, 5);
                $this->I->fillField(FluentFormsSettingsSelectors::MailchimpApiKey, $api);
                $this->I->clicked(FluentFormsSettingsSelectors::APISaveButton);
            }
            $general->configureApiSettings("Mailchimp");
        }
    }

    public function mapMailchimpFields($otherField,$otherFieldArray): void
    {
        $general = new General($this->I);
        $general->mapEmailInCommon("Mailchimp Integration");

        if ($otherField == "yes" and !empty($otherField)) {
            foreach ($otherFieldArray as $field => $value) {
                $this->I->fillField(FluentFormsSelectors::mailchimpFormField($field), $value);
            }


        }
        $this->I->clickWithLeftButton(FluentFormsSelectors::saveFeed);
        $this->I->wait(2);


    }

    public static function fetchMailchimpData(): void
    {
        $client = new ApiClient();
        $client->setConfig([
            'apiKey' => 'eadd373e53ebf26180ea284112909140-us21',
            'server' => 'us21',
        ]);

        $response = $client->lists->getListMember("9fb11faf47", "2f7b11e9b8b489dfdc015a3e87659e0c");
        print_r($response);
    }
}
