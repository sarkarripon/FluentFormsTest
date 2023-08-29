<?php

namespace Tests\Support\Helper\Acceptance\Integrations;

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
    public function customizeNameFields()
    {

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
    public function customizeCheckBox()
    {

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