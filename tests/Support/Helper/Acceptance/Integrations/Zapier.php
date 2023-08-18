<?php

namespace Tests\Support\Helper\Acceptance\Integrations;

use Tests\Support\AcceptanceTester;
use Tests\Support\Selectors\FluentFormsSelectors;

trait Zapier
{
    use IntegrationHelper;
    public function configureZapier(AcceptanceTester $I, $integrationPositionNumber): void
    {
        $this->initiateIntegrationConfiguration($I,$integrationPositionNumber);
        $this->takeMeToConfigurationPage($I);
        $I->clickOnText("Zapier","Conditional Confirmations");
        $I->clickOnText("Add Webhook","Zapier Integration");
        $I->filledField("(//input[@type='text'])[1]","Zapier");
        $I->filledField("(//input[@type='text'])[2]",getenv("ZAPIER_WEBHOOK_URL"));
        $I->clicked(FluentFormsSelectors::saveFeed);

    }

}