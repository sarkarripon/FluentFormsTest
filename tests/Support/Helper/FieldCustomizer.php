<?php

namespace Tests\Support\Helper;

use PhpParser\Node\Expr\Exit_;
use Tests\Support\AcceptanceTester;
use Tests\Support\Selectors\FluentFormsSelectors;
use Tests\Support\Selectors\GeneralFields;

trait FieldCustomizer
{
    function convertToIndexArray($customName): array
    {
        $indexArray = [];
        foreach ($customName as $key => $value) {
            if (is_array($value)) {
                $indexArray = array_merge($indexArray, $value);
            } else {
                $indexArray[] = $value;
            }
        }
        return $indexArray;
    }
//    public function buildArrayWithKey(array $customName): array
//    {
//        $new = [];
//        foreach ($customName as $key => $value) {
//            if ($key !== 'email') {
//                if (is_array($value)) {
//                    foreach ($value as $item) {
//                        $new[$item] = $item;
//                    }
//                } else {
//                    $new[$value] = $value;
//                }
//            }
//        }
//        return $new;
//    }
    public function buildArrayWithKey(array $customName): array
    {
        $new = [];
        foreach ($customName as $key => $value) {
            if ($key !== 'email') {
                if (is_array($value)) {
                    foreach ($value as $item) {
                        $new[$item] = $item;
                    }
                } elseif ($key === 'nameFields') {
                    $new['First Name'] = 'First Name';
                    $new['Last Name'] = 'Last Name';
                } else {
                    $new[$value] = $value;
                }
            }
        }

        return $new;
    }

    public function customizeNameFields
    (AcceptanceTester $I,
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
            'firstName' => false,
            'middleName' => false,
            'lastName' => false
        ];

        $advancedOptionsDefault = [
            'containerClass' => false,
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
        if (isset($basicOperand) && $basicOperand['adminFieldLabel']) {
            $I->filledField(GeneralFields::adminFieldLabel, $basicOperand['adminFieldLabel'], 'Fill As Admin Field Label');
        }

        $nameFieldLocalFunction = function (AcceptanceTester $I, $whichName, $nameArea){
            // Name Fields
            if (isset($whichName)) {

                $name = $whichName;

                if ($nameArea == 1){
                    $I->clicked("(//i[contains(@class,'el-icon-caret-bottom')])[1]", 'To expand First Name field');
                }elseif ($nameArea == 3){
                    $I->clicked("(//span[@class='el-checkbox__inner'])[2]", 'To enable Middle Name field');
                    $I->clickByJS("(//i[contains(@class,'el-icon-caret-bottom')])[2]", 'To expand Middle Name field');
                }elseif ($nameArea == 5){
                    $I->clicked("(//i[contains(@class,'el-icon-caret-bottom')])[3]", 'To expand Last Name field');
                }
                $fieldData = [
                    'Label' => $name['label'] ?? null,
                    'Default' => $name['default'] ?? null,
                    'Placeholder' => $name['placeholder'] ?? null,
                    'Help Message' => $name['helpMessage'] ?? null,
                    'Error Message' => $name['required'] ?? null,
                ];

                foreach ($fieldData as $key => $value) {
                    // Check if "Default" has a value and "Placeholder" is empty, or vice versa.
                    if (($key == 'Default' && isset($fieldData['Placeholder']) && empty($fieldData['Placeholder'])) ||
                        ($key == 'Placeholder' && isset($fieldData['Default']) && empty($fieldData['Default']))) {
                        continue; // Skip this iteration of the loop.
                    }

                    if ($key == "Error Message") {
                        $I->clicked(GeneralFields::isRequire($nameArea));
                    }
                    $I->filledField(GeneralFields::nameFieldSelectors($nameArea, $key), $value ?? "");
                }
            }

        };
        // calling local function, reverse order for scrolling issue
        $nameFieldLocalFunction($I, $basicOperand['lastName'], 5,);
        $nameFieldLocalFunction($I, $basicOperand['middleName'], 3,);
        $nameFieldLocalFunction($I, $basicOperand['firstName'], 1,);

        // Label Placement (Hidden Label)
        if ($isHiddenLabel) {
            $I->clicked("(//span[normalize-space()='Hide Label'])[1]");
        }

        //                                           Advanced options                                              //

        if (isset($advancedOperand)) {
            $I->clicked(GeneralFields::advancedOptions);
            $I->fillField("(//span[normalize-space()='Container Class']/following::input[@type='text'])[1]",
                $advancedOperand['containerClass'] ?? $fieldName);

            $I->filledField("(//span[normalize-space()='Name Attribute']/following::input[@type='text'])[1]",
                $advancedOperand['nameAttribute'] ?? $fieldName);
            }

        $I->clicked(FluentFormsSelectors::saveForm);
    }

    public function customizeEmail(
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
            'validationMessage' => false,
        ];

        $advancedOptionsDefault = [
            'defaultValue' => false,
            'containerClass' => false,
            'elementClass' => false,
            'helpMessage' => false,
            'duplicateValidationMessage' => false,
            'prefixLabel' => false,
            'suffixLabel' => false,
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
            // adminFieldLabel
            $basicOperand['adminFieldLabel']
            ? $I->filledField(GeneralFields::adminFieldLabel, $basicOperand['adminFieldLabel'], 'Fill As Admin Field Label')
            : null;
            $basicOperand['placeholder'] //Placeholder
            ? $I->filledField(GeneralFields::placeholder, $basicOperand['placeholder'], 'Fill As Placeholder')
            : null;
//         Required Message
        if ($basicOperand['requiredMessage']) {
            $I->clicked(GeneralFields::radioSelect('Required'),'Select Required');
            $I->clicked(GeneralFields::radioSelect('Error Message', 2),'Select Required');
            $I->filledField(GeneralFields::customizationFields('Required'), $basicOperand['requiredMessage'], 'Fill As Required Message');
        }
//         Validation Message
            $basicOperand['validationMessage']
            ? $I->filledField(GeneralFields::customizationFields('Validation Message'), $basicOperand['validationMessage'], 'Fill As Email Validation Message')
            : null;
        }

        //                                           Advanced options                                              //

        if (isset($advancedOperand)) {
            $I->scrollTo(GeneralFields::advancedOptions);
            $I->clicked(GeneralFields::advancedOptions,'Expand advanced options');
            $I->wait(2);

            $advancedOperand['defaultValue'] // Default Value
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

            // Duplicate Validation Message
            if ($advancedOperand['duplicateValidationMessage']) {
                $I->clicked(GeneralFields::checkboxSelect(),'Select Duplicate Validation Message');
                $I->clicked(GeneralFields::radioSelect('Error Message', 2),'Select Required');
                $I->filledField(GeneralFields::customizationFields('Validation Message for Duplicate'),
                    $advancedOperand['duplicateValidationMessage'], 'Fill As Duplicate Validation Message');
            }
            $advancedOperand['prefixLabel'] // Prefix Label
            ? $I->filledField(GeneralFields::customizationFields('Prefix Label'), $advancedOperand['prefixLabel'], 'Fill As Prefix Label')
            : null;

            $advancedOperand['suffixLabel'] // Suffix Label
            ? $I->filledField(GeneralFields::customizationFields('Suffix Label'), $advancedOperand['suffixLabel'], 'Fill As Suffix Label')
            : null;

            $advancedOperand['nameAttribute'] // Name Attribute
            ? $I->filledField(GeneralFields::customizationFields('Name Attribute'), $advancedOperand['nameAttribute'], 'Fill As Name Attribute')
            : null;

        }
        $I->clicked(FluentFormsSelectors::saveForm);
    }

    public function customizeSimpleText(
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
            'prefixLabel' => false,
            'suffixLabel' => false,
            'nameAttribute' => false,
            'maxLength' => false,
            'uniqueValidationMessage' => false,
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
                $I->clicked(GeneralFields::radioSelect('Required'),'Select Required');
                $I->filledField(GeneralFields::customizationFields('Error Message'), $basicOperand['requiredMessage'], 'Fill As Required Message');
            }
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

            $advancedOperand['prefixLabel'] // Prefix Label
                ? $I->filledField(GeneralFields::customizationFields('Prefix Label'), $advancedOperand['prefixLabel'], 'Fill As Prefix Label')
                : null;

            $advancedOperand['suffixLabel'] // Suffix Label
                ? $I->filledField(GeneralFields::customizationFields('Suffix Label'), $advancedOperand['suffixLabel'], 'Fill As Suffix Label')
                : null;

            $advancedOperand['nameAttribute'] // Name Attribute
                ? $I->filledField(GeneralFields::customizationFields('Name Attribute'), $advancedOperand['nameAttribute'], 'Fill As Name Attribute')
                : null;

            $advancedOperand['maxLength'] // Max Length
                ? $I->filledField("//input[@type='number']", $advancedOperand['maxLength'], 'Fill As Max text Length')
                : null;

            // Unique Validation Message
            if ($advancedOperand['uniqueValidationMessage']) {
                $I->clicked(GeneralFields::checkboxSelect(),'Validate as Unique');
                $I->filledField(GeneralFields::customizationFields('Validation Message for Duplicate'),
                    $advancedOperand['uniqueValidationMessage'], 'Fill As Unique Validation Message');
            }
        }
        $I->clicked(FluentFormsSelectors::saveForm);
    }

    public function customizeMaskInput(
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
            'maskInput' => false,
            'requiredMessage' => false,
        ];

        $advancedOptionsDefault = [
            'defaultValue' => false,
            'containerClass' => false,
            'elementClass' => false,
            'helpMessage' => false,
            'prefixLabel' => false,
            'suffixLabel' => false,
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

            $basicOperand['adminFieldLabel']   // adminFieldLabel
                ? $I->filledField(GeneralFields::adminFieldLabel, $basicOperand['adminFieldLabel'], 'Fill As Admin Field Label')
                : null;

            $basicOperand['placeholder'] // Placeholder
                ? $I->filledField(GeneralFields::placeholder, $basicOperand['placeholder'], 'Fill As Placeholder')
                : null;

            if ($basicOperand['requiredMessage']) { // Required Message
                $I->clicked(GeneralFields::radioSelect('Required'),'Select Required');
                $I->clicked(GeneralFields::radioSelect('Error Message', 2),'Select custom');
                $I->filledField(GeneralFields::customizationFields('Error Message'), $basicOperand['requiredMessage'], 'Fill As Required Message');
            }
        }

        //                                           Advanced options                                              //

        if (isset($advancedOperand)) {
            $I->scrollTo(GeneralFields::advancedOptions);
            $I->clicked(GeneralFields::advancedOptions, 'Expand advanced options');
            $I->wait(2);

            $advancedOperand['defaultValue'] // Default Value
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

            $advancedOperand['prefixLabel'] // Prefix Label
                ? $I->filledField(GeneralFields::customizationFields('Prefix Label'), $advancedOperand['prefixLabel'], 'Fill As Prefix Label')
                : null;

            $advancedOperand['suffixLabel'] // Suffix Label
                ? $I->filledField(GeneralFields::customizationFields('Suffix Label'), $advancedOperand['suffixLabel'], 'Fill As Suffix Label')
                : null;

            $advancedOperand['nameAttribute'] // Name Attribute
                ? $I->filledField(GeneralFields::customizationFields('Name Attribute'), $advancedOperand['nameAttribute'], 'Fill As Name Attribute')
                : null;

            $advancedOperand['maxLength'] // Max Length
                ? $I->filledField("//input[@type='number']", $advancedOperand['maxLength'], 'Fill As Max text Length')
                : null;

            if (isset($advancedOperand['uniqueValidationMessage'])) { // Unique Validation Message
                $I->clicked(GeneralFields::checkboxSelect(), 'Validate as Unique');
                $I->clicked(GeneralFields::radioSelect('Error Message', 2),'Select Required');
                $I->filledField(GeneralFields::customizationFields('Validation Message for Duplicate'), $advancedOperand['uniqueValidationMessage'], 'Fill As Unique Validation Message');
            }
        }
        $I->clicked(FluentFormsSelectors::saveForm);
    }

    public function customizeTextArea(
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
            'rows' => false,
            'columns' => false,
            'requiredMessage' => false,
        ];

        $advancedOptionsDefault = [
            'defaultValue' => false,
            'containerClass' => false,
            'elementClass' => false,
            'helpMessage' => false,
            'nameAttribute' => false,
            'maxLength' => false,
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

            $basicOperand['placeholder'] //Placeholder
            ? $I->filledField(GeneralFields::placeholder, $basicOperand['placeholder'], 'Fill As Placeholder')
            : null;
            $basicOperand['rows'] //Rows
            ? $I->filledField(GeneralFields::customizationFields('Rows'), $basicOperand['rows'], 'Fill As Rows')
            : null;

            $basicOperand['columns'] //Columns
            ? $I->filledField(GeneralFields::customizationFields('Columns'), $basicOperand['columns'], 'Fill As Columns')
            : null;

            if ($basicOperand['requiredMessage']) { //Required Message
                $I->clicked(GeneralFields::radioSelect('Required'),'Select Required');
                $I->clicked(GeneralFields::radioSelect('Error Message', 2),'Select Required');
                $I->filledField(GeneralFields::customizationFields('Required'), $basicOperand['requiredMessage'], 'Fill As Required Message');
            }
        }

        //                                           Advanced options                                              //

        if (isset($advancedOperand)) {
            $I->scrollTo(GeneralFields::advancedOptions);
            $I->clicked(GeneralFields::advancedOptions, 'Expand advanced options');
            $I->wait(2);

            $advancedOperand['defaultValue'] // Default Value
                ? $I->filledField("(//textarea[@class='el-textarea__inner'])[2]", $advancedOperand['defaultValue'], 'Fill As Default Value')
                : null;

            $advancedOperand['containerClass'] // Container Class
                ? $I->filledField(GeneralFields::customizationFields('Container Class'), $advancedOperand['containerClass'], 'Fill As Container Class')
                : null;

            $advancedOperand['elementClass'] // Element Class
                ? $I->filledField(GeneralFields::customizationFields('Element Class'), $advancedOperand['elementClass'], 'Fill As Element Class')
                : null;

            $advancedOperand['helpMessage'] // Help Message
                ? $I->filledField("(//textarea[@class='el-textarea__inner'])[3]", $advancedOperand['helpMessage'], 'Fill As Help Message')
                : null;

            $advancedOperand['nameAttribute'] // Name Attribute
                ? $I->filledField(GeneralFields::customizationFields('Name Attribute'), $advancedOperand['nameAttribute'], 'Fill As Name Attribute')
                : null;

            $advancedOperand['maxLength'] // Max Length
                ? $I->filledField("//input[@type='number']", $advancedOperand['maxLength'], 'Fill As Max text Length')
                : null;
        }
        $I->clicked(FluentFormsSelectors::saveForm);
    }

    public function customizeAddressFields()
    {

    }

    public function customizeCountryList()
    {

    }

    public function customizeNumericField(
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
            'minValue' => false,
            'maxValue' => false,
            'digits' => false,
            'numberFormat' => false,

        ];

        $advancedOptionsDefault = [
            'defaultValue' => false,
            'containerClass' => false,
            'elementClass' => false,
            'helpMessage' => false,
            'step' => false,
            'prefixLabel' => false,
            'suffixLabel' => false,
            'nameAttribute' => false,
            'calculation' => false,
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

            $basicOperand['placeholder'] //Placeholder
                ? $I->filledField(GeneralFields::placeholder, $basicOperand['placeholder'], 'Fill As Placeholder')
                : null;

            if ($basicOperand['requiredMessage']) { //Required Message
                $I->clicked(GeneralFields::radioSelect('Required'),'Select Required');
                $I->clickByJS(GeneralFields::radioSelect('Error Message', 2),'Select error message type');
                $I->filledField(GeneralFields::customizationFields('Required'), $basicOperand['requiredMessage'], 'Fill As Required Message');
            }
            $basicOperand['minValue']   // Min Value
                ? $I->filledField("(//input[@type='number'])[2]", $basicOperand['minValue'], 'Fill As Min Value')
                : null;

            $basicOperand['maxValue']   // Max Value
                ? $I->filledField("(//input[@type='number'])[3]", $basicOperand['maxValue'], 'Fill As Max Value')
                : null;

            $basicOperand['digits']   // Digits
                ? $I->filledField("(//input[@type='number'])[4]", $basicOperand['digits'], 'Fill As Digits')
                : null;
        }
        //                                           Advanced options                                              //

        if (isset($advancedOperand)) {
            $I->scrollTo(GeneralFields::advancedOptions);
            $I->clickByJS(GeneralFields::advancedOptions, 'Expand advanced options');
            $I->wait(2);

            $advancedOperand['defaultValue'] // Default Value
                ? $I->filledField(GeneralFields::defaultField, $advancedOperand['defaultValue'], 'Fill As Default Value')
                : null;

            $advancedOperand['containerClass'] // Container Class
                ? $I->filledField(GeneralFields::customizationFields('Container Class'), $advancedOperand['containerClass'], 'Fill As Container Class')
                : null;

            $advancedOperand['elementClass'] // Element Class
                ? $I->filledField(GeneralFields::customizationFields('Element Class'), $advancedOperand['elementClass'], 'Fill As Element Class')
                : null;

            $advancedOperand['helpMessage'] // Help Message
                ? $I->filledField("(//textarea[@class='el-textarea__inner'])", $advancedOperand['helpMessage'], 'Fill As Help Message')
                : null;

            $advancedOperand['step']      // Step
                ? $I->filledField(GeneralFields::customizationFields('Step'), $advancedOperand['step'], 'Fill As Step')
                : null;

            $advancedOperand['prefixLabel'] // Prefix Label
                ? $I->filledField(GeneralFields::customizationFields('Prefix Label'), $advancedOperand['prefixLabel'], 'Fill As Prefix Label')
                : null;

            $advancedOperand['suffixLabel'] // Suffix Label
                ? $I->filledField(GeneralFields::customizationFields('Suffix Label'), $advancedOperand['suffixLabel'], 'Fill As Suffix Label')
                : null;

            $advancedOperand['nameAttribute'] // Name Attribute
                ? $I->filledField(GeneralFields::customizationFields('Name Attribute'), $advancedOperand['nameAttribute'], 'Fill As Name Attribute')
                : null;

        }
        $I->clicked(FluentFormsSelectors::saveForm);
    }

    public function customizeDropdown(
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
            'options' => false,
            'shuffleOption' => false,
            'searchableOption' => false,
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
        // adminFieldLabel
        if (isset($basicOperand)) {
            $basicOperand['adminFieldLabel']
                ? $I->filledField(GeneralFields::adminFieldLabel, $basicOperand['adminFieldLabel'], 'Fill As Admin Field Label')
                : null;

            $basicOperand['placeholder'] //Placeholder
                ? $I->filledField(GeneralFields::placeholder, $basicOperand['placeholder'], 'Fill As Placeholder')
                : null;

            if ($basicOperand['options']) { // configure options

                global $removeField;
                $removeField = 1;
                $fieldCounter = 1;

                foreach ($basicOperand['options'] as $fieldContents) {

                    $value = $fieldContents['value'] ?? null;
                    $label = $fieldContents['label'] ?? null;
                    $calcValue = $fieldContents['calcValue'] ?? null;

                    $label
                        ? $I->filledField("(//input[@placeholder='label'])[$fieldCounter]", $label, 'Fill As Label')
                        : null;

                    if (isset($value)) {
                        if ($fieldCounter === 1) {
                            $I->clicked("(//span[@class='el-checkbox__inner'])[1]", 'Select Show Values');
                        }
                        $I->filledField("(//input[@placeholder='value'])[$fieldCounter]", $value, 'Fill As Value');
                    }
                    if (isset($calcValue)) {
                        if ($fieldCounter === 1) {
                            $I->clicked("(//span[@class='el-checkbox__inner'])[2]", 'Select Calc Values');
                        }
                        $I->filledField("(//input[@placeholder='calc value'])[$fieldCounter]", $calcValue, 'Fill As calc Value');
                    }

                    if ($fieldCounter >= 2) {
                        $I->clickByJS(FluentFormsSelectors::addField($fieldCounter), 'Add Field');
                    }
                    $fieldCounter++;
                    $removeField += 1;
                }
            }
            $I->clicked(FluentFormsSelectors::removeField($removeField));

            if ($basicOperand['shuffleOption']) { // Shuffle Option
                $I->clicked("(//span[@class='el-checkbox__inner'])[3]", 'Select Shuffle Option');
            }
            if ($basicOperand['searchableOption']) { // Searchable Option
                $I->clicked("(//span[@class='el-checkbox__inner'])[4]", 'Select Searchable Option');
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

            $advancedOperand['defaultValue'] // Default Value
                ? $I->filledField(GeneralFields::defaultField, $advancedOperand['defaultValue'], 'Fill As Default Value')
                : null;

            $advancedOperand['containerClass'] // Container Class
                ? $I->filledField(GeneralFields::customizationFields('Container Class'), $advancedOperand['containerClass'], 'Fill As Container Class')
                : null;

            $advancedOperand['elementClass'] // Element Class
                ? $I->filledField(GeneralFields::customizationFields('Element Class'), $advancedOperand['elementClass'], 'Fill As Element Class')
                : null;

            $advancedOperand['helpMessage'] // Help Message
                ? $I->filledField("(//textarea[@class='el-textarea__inner'])", $advancedOperand['helpMessage'], 'Fill As Help Message')
                : null;

            $advancedOperand['nameAttribute'] // Name Attribute
                ? $I->filledField(GeneralFields::customizationFields('Name Attribute'), $advancedOperand['nameAttribute'], 'Fill As Name Attribute')
                : null;
        }

        $I->clicked(FluentFormsSelectors::saveForm);
        $I->seeSuccess('The form is successfully updated.');

    }

    public function customizeRadioField(
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
            'shuffleOption' => false,
            'requiredMessage' => false,
        ];

        $advancedOptionsDefault = [
            'defaultValue' => false,
            'containerClass' => false,
            'helpMessage' => false,
            'nameAttribute' => false,
            'layout' => false,
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

            $basicOperand['placeholder'] //Placeholder
                ? $I->filledField(GeneralFields::placeholder, $basicOperand['placeholder'], 'Fill As Placeholder')
                : null;

            if ($basicOperand['options']) { // configure options

                global $removeField;
                $removeField = 1;
                $fieldCounter = 1;

                foreach ($basicOperand['options'] as $fieldContents) {

                    $value = $fieldContents['value'] ?? null;
                    $label = $fieldContents['label'] ?? null;
                    $calcValue = $fieldContents['calcValue'] ?? null;

                    $label
                        ? $I->filledField("(//input[@placeholder='label'])[$fieldCounter]", $label, 'Fill As Label')
                        : null;

                    if (isset($value)) {
                        if ($fieldCounter === 1) {
                            $I->clicked("(//span[@class='el-checkbox__inner'])[1]", 'Select Show Values');
                        }
                        $I->filledField("(//input[@placeholder='value'])[$fieldCounter]", $value, 'Fill As Value');
                    }
                    if (isset($calcValue)) {
                        if ($fieldCounter === 1) {
                            $I->clicked("(//span[@class='el-checkbox__inner'])[2]", 'Select Calc Values');
                        }
                        $I->filledField("(//input[@placeholder='calc value'])[$fieldCounter]", $calcValue, 'Fill As calc Value');
                    }

                    if ($fieldCounter >= 2) {
                        $I->clickByJS(FluentFormsSelectors::addField($fieldCounter), 'Add Field');
                    }
                    $fieldCounter++;
                    $removeField += 1;
                }
            }
            $I->clicked(FluentFormsSelectors::removeField($removeField));

            if ($basicOperand['shuffleOption']) { // Shuffle Option
                $I->clicked("(//span[@class='el-checkbox__inner'])[3]", 'Select Shuffle Option');
            }
            if ($basicOperand['searchableOption']) { // Searchable Option
                $I->clicked("(//span[@class='el-checkbox__inner'])[4]", 'Select Searchable Option');
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

            $advancedOperand['defaultValue'] // Default Value
                ? $I->filledField(GeneralFields::defaultField, $advancedOperand['defaultValue'], 'Fill As Default Value')
                : null;

            $advancedOperand['containerClass'] // Container Class
                ? $I->filledField(GeneralFields::customizationFields('Container Class'), $advancedOperand['containerClass'], 'Fill As Container Class')
                : null;

            $advancedOperand['elementClass'] // Element Class
                ? $I->filledField(GeneralFields::customizationFields('Element Class'), $advancedOperand['elementClass'], 'Fill As Element Class')
                : null;

            $advancedOperand['helpMessage'] // Help Message
                ? $I->filledField("(//textarea[@class='el-textarea__inner'])", $advancedOperand['helpMessage'], 'Fill As Help Message')
                : null;

            $advancedOperand['nameAttribute'] // Name Attribute
                ? $I->filledField(GeneralFields::customizationFields('Name Attribute'), $advancedOperand['nameAttribute'], 'Fill As Name Attribute')
                : null;
        }

        $I->clicked(FluentFormsSelectors::saveForm);
        $I->seeSuccess('The form is successfully updated.');


    }

    /**
     * ```
     * $basicOptionsDefault = [
     * 'adminFieldLabel' => false,
     * 'options' => false
     * ];
     * ```
     *
     * @param AcceptanceTester $I
     * @param $fieldName
     * @param array|null $basicOptions
     * @param array|null $advancedOptions
     * @return void
     */
    public function customizeCheckBox(
        AcceptanceTester $I,
        $fieldName,
        array $basicOptions = null,
        array $advancedOptions = null): void
    {
        $I->clickOnExactText($fieldName);

        $basicOperand = null;
        $advancedOperand = null;

        $basicOptionsDefault = [
            'adminFieldLabel' => false,
            'options' => false
        ];

        $advancedOptionsDefault = [
            'inventorySettings' => false,
        ];

        if (!is_null($basicOptions)) {
            $basicOperand = array_merge($basicOptionsDefault, $basicOptions);
        }

        if (!is_null($advancedOptions)) {
            $advancedOperand = array_merge($advancedOptionsDefault, $advancedOptions);
        }

        //                                           Basic options                                              //
        // adminFieldLabel
        if (isset($basicOperand) && $basicOperand['adminFieldLabel']) {
            $I->filledField("//div[@prop='admin_field_label']//input[@type='text']",
                !empty($basicOperand['adminFieldLabel']) ? $basicOperand['adminFieldLabel'] : $fieldName);
        }
        // Options
        if (isset($basicOperand) && is_array($basicOperand['options'])) {

            global $removeField; $removeField = 1; $fieldCounter = 1;

            foreach ($basicOperand['options'] as $value) {
                $I->filledField("(//input[@placeholder='label'])[$fieldCounter]", $value);
                if ($fieldCounter >= 3) {
                    $I->clicked(FluentFormsSelectors::addField($fieldCounter));
                }
                $fieldCounter++; $removeField += 1;
            }

            $I->clicked(FluentFormsSelectors::removeField($removeField));
        }

        //                                       Advanced Options                                        //
        // Inventory Settings
        if (isset($advancedOperand) && is_array($advancedOperand['inventorySettings'])) {
            $I->retry(4,200);
            $I->clickByJS("(//h5[normalize-space()='Advanced Options'])[1]");
            $I->clickByJS("//div[normalize-space()='Inventory Settings']/following::span[normalize-space()='Enable']");

            $stockCounter = 1;
            foreach ($advancedOperand['inventorySettings'] as $value) {
                $I->filledField("(//input[@type='number'])[$stockCounter]", $value);
                $stockCounter++;
            }
        }
        $I->clicked(FluentFormsSelectors::saveForm);
    }

    public function customizeMultipleChoice()
    {

    }

    public function customizeWebsiteUrl()
    {

    }

    public function customizeTimeDate()
    {

    }

    public function customizeImageUpload()
    {

    }

    public function customizeFileUpload()
    {

    }

    public function customizeCustomHtml()
    {

    }

    public function customizePhone()
    {

    }

    public function customizeHiddenField()
    {

    }

    public function customizeSectionBreak()
    {

    }

    public function customizeShortCode()
    {

    }

    public function customizeTnC()
    {

    }

    public function customizeActionHook()
    {

    }

    public function customizeFormStep()
    {

    }

    public function customizeRating()
    {

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