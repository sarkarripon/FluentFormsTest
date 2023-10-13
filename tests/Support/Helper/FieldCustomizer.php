<?php

namespace Tests\Support\Helper;

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

    public function customizeNameFields(AcceptanceTester $I,
                                        $fieldName,
                                        ?array $basicOptions = null,
                                        ?array $advancedOptions = null,
                                        ?bool $isDefault = false): void
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
            'inventorySettings' => false,
        ];

        if (!is_null($basicOptions)) {
            $basicOperand = array_merge($basicOptionsDefault, $basicOptions);
        }

        if (!is_null($advancedOptions)) {
            $advancedOperand = array_merge($advancedOptionsDefault, $advancedOptions);
        }

//        dd($basicOperand['firstName']);

        //                                           Basic options                                              //
        // adminFieldLabel
        if (isset($basicOperand) && $basicOperand['adminFieldLabel']) {
            $I->filledField(GeneralFields::adminFieldLabel,
                !empty($basicOperand['adminFieldLabel']) ? $basicOperand['adminFieldLabel'] : $fieldName, 'As Admin Field Label');
        }

        $nameFieldLocalFunction = function (AcceptanceTester $I, $whichName, $nameArea, $whatRequire){
            // Name Fields
            if (isset($whichName)) {
                $firstName = $whichName;
                $I->clicked("(//i[contains(@class,'el-icon-caret-bottom')])[1]", 'To expand First Name field');
                $fieldData = [
                    'Label' => $firstName['label'] ?? null,
                    'Default' => $firstName['default'] ?? null,
                    'Placeholder' => $firstName['placeholder'] ?? null,
                    'Help Message' => $firstName['helpMessage'] ?? null,
                    'Error Message' => $firstName['required'] ?? null,
                ];

                foreach ($fieldData as $key => $value) {
                    // Check if "Default" has a value and "Placeholder" is empty, or vice versa.
                    if (($key == 'Default' && isset($fieldData['Placeholder']) && empty($fieldData['Placeholder'])) ||
                        ($key == 'Placeholder' && isset($fieldData['Default']) && empty($fieldData['Default']))) {
                        continue; // Skip this iteration of the loop.
                    }

                    if ($key == "Error Message") {
                        $I->clicked(GeneralFields::isRequire($whatRequire));
                    }
                    $I->fillField(GeneralFields::nameFieldSelectors($nameArea, $key), $value ?? "");
                }
            }

        };
        $this->$nameFieldLocalFunction($I, $basicOperand['firstName'], 1);
        $this->$nameFieldLocalFunction($I, $basicOperand['middleName'], 3);
        $this->$nameFieldLocalFunction($I, $basicOperand['lastName'], 5);



//        // Name Fields
//        if (isset($basicOperand) && $basicOperand['firstName']) {
//            $firstName = $basicOperand['firstName'];
//            $I->clicked("(//i[contains(@class,'el-icon-caret-bottom')])[1]",'To expand First Name field');
//            $fieldData = [
//                'Label' => $firstName['label'],
//                'Default' => $firstName['default'],
//                'Placeholder' => $firstName['placeholder'],
//                'Help Message' => $firstName['helpMessage'],
//                'Error Message' => $firstName['required'],
//            ];
//
//            foreach ($fieldData as $key => $value) {
//                if ($key=="Error Message"){
//                    $I->clicked(GeneralFields::isRequire(1));
//                }
//
//                $I->fillField(GeneralFields::nameFieldSelectors(1, $key), $value ? $value : "");
//            }
//        }


    }

    public function customizeEmail()
    {

    }

    public function customizeSimpleText()
    {

    }

    public function customizeMaskInput()
    {

    }

    public function customizeTextArea()
    {

    }

    public function customizeAddressFields()
    {

    }

    public function customizeCountryList()
    {

    }

    public function customizeNumericField()
    {

    }

    public function customizeDropdown()
    {

    }

    public function customizeRadioField()
    {

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
    public function customizeCheckBox(AcceptanceTester $I, $fieldName, array $basicOptions = null, array $advancedOptions = null): void
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