<?php
namespace Tests\Support\Selectors;

class GeneralFields{

    // Name Fields
    const adminFieldLabel = "//div[@prop='admin_field_label']//input[@type='text']";
    const commonUnderNameFields = "(//input[@type='text'][preceding::strong[normalize-space()='Name Fields']][preceding::span[normalize-space()='Last Name']])";
    const defaultField = "//div[contains(@class,'el-input-group--append')]//input[@type='text']";

}
