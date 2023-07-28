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

    public function mapMailchimpFields($otherField=null,array $otherFieldArray=null,string $staticTag=null, array $dynamicTag=null): void
    {
        $general = new General($this->I);
        $general->mapEmailInCommon("Mailchimp Integration");

        if ($otherField == "yes" and !empty($otherField)) {
            $general->mapCommonFields($otherFieldArray);
            }

        $this->I->clickOnText('Select Interest Category');
        $this->I->clickOnText('Authlab');
        $this->I->clickOnText('Select Interest');
        $this->I->clickOnText('fluentforms');

        if ($staticTag=='yes' and !empty($staticTag)) {
            $this->I->fillField(FluentFormsSelectors::mailchimpStaticTag, $staticTag);
        }
        if ($dynamicTag=='yes' and !empty($dynamicTag)) {
            $general->mapDynamicTag('yes',$dynamicTag);
        }

        $this->I->clickWithLeftButton(FluentFormsSelectors::saveFeed);
        $this->I->wait(2);
    }

    public static function fetchMailchimpData(): void
    {
        $client = new ApiClient();
        $client->setConfig([
            'apiKey' => getenv('MAILCHIMP_API_KEY'),
            'server' => getenv('MAILCHIMP_SERVER_PREFIX')
        ]);
        //make hash of email

        $response = $client->lists->getListMember(getenv('MAILCHIMP_AUDIENCE_ID'), "c3a40a9bc1d124295eff3392e897090c");
        print_r($response);
    }
}
