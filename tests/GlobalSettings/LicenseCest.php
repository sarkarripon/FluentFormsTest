<?php


namespace Tests\GlobalSettings;

use Tests\Support\AcceptanceTester;
use Tests\Support\Selectors\GlobalSettingsSelectors;

class LicenseCest
{
    public function _before(AcceptanceTester $I)
    {
        $I->loadDotEnvFile();
        $I->loginWordpress();
    }

    // tests
    public function test_fluent_form_activation_flag_check(AcceptanceTester $I)
    {
        $I->amOnPage(GlobalSettingsSelectors::licensePage);

        if ($I->checkElement(GlobalSettingsSelectors::licenseDeactivateBtn)) {
            $I->clicked(GlobalSettingsSelectors::licenseDeactivateBtn, "Deactivating License before checking");
        }
        $I->canSeeElement(GlobalSettingsSelectors::licenseKeyInputField, [], "Check License Key Input Field");
        $I->canSeeElement(GlobalSettingsSelectors::licenseActivateBtn, [], "Check License Key activate button");
        $I->seeText([
            "The Fluent Forms Pro Add On license needs to be activated. Activate Now",
            "Thank you for purchasing Fluent Forms Pro Add On! Please enter your license key below.",
        ]);

    }
    public function test_fluent_forms_license_activation(AcceptanceTester $I)
    {
        $I->amOnPage(GlobalSettingsSelectors::licensePage);

        if ($I->checkElement(GlobalSettingsSelectors::licenseDeactivateBtn)) {
            $I->clicked(GlobalSettingsSelectors::licenseDeactivateBtn, "Deactivating License before inserting key");
        }
        $I->canSeeElement(GlobalSettingsSelectors::licenseKeyInputField, [], "Check License Key Input Field");
        $I->filledField(GlobalSettingsSelectors::licenseKeyInputField, getenv("LICENSE_KEY"), "Inserting license key");
        $I->clicked(GlobalSettingsSelectors::licenseActivateBtn, "click on activate button");

        $I->waitForElement(GlobalSettingsSelectors::licenseDeactivateBtn,5);
        $I->seeText([
            "Your license is activated! Enjoy Fluent Forms Pro Add On.",
        ]);

    }

}
