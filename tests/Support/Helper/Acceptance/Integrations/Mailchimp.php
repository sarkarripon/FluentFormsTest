<?php

namespace Tests\Support\Helper\Acceptance\Integrations;

use GuzzleHttp\Exception\ClientException;
use MailchimpMarketing\ApiClient;
use Tests\Support\Helper\Pageobjects;
use Tests\Support\Selectors\FluentFormsSelectors;
use Tests\Support\Selectors\FluentFormsSettingsSelectors;

class Mailchimp extends Pageobjects
{
    public function configureMailchimp($integrationPositionNumber): void
    {
        $general = new General($this->I);
        $general->initiateIntegrationConfiguration($integrationPositionNumber);

        if ($integrationPositionNumber == 8) {
            $saveSettings = $this->I->checkElement(FluentFormsSettingsSelectors::APIDisconnect);

            if (!$saveSettings) // Check if the Mailchimp integration is already configured.
            {
                $this->I->fillByJS(FluentFormsSettingsSelectors::MailchimpApiKeyField, getenv('MAILCHIMP_API_KEY'));
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
        $this->I->seeSuccess('Integration successfully saved');
        $this->I->wait(2);
    }

    public function fetchMailchimpData($email)
    {
        $client = new ApiClient();
        $client->setConfig([
            'apiKey' => getenv('MAILCHIMP_API_KEY'),
            'server' => getenv('MAILCHIMP_SERVER_PREFIX')
        ]);

        $response= null;
        $e = null;

        for ($i=0; $i<5; $i++)
        {
            try {
                $response = $client->lists->getListMember(getenv('MAILCHIMP_AUDIENCE_ID'), hash('md5', $email));
                break;
            } catch (ClientException $e) {
                $this->I->wait(20, 'Mailchimp is taking too long to respond. Trying again...');
            }
        }
        if (isset($e) and $e->getCode() == 404) {
            $this->I->fail('Contact with '.$email.' not found in Mailchimp');
        }

        return $response;
    }

}
