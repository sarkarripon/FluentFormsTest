<?php


namespace Tests\GlobalSettings;

use Tests\Support\AcceptanceTester;

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
        $I->amOnPage("wp-admin/admin.php?page=fluent_forms_settings&component=license_page");

        if ($I->checkElement("//input[@name='_ff_fluentform_pro_license_deactivate']")) {
            $I->clicked("//input[@name='_ff_fluentform_pro_license_deactivate']", "Deactivating License before checking");
        }
        $I->canSeeElement("//input[@name='_ff_fluentform_pro_license_key']", [], "Check License Key Input Field");
        $I->canSeeElement("//input[@name='_ff_fluentform_pro_license_activate']", [], "Check License Key activate button");
        $I->seeText([
            "The Fluent Forms Pro Add On license needs to be activated. Activate Now",
            "Thank you for purchasing Fluent Forms Pro Add On! Please enter your license key below.",
        ]);

    }
    public function test_fluent_forms_license_activation(AcceptanceTester $I)
    {
        $I->amOnPage("wp-admin/admin.php?page=fluent_forms_settings&component=license_page");

        if ($I->checkElement("//input[@name='_ff_fluentform_pro_license_deactivate']")) {
            $I->clicked("//input[@name='_ff_fluentform_pro_license_deactivate']", "Deactivating License before inserting key");
        }
        $I->canSeeElement("//input[@name='_ff_fluentform_pro_license_key']", [], "Check License Key Input Field");
        $I->filledField("//input[@name='_ff_fluentform_pro_license_key']", getenv("LICENSE_KEY"), "Inserting license key");
        $I->clicked("//input[@name='_ff_fluentform_pro_license_activate']", "click on activate button");

        $I->waitForElement("//input[@name='_ff_fluentform_pro_license_deactivate']",5);
        $I->seeText([
            "Your license is activated! Enjoy Fluent Forms Pro Add On.",
        ]);

    }

}
