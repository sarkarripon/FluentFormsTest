<?php
namespace Tests\Support\Selectors;

class GeneralFields{

    // Name Fields
    const adminFieldLabel = "//div[@prop='admin_field_label']//input[@type='text']";
    public static function nameFieldSelectors(int $nameArea,string $label )
    {
        return "((//div[contains(@class,'address-field-option')])[$nameArea]//span[contains(text(),'$label')]/following::input[@type='text'])[1]";
    }
    public static function isRequire(int $whatRequire)
    {
        // 1,3,5
        return "(//div[@role='radiogroup']//span[contains(@class,'el-radio__inner')])[$whatRequire]";
    }
    const commonUnderNameFields = "";
    const defaultField = "//div[contains(@class,'el-input-group--append')]//input[@type='text']";

}
