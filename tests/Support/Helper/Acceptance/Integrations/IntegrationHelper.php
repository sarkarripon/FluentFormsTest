<?php

namespace Tests\Support\Helper\Acceptance\Integrations;

use Tests\Support\AcceptanceTester;
use Tests\Support\Selectors\FluentFormsAddonsSelectors;
use Tests\Support\Selectors\FluentFormsSelectors;

trait IntegrationHelper
{

    /**
     *
     * [!] Use it as a reference of fields name.
     * prepare array like
     * ```
     * ['generalFields' => ['email', 'nameFields', 'phone']]
     * ```
     * * generalFields
     * ```
     * nameFields
     * email
     * simpleText
     * maskInput
     * textArea
     * addressFields
     * countryList
     * numaricField
     * dropdown
     * radioField
     * checkBox
     * multipleChoice
     * websiteUrl
     * timeDate
     * imageUpload
     * fileUpload
     * customHtml
     * phone
     * ```
     *
     * * advancedFields
     * ```
     * hiddenField
     * sectionBreak
     * reCaptcha
     * hCapcha
     * turnstile
     * shortCode
     * tnc
     * actionHook
     * formStep
     * rating
     * checkableGrid
     * gdpr
     * passwordField
     * customSubBtn
     * rangeSlider
     * netPromoter
     * chainedSelect
     * colorPicker
     * repeat
     * post_cpt
     * richText
     * save_resume
     * ```
     *
     * * containers
     * ```
     * oneColumn
     * twoColumns
     * threeColumns
     * fourColumns
     * fiveColumns
     * sixColumns
     * ```
     *
     * * paymentFields
     * ```
     * paymentItem
     * subscription
     * customPaymentAmount
     * itmQuantity
     * paymentMethod
     * paymentSummary
     * coupon
     * ```
     */
    public function prepareForm(AcceptanceTester $I, string $formName, array $requiredField)
    {
//        global $formID;
        $isDelete = getenv("EXISTING_FORM_DELETE");
        if ($isDelete === "yes") {
            $I->deleteExistingForms();
        }
        $I->initiateNewForm();
        $I->createFormField($requiredField);
//        $formID = $I->grabTextFrom("button[title='Click to Copy']");
        $I->clicked(FluentFormsSelectors::saveForm);
        $I->seeSuccess('Form created successfully.');
        $I->renameForm($formName);
        $I->seeSuccess('Form renamed successfully.');
//        return $formID;
    }

    public function preparePage(AcceptanceTester $I, string $title = null): void
    {
        global $pageUrl;
        $isDelete = getenv("EXISTING_PAGE_DELETE");
        if ($isDelete === "yes") {
            $I->deleteExistingPages();
        }
        $I->createNewPage($title);
        $I->amOnUrl($pageUrl);
    }

    public function initiateIntegrationConfiguration(AcceptanceTester $I, int $integrationPositionNumber): void
    {
        $I->retry(4,200);
        $I->amOnPage(FluentFormsAddonsSelectors::integrationsPage);
        $isEnabled = $I->retryGrabTextFrom("(//div[contains(@class,'card_footer_group')])[{$integrationPositionNumber}]");
        if ($isEnabled === "Disabled") {
            $I->retryClickWithLeftButton("(//span[contains(@class,'el-switch__core')])[{$integrationPositionNumber}]");
        }
        $gearIcon = $I->retryCheckElement("(//div[@class='ff_card_footer'])[{$integrationPositionNumber}]//i[@class='el-icon-setting']");
        if ($gearIcon) {
            $I->retryClickWithLeftButton("(//DIV[contains(@class,'card_footer_group')])[{$integrationPositionNumber}]//I[contains(@class,'el-icon-setting')]");
        }
    }

    public function takeMeToConfigurationPage(AcceptanceTester $I): void
    {
        $I->amOnPage(FluentFormsSelectors::fFormPage);
        $I->waitForElement(FluentFormsSelectors::mouseHoverMenu, 10);
        $I->moveMouseOver(FluentFormsSelectors::mouseHoverMenu);
        $I->clicked(FluentFormsSelectors::formSettings);

    }
    public function configureApiSettings(AcceptanceTester $I, $searchKey): void
    {
        $this->takeMeToConfigurationPage($I);
        $I->clicked(FluentFormsSelectors::allIntegrations);
        $I->clicked(FluentFormsSelectors::addNewIntegration);
        $I->fillField(FluentFormsSelectors::searchIntegration, $searchKey);
        $I->clicked(FluentFormsSelectors::searchResult);
    }

    public function mapEmailInCommon(AcceptanceTester $I, $feedName, array $extraListOrService=null): void
    {
        $I->waitForElementClickable(FluentFormsSelectors::integrationFeed, 20);
        $I->fillByJS(FluentFormsSelectors::feedName, $feedName);

        if (empty($extraListOrService)) {
            $I->clicked(FluentFormsSelectors::SegmentDropDown);
            $I->clicked(FluentFormsSelectors::Segment);
            $I->clickByJS(FluentFormsSelectors::mapEmailDropdown);
            $I->clickByJS(FluentFormsSelectors::mapEmail);
        }else{
            foreach ($extraListOrService as $key => $value) {
                $I->clicked(FluentFormsSelectors::dropdown($key));
                $I->clickOnText($value, $key);
            }
        }
    }

    /**
     * Arr ex; 'Name'=>'{inputs.names}'
     *
     */
    public function mapCommonFieldsWithLabel(AcceptanceTester $I, $fields, $actionText): void
    {
        foreach ($fields as $field => $value) {
            $I->fillField(FluentFormsSelectors::commonFields($field, $actionText), $value);
        }
    }

    public function mapDynamicTag(AcceptanceTester $I, $isDropDown, array $dynamicTagArray = null): void
    {
        global $dynamicTagField;
        $dynamicTagField = 1;
        $dynamicTagValue = 1;
        foreach ($dynamicTagArray as $tag => $value) {
            if ($isDropDown == "yes" and !empty($isDropDown)) {
                $I->clicked(FluentFormsSelectors::setTag($dynamicTagField));
                $I->clickOnText($tag);
            } else {
                $I->fillField(FluentFormsSelectors::dynamicTagField($dynamicTagField), $tag);
            }
            $I->click(FluentFormsSelectors::ifClause($dynamicTagValue));
            $I->clickOnText($value[0]);

            $I->click(FluentFormsSelectors::ifClause($dynamicTagValue + 1));
            $I->clickOnText($value[1]);

            $I->fillField(FluentFormsSelectors::dynamicTagValue($dynamicTagField), $value[2]);
            $I->click(FluentFormsSelectors::addDynamicTagField($dynamicTagField));
            $dynamicTagField++;
            $dynamicTagValue += 2;
        }
        $I->click(FluentFormsSelectors::removeDynamicTagField($dynamicTagField));

    }

    public function missingFieldCheck(AcceptanceTester $I, array $referenceData, array $remoteData): void
    {
        $absentData = array_diff_assoc($referenceData, $remoteData);

        $message = '';
        if (!empty($absentData)) {
            foreach ($absentData as $missingField => $value) {
                $message .= $missingField . ', ';
            }
            $I->fail($message . " is not present to the remote.");
        } else {
            echo ' Hurray!! Additional data has been sent to remote' . "\n";
        }
    }

    public function retryFetchingData(AcceptanceTester $I, $fetchFunction, $searchTerm, $retries = 2)
    {
        $expectedRow = null;
        for ($i = 0; $i < $retries; $i++) {
            $expectedRow = $fetchFunction($searchTerm, $I, $expectedRow);
            $data = self::searchData($I, $expectedRow, '/' . preg_quote($searchTerm, '/') . '/');
            if (empty($data)) {
                $I->wait(30, 'API response Taking too long, Trying again...');
            } else {
                break;
            }
        }
        return $expectedRow;
    }

    public static function searchData(AcceptanceTester $I, $data, $searchTerm): ?string
    {
        if (is_array($data) || is_object($data)) {
            foreach ($data as $key => $value) {
                if (is_string($value) && preg_match($searchTerm, $value)) {
                    return $value;
                } elseif (is_array($value) || is_object($value)) {
                    $result = self::searchData($I, $value, $searchTerm);
                    if ($result !== null) {
                        return $result;
                    }
                }
            }
        }
        return null;
    }


}
