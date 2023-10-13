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

    public function customizeNameFields(AcceptanceTester $I, $fieldName, ?array $basicOptions = null, ?array $advancedOptions = null)
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
        // Name Fields
        if (isset($basicOperand) && $basicOperand['firstName']) {
            $firstName = $basicOperand['firstName'];
            $firstNameFields = "";
            $flabelSelector = $firstNameFields . "[1]";
            $fdefaultSelector = "//div[@class='address-field-option__settings is-open']//form[@class='el-form el-form-nested el-form--label-top']//div[@class='el-form-item']//div[@class='el-form-item__content']//div//div[@class='el-input el-input-group el-input-group--append']//input[@type='text']";
            $fplaceholderSelector = $firstNameFields . "[3]";
            $fhelpSelector = $firstNameFields . "[4]";
            $ferrorMessageSelector = $firstNameFields . "[5]";

            $I->clicked("(//i[contains(@class,'el-icon-caret-bottom')])[1]",'To expand First Name field');

            $I->filledField($flabelSelector, $firstName['label']);
            $I->filledField($fdefaultSelector, $firstName['default'] ? $firstName['default'] : "");

            exit();

            $I->clickByJS("//div[normalize-space()='Name Fields']/following::span[normalize-space()='Enable']");
            $I->clickByJS("//div[normalize-space()='Name Fields']/following::span[normalize-space()='First Name']");
            $I->clickByJS("//div[normalize-space()='Name Fields']/following::span[normalize-space()='Last Name']");
        }


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