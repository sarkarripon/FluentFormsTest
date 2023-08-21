<?php

namespace Tests\Support\Helper\Acceptance\Integrations;

use Tests\Support\AcceptanceTester;
use Tests\Support\Selectors\FluentFormsSelectors;

trait Webhook
{
    use IntegrationHelper;

    public function configureWebhook(AcceptanceTester $I, $integrationPositionNumber): void
    {
        $webhookUrl ="https://webhook.site/".getenv("WEBHOOK");
        $this->initiateIntegrationConfiguration($I,$integrationPositionNumber);
        $this->takeMeToConfigurationPage($I);
        $I->clickOnText("WebHook","Conditional Confirmations");
        $I->clickOnText("Add New","WebHooks Integration");
        $I->filledField("//input[@placeholder='WebHook Feed Name']","Webhook");
        $I->filledField("//input[@placeholder='WebHook URL']",$webhookUrl);
        $I->clicked(FluentFormsSelectors::saveButton("Save Feed"));

    }
    public function fetchWebhookData(AcceptanceTester $I, array $texts): void
    {
        $maxRetries = 5;
        $retryDelay = 10;
        for ($i = 0; $i < $maxRetries; $i++) {
            if ($this->fetchData($I, $texts)) {
                echo "Webhook data fetched successfully!";
                return;
            } else {
                $I->wait($retryDelay);
            }
        }
        $I->fail("Failed to fetch webhook data after {$maxRetries} attempts.");
    }
    public function fetchData(AcceptanceTester $I, array $texts): bool
    {
        $I->amOnUrl("https://webhook.site/#!/".getenv('WEBHOOK'));
        try {
            $I->seeText($texts);
            return true;
        } catch (\Exception $e) {
            return false;
        }
    }


}