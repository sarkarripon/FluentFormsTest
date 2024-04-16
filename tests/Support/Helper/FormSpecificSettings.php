<?php

namespace Tests\Support\Helper;

use Tests\Support\AcceptanceTester;
use Tests\Support\Selectors\GeneralSelectors;
use Tests\Support\Selectors\GlobalSettingsSelectors;

trait FormSpecificSettings
{
    public function enableDoubleOptIn(
        AcceptanceTester $I,
        string $emailLabel,
        ?array $Options = null,
    ): void
    {
        $I->clicked("//a[normalize-space()='Settings & Integrations']", 'Click on Settings & Integrations');
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
        if (!$I->checkElement(GeneralSelectors::selectCheckbox("Enable Double Optin Confirmation before Form Data Processing",null, 1,true))) {
            $I->clicked(GeneralSelectors::selectCheckbox("Enable Double Optin Confirmation before Form Data Processing",null,1));
        }
        $I->clickOnExactText("Select an email field",'Primary Email Field', null, 1, 'Click on Primary Email Field');
        $I->clickOnText($emailLabel);

        if ($obtainedOptions['initialSuccessMsg']) {
            $I->clickOnExactText("Text","Initial Success Message", 1, 1, "Click Text area of Initial Success Message");
            $I->filledField("(//label[normalize-space()='Initial Success Message']/following::textarea[contains(@id,'wp_editor')])[1]",
                $obtainedOptions['initialSuccessMsg'], 'Fill As double opt-in initial success message in plain text');
        }
        if ($obtainedOptions['customizedEmail']) {
            if (!$I->checkElement(GeneralSelectors::selectRadio("Customized Double Optin Email", true))) {
                $I->clicked(GeneralSelectors::selectRadio("Customized Double Optin Email"));
                // continue for others
            }
        }
        if ($obtainedOptions['isDisableForLoggedInUser']) {
            if (!$I->checkElement(GeneralSelectors::selectCheckbox("Disable Double Optin for Logged in users", "Email Type",1,true))) {
                $I->clicked(GeneralSelectors::selectCheckbox("Disable Double Optin for Logged in users", "Email Type",1));
            }
        }else {
            if ($I->checkElement(GeneralSelectors::selectCheckbox("Disable Double Optin for Logged in users", "Email Type", 1, true))) {
                $I->clicked(GeneralSelectors::selectCheckbox("Disable Double Optin for Logged in users", "Email Type", 1,true));
            }
        }

        $I->scrollTo("(//span[normalize-space()='Save Settings'])[1]");
        $I->clicked("(//span[normalize-space()='Save Settings'])[1]");
        $I->seeSuccess("Settings has been saved.");
    }


    public function enableAdminApproval(
        AcceptanceTester $I,
        string $emailLabel,
        ?array $Options = null,
    ): void
    {
        $I->clicked("//a[normalize-space()='Settings & Integrations']", 'Click on Settings & Integrations');
        $obtainedOptions = null;

        $obtainedOptionsDefault = [
            'emailNotificationType' => false,
            'recipientEmail' => false,
            'emailSubject' => false,
            'emailBody' => false,
            'rawHtmlFormat' => false,
            'fromName' => false,
            'fromEmail' => false,
            'replyTo' => false,
            'deleteInterval' => false,



            'initialSuccessMsg' => false,
            'customizedEmail' => false,
            'isDisableForLoggedInUser' => false,
        ];

        if (!is_null($Options)) {
            $obtainedOptions = array_merge($obtainedOptionsDefault, $Options);
        }

        $I->clicked("//a[normalize-space()='Admin Approval']");
        if (!$I->checkElement(GeneralSelectors::selectCheckbox("Enable Admin approval before Form Data Processing",null, 1,true))) {
            $I->clicked(GeneralSelectors::selectCheckbox("Enable Admin approval before Form Data Processing",null,1));
        }
        $I->clickOnExactText("Select an email field",'Primary Email Field', null, 1, 'Click on Primary Email Field');
        $I->clickOnText($emailLabel);

        if ($obtainedOptions['initialSuccessMsg']) {
            $I->clickOnExactText("Text","Initial Success Message", 1, 1, "Click Text area of Initial Success Message");
            $I->filledField("(//label[normalize-space()='Initial Success Message']/following::textarea[contains(@id,'wp_editor')])[1]",
                $obtainedOptions['initialSuccessMsg'], 'Fill As double opt-in initial success message in plain text');
        }
        if ($obtainedOptions['customizedEmail']) {
            if (!$I->checkElement(GeneralSelectors::selectRadio("Customized Double Optin Email", true))) {
                $I->clicked(GeneralSelectors::selectRadio("Customized Double Optin Email"));
                // continue for others
            }
        }
        if ($obtainedOptions['isDisableForLoggedInUser']) {
            if (!$I->checkElement(GeneralSelectors::selectCheckbox("Disable Double Optin for Logged in users", "Email Type",1,true))) {
                $I->clicked(GeneralSelectors::selectCheckbox("Disable Double Optin for Logged in users", "Email Type",1));
            }
        }else {
            if ($I->checkElement(GeneralSelectors::selectCheckbox("Disable Double Optin for Logged in users", "Email Type", 1, true))) {
                $I->clicked(GeneralSelectors::selectCheckbox("Disable Double Optin for Logged in users", "Email Type", 1,true));
            }
        }

        $I->scrollTo("(//span[normalize-space()='Save Settings'])[1]");
        $I->clicked("(//span[normalize-space()='Save Settings'])[1]");
        $I->seeSuccess("Settings has been saved.");
    }

}