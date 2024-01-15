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
                if ($I->checkElement("//div[contains(@class, 'is-checked') and @role='switch']")){
                    $I->clickByJS("//div[contains(@class, 'is-checked') and @role='switch']",'Enable custom error message');
                }
                $I->filledField(GeneralFields::customizationFields('Custom Error Message'), $basicOperand['requiredMessage'], 'Fill As custom Required Message');
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

                    if ($addField >= 5) {
                        $I->clickByJS(FluentFormsSelectors::addField($addField), 'Add Field no '.$addField);
                    }
                    $fieldCounter+=2;
                    $addField++;
                    $removeField += 1;
                }
                $I->clicked(FluentFormsSelectors::removeField($removeField));
            }

            if ($basicOperand['requiredMessage']) { // Required Message
                $I->clicked(GeneralFields::radioSelect('Required',1),'Mark Yes from Required because by default it is No');
                if ($I->checkElement("//div[contains(@class, 'is-checked') and @role='switch']")){
                    $I->clickByJS("//div[contains(@class, 'is-checked') and @role='switch']",'Enable custom error message');
                }
                $I->filledField(GeneralFields::customizationFields('Custom Error Message'), $basicOperand['requiredMessage'], 'Fill As custom Required Message');
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

    public function customizeCheckAbleGrid(
        AcceptanceTester $I,
        $fieldName,
        ?array $basicOptions = null,
        ?array $advancedOptions = null,
        ?bool $isHiddenLabel = false
    ): void
    {
//        print_r($basicOptions);
//        dd($advancedOptions);

        $I->clickOnExactText($fieldName);
        $basicOperand = null;
        $advancedOperand = null;

        $basicOptionsDefault = [
            'adminFieldLabel' => false,
            'fieldType' => false,
            'gridColumns' => false,
            'gridRows' => false,
            'requiredMessage' => false,
        ];

        $advancedOptionsDefault = [
            'containerClass' => false,
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

        if (isset($basicOperand)) { // adminFieldLabel
            $basicOperand['adminFieldLabel']
                ? $I->filledField(GeneralFields::adminFieldLabel, $basicOperand['adminFieldLabel'], 'Fill As Admin Field Label')
                : null;

            if ($basicOperand['fieldType'] === 'radio') { // Field Type
                $I->clickByJS("//span[normalize-space()='Radio']", 'Select Field Type ' .$basicOperand['fieldType']);
            }

            if ($basicOperand['gridColumns']) { // configure Columns

                global $removeField;
                $addField = 1;
                $removeField = 1;
                $fieldCounter = 1;

                foreach ($basicOperand['gridColumns'] as $fieldContents) {

                    $label = $fieldContents['label'] ?? null;
                    $value = $fieldContents['value'] ?? null;

                    $label
                        ? $I->filledField("(//span[normalize-space()='Grid Columns']/following::input[@type='text'])[" . ($fieldCounter) . "]", $label, 'Fill As Label')
                        : null;

                    if (isset($value)) {
                        if ($fieldCounter === 1) {
                            $I->clicked("(//span[@class='el-checkbox__inner'])[1]", 'Select Show Values of Grid Columns');
                        }
                        $I->filledField("(//span[normalize-space()='Grid Columns']/following::input[@type='text'])[" . ($fieldCounter + 1) . "]", $value, 'Fill As Value');
                    }

                    if ($addField >= 1) {
                        $I->clickByJS("(//span[normalize-space()='Grid Columns']/following::i[contains(@class,'el-icon-plus')])[$addField]", 'Add Field no '.$addField. ' to Grid Columns');
                    }
                    $fieldCounter+=2;
                    $addField++;
                    $removeField += 1;
                }
                $I->clicked(FluentFormsSelectors::removeField($removeField));
            }

            if ($basicOperand['gridRows']) { // configure Columns

                global $removeField;
                $addField = 1;
                $removeField = 1;
                $fieldCounter = 1;

                foreach ($basicOperand['gridRows'] as $fieldContents) {

                    $label = $fieldContents['label'] ?? null;
                    $value = $fieldContents['value'] ?? null;

                    $label
                        ? $I->filledField("(//span[normalize-space()='Grid Rows']/following::input[@type='text'])[" . ($fieldCounter) . "]", $label, 'Fill As Label')
                        : null;

                    if (isset($value)) {
                        if ($fieldCounter === 1) {
                            $I->clicked("(//span[@class='el-checkbox__inner'])[2]", 'Select Show Values of Grid Rows');
                        }
                        $I->filledField("(//span[normalize-space()='Grid Rows']/following::input[@type='text'])[" . ($fieldCounter + 1) . "]", $value, 'Fill As Value');
                    }

                    if ($addField >= 1) {
                        $I->clickByJS("(//span[normalize-space()='Grid Rows']/following::i[contains(@class,'el-icon-plus')])[$addField]", 'Add Field no '.$addField. ' to Grid Rows');
                    }
                    $fieldCounter+=2;
                    $addField++;
                    $removeField += 1;
                }
                $I->clicked("(//span[normalize-space()='Grid Rows']/following::i[contains(@class,'el-icon-minus')])[$removeField]", 'Remove Field no '.$removeField);
            }


            if ($basicOperand['requiredMessage']) { // Required Message
                $I->clicked(GeneralFields::radioSelect('Required',1),'Mark Yes from Required because by default it is No');
                if ($I->checkElement("//div[contains(@class, 'is-checked') and @role='switch']")){
                    $I->clickByJS("//div[contains(@class, 'is-checked') and @role='switch']",'Enable custom error message');
                }
                $I->filledField(GeneralFields::customizationFields('Custom Error Message'), $basicOperand['requiredMessage'], 'Fill As custom Required Message');
            }
        }

        //                                           Advanced options                                              //

        if (isset($advancedOperand)) {
            $I->scrollTo(GeneralFields::advancedOptions);
            $I->clickByJS(GeneralFields::advancedOptions, 'Expand advanced options');
            $I->wait(2);

            $advancedOperand['containerClass'] // Container Class
                ? $I->filledField(GeneralFields::customizationFields('Container Class'), $advancedOperand['containerClass'], 'Fill As Container Class')
                : null;

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

    public function customizeGDPRAgreement(
        AcceptanceTester $I,
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
            'description' => false,
            'validationMessage' => false,
            'containerClass' => false,
        ];

        $advancedOptionsDefault = [
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

            if ($basicOperand['description']) { //description
                $I->filledField("//textarea[@class='el-textarea__inner']", $basicOperand['description'], 'Fill As Admin Field Label');
            }

            if ($basicOperand['validationMessage']) { // validation Message
                $I->clicked(GeneralFields::radioSelect('Required Validation Message',2),'Mark Yes from Required because by default it is No');
                $I->filledField(GeneralFields::customizationFields('Required Validation Message'), $basicOperand['validationMessage'], 'Fill As custom Required Message');
            }

            $basicOperand['containerClass'] // Container Class
                ? $I->filledField(GeneralFields::customizationFields('Container Class'), $basicOperand['containerClass'], 'Fill As Container Class')
                : null;

        }
//        dd("here");

        //                                             Advanced options                                                   //

        if (isset($advancedOperand)) {
            $I->clicked(GeneralFields::advancedOptions,'Expand advanced options');
            $I->wait(2);

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

    public function customizePassword(
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
            'placeholder' => false,
            'requiredMessage' => false,
        ];

        $advancedOptionsDefault = [
            'defaultValue' => false,
            'containerClass' => false,
            'elementClass' => false,
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

        if (isset($basicOperand)) {

            $basicOperand['adminFieldLabel'] // adminFieldLabel
                ? $I->filledField(GeneralFields::adminFieldLabel, $basicOperand['adminFieldLabel'], 'Fill As Admin Field Label')
                : null;

            $basicOperand['placeholder']
                ? $I->filledField(GeneralFields::placeholder, $basicOperand['placeholder'], 'Fill As Placeholder')
                : null;

            if ($basicOperand['requiredMessage']) { // Required Message
                $I->clicked(GeneralFields::radioSelect('Required',1),'Mark Yes from Required because by default it is No');
                if ($I->checkElement("//div[contains(@class, 'is-checked') and @role='switch']")){
                    $I->clickByJS("//div[contains(@class, 'is-checked') and @role='switch']",'Enable custom error message');
                }
                $I->filledField(GeneralFields::customizationFields('Custom Error Message'), $basicOperand['requiredMessage'], 'Fill As custom Required Message');
            }

//            if ($basicOperand['requiredMessage']) { // Required Message
//                $I->clicked(GeneralFields::radioSelect('Required',1),'Mark Yes from Required because by default it is No');
//                $I->clickByJS(GeneralFields::radioSelect('Error Message', 2),'Mark custom from Required because by default it is global');
//                $I->filledField(GeneralFields::customizationFields('Required'), $basicOperand['requiredMessage'], 'Fill As custom Required Message');
//            }
        }

        //                                           Advanced options                                              //

        if (isset($advancedOperand)) {
            $I->scrollTo(GeneralFields::advancedOptions);
            $I->clicked(GeneralFields::advancedOptions,'Expand advanced options');
            $I->wait(2);

            $advancedOperand['defaultValue']    // Default Value
                ? $I->filledField(GeneralFields::defaultField, $advancedOperand['defaultValue'], 'Fill As Default Value')
                : null;

            $advancedOperand['containerClass'] // Container Class
                ? $I->filledField(GeneralFields::customizationFields('Container Class'), $advancedOperand['containerClass'], 'Fill As Container Class')
                : null;

            $advancedOperand['elementClass'] // Element Class
                ? $I->filledField(GeneralFields::customizationFields('Element Class'), $advancedOperand['elementClass'], 'Fill As Element Class')
                : null;

            $advancedOperand['helpMessage'] // Help Message
                ? $I->filledField("//textarea[@class='el-textarea__inner']", $advancedOperand['helpMessage'], 'Fill As Help Message')
                : null;

            $advancedOperand['nameAttribute'] // Name Attribute
                ? $I->filledField(GeneralFields::customizationFields('Name Attribute'), $advancedOperand['nameAttribute'], 'Fill As Name Attribute')
                : null;

        }
        $I->clicked(FluentFormsSelectors::saveForm);

    }

    public function customiseRangeSlider(
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
            'defaultValue' => false,
            'minValue' => false,
            'maxValue' => false,
            'step' => false,
            'requiredMessage' => false,

        ];

        $advancedOptionsDefault = [
            'nameAttribute' => false,
            'helpMessage' => false,
            'containerClass' => false,
            'elementClass' => false,
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

            $basicOperand['defaultValue'] // Default Value
                ? $I->filledField(GeneralFields::defaultField, $basicOperand['defaultValue'], 'Fill As Default Value')
                : null;

            $basicOperand['minValue']   // Min Value
                ? $I->filledField("(//input[@type='number'])[1]", $basicOperand['minValue'], 'Fill As Min Value')
                : null;

            $basicOperand['maxValue']   // Max Value
                ? $I->filledField("(//input[@type='number'])[2]", $basicOperand['maxValue'], 'Fill As Max Value')
                : null;

            $basicOperand['step']      // Step
                ? $I->filledField(GeneralFields::customizationFields('Step'), $basicOperand['step'], 'Fill As Step')
                : null;

            if ($basicOperand['requiredMessage']) { // Required Message
                $I->clicked(GeneralFields::radioSelect('Required',1),'Mark Yes from Required because by default it is No');
                if ($I->checkElement("//div[contains(@class, 'is-checked') and @role='switch']")){
                    $I->clickByJS("//div[contains(@class, 'is-checked') and @role='switch']",'Enable custom error message');
                }
                $I->filledField(GeneralFields::customizationFields('Custom Error Message'), $basicOperand['requiredMessage'], 'Fill As custom Required Message');
            }

        }
        //                                           Advanced options                                              //

        if (isset($advancedOperand)) {
            $I->scrollTo(GeneralFields::advancedOptions);
            $I->clickByJS(GeneralFields::advancedOptions, 'Expand advanced options');
            $I->wait(2);

            $advancedOperand['nameAttribute'] // Name Attribute
                ? $I->filledField(GeneralFields::customizationFields('Name Attribute'), $advancedOperand['nameAttribute'], 'Fill As Name Attribute')
                : null;

            $advancedOperand['helpMessage'] // Help Message
                ? $I->filledField("(//textarea[@class='el-textarea__inner'])", $advancedOperand['helpMessage'], 'Fill As Help Message')
                : null;

            $advancedOperand['containerClass'] // Container Class
                ? $I->filledField(GeneralFields::customizationFields('Container Class'), $advancedOperand['containerClass'], 'Fill As Container Class')
                : null;

            $advancedOperand['elementClass'] // Element Class
                ? $I->filledField(GeneralFields::customizationFields('Element Class'), $advancedOperand['elementClass'], 'Fill As Element Class')
                : null;


        }
        $I->clicked(FluentFormsSelectors::saveForm);
    }

    public function customizeNetPrompterScore(
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
            'requiredMessage' => false,
            'promoterStartText' => false,
            'promoterEndText' => false,
        ];

        $advancedOptionsDefault = [
            'nameAttribute' => false,
            'helpMessage' => false,
            'containerClass' => false,
            'elementClass' => false,
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

            if ($basicOperand['requiredMessage']) { // Required Message
                $I->clicked(GeneralFields::radioSelect('Required',1),'Mark Yes from Required because by default it is No');
                if ($I->checkElement("//div[contains(@class, 'is-checked') and @role='switch']")){
                    $I->clickByJS("//div[contains(@class, 'is-checked') and @role='switch']",'Enable custom error message');
                }
                $I->filledField(GeneralFields::customizationFields('Custom Error Message'), $basicOperand['requiredMessage'], 'Fill As custom Required Message');
            }

            $basicOperand['promoterStartText']      // Promoter Start Text
                ? $I->filledField(GeneralFields::customizationFields('Promoter Start Text'), $basicOperand['promoterStartText'], 'Fill as net promoter start text')
                : null;

            $basicOperand['promoterEndText']      // Promoter End Text
                ? $I->filledField(GeneralFields::customizationFields('Promoter End Text'), $basicOperand['promoterEndText'], 'Fill as net promoter end text')
                : null;



        }
        //                                           Advanced options                                              //

        if (isset($advancedOperand)) {
            $I->scrollTo(GeneralFields::advancedOptions);
            $I->clickByJS(GeneralFields::advancedOptions, 'Expand advanced options');
            $I->wait(2);

            $advancedOperand['nameAttribute'] // Name Attribute
                ? $I->filledField(GeneralFields::customizationFields('Name Attribute'), $advancedOperand['nameAttribute'], 'Fill As Name Attribute')
                : null;

            $advancedOperand['helpMessage'] // Help Message
                ? $I->filledField("(//textarea[@class='el-textarea__inner'])", $advancedOperand['helpMessage'], 'Fill As Help Message')
                : null;

            $advancedOperand['containerClass'] // Container Class
                ? $I->filledField(GeneralFields::customizationFields('Container Class'), $advancedOperand['containerClass'], 'Fill As Container Class')
                : null;

            $advancedOperand['elementClass'] // Element Class
                ? $I->filledField(GeneralFields::customizationFields('Element Class'), $advancedOperand['elementClass'], 'Fill As Element Class')
                : null;

        }
        $I->clicked(FluentFormsSelectors::saveForm);

    }

    public function customizeRepeatField(
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
            'repeatFieldColumns' => false,
        ];

        $advancedOptionsDefault = [
            'elementClass' => false,
            'nameAttribute' => false,
            'maxRepeatInputs' => false,
        ];

        if (!is_null($basicOptions)) {
            $basicOperand = array_merge($basicOptionsDefault, $basicOptions);
        }

        if (!is_null($advancedOptions)) {
            $advancedOperand = array_merge($advancedOptionsDefault, $advancedOptions);
        }

        //                                           Basic options                                              //
        if (isset($basicOperand) && $basicOperand['adminFieldLabel']) {
            $I->filledField(GeneralFields::adminFieldLabel, $basicOperand['adminFieldLabel'], 'Fill As Admin Field Label');
        }

        // this function will be called locally to fill address fields
        $addressFieldLocalFunction = function (AcceptanceTester $I, $whichName, $nameArea) {
            // Address Fields
            if (isset($whichName)) {
                $name = $whichName;

                if ($nameArea == 1){ // address line 1
                    $I->clicked("(//i[contains(@class,'el-icon-caret-bottom')])[1]", 'To expand Address Line 1 area');
                }elseif ($nameArea == 2){ // address line 2
                    $I->clickByJS("(//i[contains(@class,'el-icon-caret-bottom')])[2]", 'To expand Address Line 2 area');
                }elseif ($nameArea == 3){ // city
                    $I->clicked("(//i[contains(@class,'el-icon-caret-bottom')])[3]", 'To expand City area');
                }elseif ($nameArea == 4) { // state
                    $I->clicked("(//i[contains(@class,'el-icon-caret-bottom')])[4]", 'To expand State area');
                }elseif ($nameArea == 5) { // zip
                    $I->clicked("(//i[contains(@class,'el-icon-caret-bottom')])[5]", 'To expand Zip area');
                }elseif ($nameArea == 6) { // country
                    $I->clicked("(//i[contains(@class,'el-icon-caret-bottom')])[6]", 'To expand Country area');
                }

                $fieldData = [
                    'Label' => $name['label'] ?? false,
                    'Default' => $name['default'] ?? false,
                    'Placeholder' => $name['placeholder'] ?? false,
                    'Help Message' => $name['helpMessage'] ?? false,
                    'Custom' => $name['required'] ?? false,
                ];

                foreach ($fieldData as $key => $value) {
                    // Check if "Default" has a value and "Placeholder" is empty, or vice versa.
//                    if (($key == 'Default' && isset($fieldData['Placeholder']) && empty($fieldData['Placeholder'])) ||
//                        ($key == 'Placeholder' && isset($fieldData['Default']) && empty($fieldData['Default']))) {
//                        continue; // Skip this iteration of the loop.
//                    }
                    if ($key == "Custom") {
                        $I->clicked(GeneralFields::isRequire($nameArea));
                        if ($I->checkElement("(//div[contains(@class, 'is-checked') and @role='switch'])[1]")){
                            $I->clickByJS("(//div[contains(@class, 'is-checked') and @role='switch'])[1]",'Enable custom error message');
                        }
                    }

//                    if ($key == "Error Message") {
//                        $I->clickByJS(GeneralFields::isRequire($nameArea));
//                        $I->clickByJS(GeneralFields::isRequire($nameArea,4));
//                    }

                    if ($nameArea == 6 && $key == 'Default' && !empty($value)){
                        $I->clicked("//input[@id='settings_country_list']",'Expand country list');
                        $I->clickByJS("//span[normalize-space()='$value']");

                    }elseif ($nameArea == 6 && $key == 'Help Message'){
                        continue;
                    }else{
                        if ($value){
                            $I->filledField(GeneralFields::nameFieldSelectors($nameArea, $key), $value);
                        }
                    }
                }
            }
        };

        // calling local function, reverse order for scrolling issue
        $addressFieldLocalFunction($I, $basicOperand['country'], 6,);
        $addressFieldLocalFunction($I, $basicOperand['zip'], 5,);
        $addressFieldLocalFunction($I, $basicOperand['state'], 4,);
        $addressFieldLocalFunction($I, $basicOperand['city'], 3,);
        $addressFieldLocalFunction($I, $basicOperand['addressLine2'], 2,);
        $addressFieldLocalFunction($I, $basicOperand['addressLine1'], 1,);


        // Label Placement (Hidden Label)
        if ($isHiddenLabel) {
            $I->clicked("(//span[normalize-space()='Hide Label'])[1]");
        }

        //                                           Advanced options                                              //

        if (isset($advancedOperand)) {
            $I->clicked(GeneralFields::advancedOptions);

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

}