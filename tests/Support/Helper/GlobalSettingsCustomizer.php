<?php

namespace Tests\Support\Helper;

use Tests\Support\AcceptanceTester;
use Tests\Support\Selectors\GeneralSelectors;
use Tests\Support\Selectors\GlobalSettingsSelectors;

trait GlobalSettingsCustomizer
{
    public function customizeGlobalDoubleOptIn
    (
        AcceptanceTester $I,
        ?array $Options = null,
    ): void
    {
        $I->amOnPage(GlobalSettingsSelectors::doubleOptInPage);

        $obtainedOptions = null;

        $obtainedOptionsDefault = [
            'enableModule' => false,
            'emailSubject' => false,
            'emailBody' => false,
            'rawHtmlFormat' => false,
            'fromName' => false,
            'replyTo' => false,
            'deleteInterval' => false,
        ];


        if (!is_null($Options)) {
            $obtainedOptions = array_merge($obtainedOptionsDefault, $Options);
        }

        if ($obtainedOptions['enableModule']) {
            if ($I->checkElement("(//span[@class='el-checkbox__input is-checked'])", "check if double opt-in is enabled")) {
                echo "Double Opt-in is already enabled";
            }else{
                $I->clicked("(//span[contains(@class,'el-checkbox__input')])[1]");
                $I->scrollTo("(//span[normalize-space()='Save Settings'])[1]");
                $I->clicked("(//span[normalize-space()='Save Settings'])[1]");
                $I->seeSuccess("Settings successfully updated");
            }
        }

        if ($obtainedOptions['emailSubject']) {
            $I->fillField(GeneralSelectors::customizationFields("Email Subject"), "Email Subject");
        }


    }


}