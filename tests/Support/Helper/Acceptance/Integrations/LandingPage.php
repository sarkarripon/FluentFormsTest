<?php

namespace Tests\Support\Helper\Acceptance\Integrations;

use Tests\Support\AcceptanceTester;
use Tests\Support\Selectors\FluentFormsSelectors;

trait LandingPage
{
    use IntegrationHelper;
    public function configureLandingPage(AcceptanceTester $I,$integrationPositionNumber)
    {
        global $landingPageUrl;
        $this->initiateIntegrationConfiguration($I,$integrationPositionNumber);
        $this->takeMeToConfigurationPage($I);
        $I->clickOnText("Landing Page","Conditional Confirmations");
        $I->clicked(FluentFormsSelectors::radioButton("Enable Form Landing Page Mode"));
        $landingPageUrl = $I->retryGrabTextFrom("//span[contains(@class,'url-bar')]");
        $I->clicked(FluentFormsSelectors::saveButton("Save"));
        return $landingPageUrl;

    }

}