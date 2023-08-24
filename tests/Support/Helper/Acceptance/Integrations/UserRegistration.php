<?php
namespace Tests\Support\Helper\Acceptance\Integrations;
use Tests\Support\AcceptanceTester;
use Tests\Support\Selectors\FluentFormsSelectors;
use Tests\Support\Selectors\FluentFormsSettingsSelectors;

trait UserRegistration
{
    public function configureUserRegistration(AcceptanceTester $I, $integrationPositionNumber): void
    {
        $this->initiateIntegrationConfiguration($I,$integrationPositionNumber);
        $this->configureApiSettings($I,"UserRegistration");
    }

    public function mapUserRegistrationField(AcceptanceTester $I, array $customName, array $extraListOrService=null): void
    {
        $this->mapEmailInCommon($I,"User Registration",$extraListOrService);
        $this->assignShortCode($I,$customName);
        $I->clickWithLeftButton(FluentFormsSelectors::saveButton("Save Feed"));


    }
}