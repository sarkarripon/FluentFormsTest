<?php

namespace Tests\Support\Helper;

use Tests\Support\AcceptanceTester;
use Tests\Support\Selectors\GeneralSelectors;
use Tests\Support\Selectors\GlobalSettingsSelectors;

trait GlobalSettingsCustomizer
{
    public function checkInEmailLog()
    {


    }
    /**
     * ```
     * 'enableModule' => false,
     * 'emailSubject' => false,
     * 'emailBody' => false,
     * 'rawHtmlFormat' => false,
     * 'fromName' => false,
     * 'replyTo' => false,
     * 'deleteInterval' => false,
     * ```
     * @param AcceptanceTester $I
     * @param array|null $Options
     */
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


        if (isset($obtainedOptions)) {
            if ($obtainedOptions['enableModule']) {
                if (!$I->checkElement("(//span[@class='el-checkbox__input is-checked'])", "check if double opt-in is enabled")) {
                    $I->clicked("(//span[contains(@class,'el-checkbox__input')])[1]");
                }

                if ($obtainedOptions['emailSubject']) {
                    $I->filledField(GeneralSelectors::customizationFields("Global Email Subject"), $obtainedOptions['emailSubject'], 'Fill As email subject');
                }

                if ($obtainedOptions['emailBody']) {
                    $I->waitForElementVisible("(//button[normalize-space()='Text'])", 5);
                    $I->clicked("(//button[normalize-space()='Text'])");
                    $I->filledField("//textarea[contains(@id,'wp_editor')]", $obtainedOptions['emailBody'], 'Fill As email body in plain text');
                }

                if ($obtainedOptions['rawHtmlFormat']) {
                    if (!$I->checkElement("//label[@class='el-checkbox mt-3 mb-2 is-checked']", "check if double opt-in is enabled")) {
                        $I->clicked("(//span[@class='el-checkbox__inner'])[2]");
                    }
                }

                if ($obtainedOptions['fromName']) {
                    $I->filledField(GeneralSelectors::customizationFields("From Name"), $obtainedOptions['fromName'], 'Fill As From Name');
                }

                if ($obtainedOptions['replyTo']) {
                    $I->filledField(GeneralSelectors::customizationFields("Reply To"), $obtainedOptions['replyTo'], 'Fill As Reply To');
                }

                if ($obtainedOptions['deleteInterval']) {
                    $I->filledField("//input[@role='spinbutton']", $obtainedOptions['deleteInterval'], 'Fill As Delete Interval');
                }
            }
        }

        $I->scrollTo("(//span[normalize-space()='Save Settings'])[1]");
        $I->clicked("(//span[normalize-space()='Save Settings'])[1]");
        $I->seeSuccess("Settings successfully updated");
    }


}