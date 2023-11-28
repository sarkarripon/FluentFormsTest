<?php
namespace Tests\Support\Selectors;

class GeneralFields{

    // Name Fields
    const adminFieldLabel = "//div[@prop='admin_field_label']//input[@type='text']";
    const placeholder = "//div[@prop='placeholder']//input[@type='text']";
    const advancedOptions = "//h5[normalize-space()='Advanced Options']";
    public static function customizationFields($label): string
    {
        return "(//*[normalize-space()='$label']/following::input[@type='text'])[1]";
    }
    public static function nameFieldSelectors(int $nameArea, string $label )
    {
        // namearea = 1,2,3 label = Label, Default, Placeholder, Help Message, Error Message
        return "((//div[contains(@class,'address-field-option__settings')])[$nameArea]//*[contains(text(),'$label')]/following::input[@type='text'])[1]";
    }
    public static function isRequire(int $nameArea, $index=1)
    {
        return "((//div[contains(@class,'address-field-option__settings')])[$nameArea]//*[@class='el-radio__inner'])[$index]";
    }
    public static function radioSelect($label, $index = 1)
    {
        $indexPart = "";
        if ($index !== null) {
            $indexPart = "[$index]";
        }
        return "(//*[normalize-space()='$label']/following::div[@role='radiogroup']//span[contains(@class,'el-radio__inner')])$indexPart";
    }
    public static function checkboxSelect($precedingElement=null)
    {
        $preceding = $precedingElement ?? "//*[contains(@class,'checkbox-label')]";
        return "($preceding/preceding::span[@class='el-checkbox__inner'])[1]";
    }
    const defaultField = "//div[contains(@class,'el-input-group--append')]//input[@type='text']";

}
