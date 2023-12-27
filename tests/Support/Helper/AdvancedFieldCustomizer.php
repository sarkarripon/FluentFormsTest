<?php

namespace Tests\Support\Helper;

use Tests\Support\AcceptanceTester;
use Tests\Support\Selectors\FluentFormsSelectors;
use Tests\Support\Selectors\GeneralFields;

trait AdvancedFieldCustomizer
{
    public function customizeHiddenField(
        AcceptanceTester $I,
        $fieldName,
        ?array $basicOptions = null,
        ?array $advancedOptions = null,
        ?bool $isHiddenLabel = false
    ): void
    {
        $I->clickByJS("(//div[contains(@class,'item-actions-wrapper')])[1]");

        $basicOperand = null;
        $advancedOperand = null;

        $basicOptionsDefault = [
        ];

        $advancedOptionsDefault = [
            'adminFieldLabel' => false,
            'defaultValue' => false,
            'nameAttribute' => false,
        ];

        if (!is_null($basicOptions)) {
            $basicOperand = array_merge($basicOptionsDefault, $basicOptions);
        }

        if (!is_null($advancedOptions)) {
            $advancedOperand = array_merge($advancedOptionsDefault, $advancedOptions);
        }

        //                                           Advanced options                                              //

        if (isset($advancedOperand)) {

            $advancedOperand['adminFieldLabel'] // adminFieldLabel
                ? $I->filledField(GeneralFields::adminFieldLabel, $advancedOperand['adminFieldLabel'], 'Fill As Admin Field Label')
                : null;

            $advancedOperand['defaultValue'] // Default Value
                ? $I->filledField(GeneralFields::defaultField, $advancedOperand['defaultValue'], 'Fill As Default Value')
                : null;

            $advancedOperand['nameAttribute'] // Name Attribute
                ? $I->filledField(GeneralFields::customizationFields('Name Attribute'), $advancedOperand['nameAttribute'], 'Fill As Name Attribute')
                : null;
        }
        $I->clickByJS(FluentFormsSelectors::saveForm);
        $I->seeSuccess('The form is successfully updated.');

    }

    public function customizeSectionBreak(
        AcceptanceTester $I,
        $fieldName,
        ?array $basicOptions = null,
        ?array $advancedOptions = null,
        ?bool $isHiddenLabel = false
    ): void
    {
        $I->clickOnExactText($fieldName);

        $basicOperand = null;
        $advancedOperand = null;

        $basicOptionsDefault = [
            'description' => false,
        ];

        $advancedOptionsDefault = [
            'elementClass' => false,
        ];

        if (!is_null($basicOptions)) {
            $basicOperand = array_merge($basicOptionsDefault, $basicOptions);
        }

        if (!is_null($advancedOptions)) {
            $advancedOperand = array_merge($advancedOptionsDefault, $advancedOptions);
        }

        //                                           Basic options                                              //
        if (isset($basicOperand)) {

            if ($basicOperand['description']) { //description
                $I->waitForElementVisible("//iframe[contains(@id,'wp_editor')]",5);
                $I->switchToIFrame("//iframe[contains(@id,'wp_editor')]");
                $I->filledField("body p:nth-child(1)", $basicOperand['description'], 'Fill As description');
                $I->switchToIFrame();
            }
        }

        //                                           Advanced options                                              //

        if (isset($advancedOperand)) {
            $I->scrollTo(GeneralFields::advancedOptions);
            $I->clicked(GeneralFields::advancedOptions,'Expand advanced options');
            $I->wait(2);

            $advancedOperand['elementClass'] // Element Class
                ? $I->filledField(GeneralFields::customizationFields('Element Class'), $advancedOperand['elementClass'], 'Fill As Element Class')
                : null;
        }
        $I->clickByJS(FluentFormsSelectors::saveForm);
        $I->seeSuccess('The form is successfully updated.');

    }

    public function customizeShortCode(
        AcceptanceTester $I,
        ?array $basicOptions = null,
        ?array $advancedOptions = null,
        ?bool $isHiddenLabel = false
    ): void
    {
        $I->clickByJS("(//div[contains(@class,'item-actions-wrapper')])[1]");

        $basicOperand = null;
        $advancedOperand = null;

        $basicOptionsDefault = [
            'shortcode' => false,
        ];

        $advancedOptionsDefault = [
            'elementClass' => false,
        ];

        if (!is_null($basicOptions)) {
            $basicOperand = array_merge($basicOptionsDefault, $basicOptions);
        }

        if (!is_null($advancedOptions)) {
            $advancedOperand = array_merge($advancedOptionsDefault, $advancedOptions);
        }

        //                                           Basic options                                              //
        if (isset($basicOperand)) {

            $basicOperand['shortcode'] // Element Class
                ? $I->filledField(GeneralFields::customizationFields('Shortcode'), $basicOperand['shortcode'], 'Fill As Shortcode')
                : null;
        }

        //                                           Advanced options                                              //

        if (isset($advancedOperand)) {
            $I->scrollTo(GeneralFields::advancedOptions);
            $I->clicked(GeneralFields::advancedOptions,'Expand advanced options');
            $I->wait(2);

            $advancedOperand['elementClass'] // Element Class
                ? $I->filledField(GeneralFields::customizationFields('Element Class'), $advancedOperand['elementClass'], 'Fill As Element Class')
                : null;
        }
        $I->clickByJS(FluentFormsSelectors::saveForm);
        $I->seeSuccess('The form is successfully updated.');
    }

    public function customizeTnC(
        AcceptanceTester $I,
        $fieldName,
        ?array $basicOptions = null,
        ?array $advancedOptions = null,
        ?bool $isHiddenLabel = false
    ): void
    {
//        $I->clickOnExactText($fieldName);
        $I->clickByJS("(//div[contains(@class,'item-actions-wrapper')])[1]");

        $basicOperand = null;
        $advancedOperand = null;

        $basicOptionsDefault = [
            'adminFieldLabel' => false,
            'requiredMessage' => false,
            'termsNConditions' => false,
            'showCheckbox' => false,
        ];

        $advancedOptionsDefault = [
            'containerClass' => false,
            'elementClass' => false,
            'nameAttribute' => false,
        ];

        if (!is_null($basicOptions)) {
            $basicOperand = array_merge($basicOptionsDefault, $basicOptions);
        }

        if (!is_null($advancedOptions)) {
            $advancedOperand = array_merge($advancedOptionsDefault, $advancedOptions);
        }

        //                                           Basic options                                              //
        if (isset($basicOperand)) {

            if ($basicOperand['adminFieldLabel']) { //adminFieldLabel
                $I->filledField(GeneralFields::adminFieldLabel, $basicOperand['adminFieldLabel'], 'Fill As Admin Field Label');
            }

            if ($basicOperand['requiredMessage']) { // Required Message
                $I->clicked(GeneralFields::radioSelect('Required',1),'Mark Yes from Required because by default it is No');
                $I->clickByJS(GeneralFields::radioSelect('Error Message', 2),'Mark custom from Required because by default it is global');
                $I->filledField(GeneralFields::customizationFields('Required'), $basicOperand['requiredMessage'], 'Fill As custom Required Message');
            }

            if ($basicOperand['termsNConditions']) { //Terms & Conditions
                $I->waitForElementVisible("//iframe[contains(@id,'wp_editor')]",5);
                $I->switchToIFrame("//iframe[contains(@id,'wp_editor')]");
                $I->filledField("body p:nth-child(1)", $basicOperand['termsNConditions'], 'Fill As Terms & Conditions');
                $I->switchToIFrame();
            }
            if ($basicOperand['showCheckbox']) { //Show Checkbox
                $I->clicked("//label[@class='el-checkbox']", 'Enable checkbox');
            }
        }
    //                                             Advanced options                                                   //

        if (isset($advancedOperand)) {
            $I->clicked(GeneralFields::advancedOptions,'Expand advanced options');
            $I->wait(2);

            $advancedOperand['containerClass'] // Container Class
                ? $I->filledField(GeneralFields::customizationFields('Container Class'), $advancedOperand['containerClass'], 'Fill As Container Class')
                : null;
            $advancedOperand['elementClass'] // Element Class
                ? $I->filledField(GeneralFields::customizationFields('Element Class'), $advancedOperand['elementClass'], 'Fill As Element Class')
                : null;
            $advancedOperand['nameAttribute'] // Name Attribute
                ? $I->filledField(GeneralFields::customizationFields('Name Attribute'), $advancedOperand['nameAttribute'], 'Fill As Name Attribute')
                : null;
        }
        $I->clickByJS(FluentFormsSelectors::saveForm);
        $I->seeSuccess('The form is successfully updated.');

    }

    public function customizeActionHook()
    {

    }

    public function customizeFormStep()
    {

    }

    public function customizeRating(
        AcceptanceTester $I,
        $fieldName,
        ?array $basicOptions = null,
        ?array $advancedOptions = null,
        ?bool $isHiddenLabel = false
    ): void
    {
        $I->clickOnExactText($fieldName);

        $basicOperand = null;
        $advancedOperand = null;

        $basicOptionsDefault = [
            'adminFieldLabel' => false,
            'options' => false,
            'showText' => false,
            'requiredMessage' => false,
        ];

        $advancedOptionsDefault = [
            'helpMessage' => false,
            'nameAttribute' => false,
        ];

        if (!is_null($basicOptions)) {
            $basicOperand = array_merge($basicOptionsDefault, $basicOptions);
        }

        if (!is_null($advancedOptions)) {
            $advancedOperand = array_merge($advancedOptionsDefault, $advancedOptions);
        }

        //                                           Basic options                                              //
        // adminFieldLabel
        if (isset($basicOperand)) {
            $basicOperand['adminFieldLabel']
                ? $I->filledField(GeneralFields::adminFieldLabel, $basicOperand['adminFieldLabel'], 'Fill As Admin Field Label')
                : null;

            if ($basicOperand['options']) { // configure options

                global $removeField;
                $addField = 1;
                $removeField = 1;
                $fieldCounter = 1;

                foreach ($basicOperand['options'] as $fieldContents) {

                    $label = $fieldContents['label'] ?? null;
                    $value = $fieldContents['value'] ?? null;

                    $label
                        ? $I->filledField("(//input[@type='text'])[" . ($fieldCounter + 2) . "]", $label, 'Fill As Label')
                        : null;

                    if (isset($value)) {
                        if ($fieldCounter === 1) {
                            $I->clicked("(//span[@class='el-checkbox__inner'])[1]", 'Select Show Values');
                        }
                        $I->filledField("(//input[@type='text'])[" . ($fieldCounter + 3) . "]", $value, 'Fill As Value');
                    }

                    if ($addField >= 6) {
                        $I->clickByJS(FluentFormsSelectors::addField($addField), 'Add Field no '.$addField);
                    }
                    $fieldCounter+=2;
                    $addField++;
                    $removeField += 1;
                }
                $I->clicked(FluentFormsSelectors::removeField($removeField));
            }

            if ($basicOperand['requiredMessage']) { //Required Message
                $I->clicked(GeneralFields::radioSelect('Required'),'Select Required');
                $I->clickByJS(GeneralFields::radioSelect('Error Message', 2),'Select error message type');
                $I->filledField(GeneralFields::customizationFields('Required'), $basicOperand['requiredMessage'], 'Fill As Required Message');
            }
        }

        //                                           Advanced options                                              //

        if (isset($advancedOperand)) {
            $I->scrollTo(GeneralFields::advancedOptions);
            $I->clickByJS(GeneralFields::advancedOptions, 'Expand advanced options');
            $I->wait(2);

            $advancedOperand['helpMessage'] // Help Message
                ? $I->filledField("(//textarea[@class='el-textarea__inner'])", $advancedOperand['helpMessage'], 'Fill As Help Message')
                : null;

            $advancedOperand['nameAttribute'] // Name Attribute
                ? $I->filledField(GeneralFields::customizationFields('Name Attribute'), $advancedOperand['nameAttribute'], 'Fill As Name Attribute')
                : null;
        }

        $I->clickByJS(FluentFormsSelectors::saveForm);
        $I->seeSuccess('The form is successfully updated.');
    }

    public function customizeCheckAbleGrid()
    {

    }

    public function customizeGDPRAgreement()
    {

    }

    public function customizePassword()
    {

    }

}