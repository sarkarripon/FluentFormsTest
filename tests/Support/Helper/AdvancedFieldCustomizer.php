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