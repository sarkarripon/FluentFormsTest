<?php

namespace Tests\Support\Helper;

use Tests\Support\AcceptanceTester;
use Tests\Support\Selectors\GeneralSelectors;
use Tests\Support\Selectors\GlobalSettingsSelectors;

trait FormSpecificSettings
{
    public function doubleOptInConfirmation(
        AcceptanceTester $I,
        string $emailLabel,
        ?array $Options = null,
    ): void
    {
        $obtainedOptions = null;

        $obtainedOptionsDefault = [
            'initialSuccessMsg' => false,
            'customizedEmail' => false,
            'isDisableForLoggedInUser' => false,

        ];


        if (!is_null($Options)) {
            $obtainedOptions = array_merge($obtainedOptionsDefault, $Options);
        }

        $I->clicked("//a[normalize-space()='Double Opt-in Confirmation']");
        if (!$I->checkElement(GeneralSelectors::selectCheckbox("Enable Double Optin Confirmation before Form Data Processing", true))) {
            $I->clicked(GeneralSelectors::selectCheckbox("Enable Double Optin Confirmation before Form Data Processing"));
        }
        $I->clickOnExactText("Select an email field",'Primary Email Field', null, 1, 'Click on Primary Email Field');
        $I->clickOnText($emailLabel);

        if ($obtainedOptions['initialSuccessMsg']) {
            $I->waitForElementVisible("(//button[normalize-space()='Text'])", 5);
            $I->clicked("(//button[normalize-space()='Text'])");
            $I->filledField("//textarea[contains(@id,'wp_editor')]", $obtainedOptions['initialSuccessMsg'], 'Fill As double opt-in initial success message in plain text');
        }
        if ($obtainedOptions['customizedEmail']) {
            if (!$I->checkElement(GeneralSelectors::selectRadio("Customized Double Optin Email", true))) {
                $I->clicked(GeneralSelectors::selectRadio("Customized Double Optin Email"));
                exit();
            }
        }

        $I->scrollTo("(//span[normalize-space()='Save Settings'])[1]");
        $I->clicked("(//span[normalize-space()='Save Settings'])[1]");
        $I->seeSuccess("Settings has been saved.");
    }

}