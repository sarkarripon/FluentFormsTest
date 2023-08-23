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

    public function mapUserRegistrationField(AcceptanceTester $I, array $otherFieldArray, array $extraListOrService=null): void
    {
        $this->mapEmailInCommon($I,"User Registration",$extraListOrService);
        $this->mapCommonFieldsWithLabel($I,$otherFieldArray,'Select a Field or Type Custom value');
        $I->clickWithLeftButton(FluentFormsSelectors::saveButton("Save Feed"));


    }
}