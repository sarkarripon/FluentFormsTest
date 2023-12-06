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

            $basicOperand['description'] //description
                ? $I->fillField("#tinymce p:first-child", $basicOperand['description'], 'Fill As description')
                : null;

            exit("Stop here");

            $basicOperand['defaultValue'] // Default Value
                ? $I->filledField(GeneralFields::defaultField, $basicOperand['defaultValue'], 'Fill As Default Value')
                : null;

            if ($basicOperand['requiredMessage']) { // Required Message
                $I->clicked(GeneralFields::radioSelect('Required',1),'Mark Yes from Required because by default it is No');
                $I->clickByJS(GeneralFields::radioSelect('Error Message', 2),'Mark custom from Required because by default it is global');
                $I->filledField(GeneralFields::customizationFields('Required'), $basicOperand['requiredMessage'], 'Fill As custom Required Message');
            }

            if ($basicOperand['validationMessage']) { // Validation Message
                $I->clickByJS(GeneralFields::radioSelect('Validate Phone Number', 1),'Mark custom from Validate phone because by default it is global');
                $I->clickByJS(GeneralFields::radioSelect('Validate Phone Number', 4),'Mark custom from Validate phone because by default it is global');
                $I->filledField(GeneralFields::customizationFields('Validate Phone Number'), $basicOperand['validationMessage'], 'Fill As Email Validation Message');
            }
        }

        //                                           Advanced options                                              //

        if (isset($advancedOperand)) {
            $I->scrollTo(GeneralFields::advancedOptions);
            $I->clicked(GeneralFields::advancedOptions,'Expand advanced options');
            $I->wait(2);

            $advancedOperand['nameAttribute'] // Name Attribute
                ? $I->filledField(GeneralFields::customizationFields('Name Attribute'), $advancedOperand['nameAttribute'], 'Fill As Name Attribute')
                : null;

            $advancedOperand['helpMessage'] // Help Message
                ? $I->filledField("//textarea[@class='el-textarea__inner']", $advancedOperand['helpMessage'], 'Fill As Help Message')
                : null;

            $advancedOperand['containerClass'] // Container Class
                ? $I->filledField(GeneralFields::customizationFields('Container Class'), $advancedOperand['containerClass'], 'Fill As Container Class')
                : null;

            $advancedOperand['elementClass'] // Element Class
                ? $I->filledField(GeneralFields::customizationFields('Element Class'), $advancedOperand['elementClass'], 'Fill As Element Class')
                : null;
        }
        $I->clickByJS(FluentFormsSelectors::saveForm);
        $I->seeSuccess('The form is successfully updated.');

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