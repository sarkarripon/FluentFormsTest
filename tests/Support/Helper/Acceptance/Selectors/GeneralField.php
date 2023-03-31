<?php

namespace Tests\Support\Helper\Acceptance\Selectors;

class GeneralField
{
    //general fields
    public static function fieldCustomise($fieldNumber): string
    {
        return "(//div[@class='item-actions-wrapper hover-action-middle'])[$fieldNumber]";
    }
    public static function selectContainer($containerNumber): string
    {
        return "(//i[contains(text(),'+')])[$containerNumber]";
    }
    const gnrlField = "(//h5[normalize-space()='General Fields'])[1]";
    const nameField = "//div[@class='vddl-draggable btn-element'][normalize-space()='Name Fields']";
    const emailField = "(//div[@class='vddl-draggable btn-element'][normalize-space()='Email Address'])[1]";
    const simpleText = "(//div[@class='vddl-draggable btn-element'][normalize-space()='Simple Text'])[1]";
    const maskInput = "(//div[@class='vddl-draggable btn-element'][normalize-space()='Mask Input'])[1]";
    const textArea = "(//div[@class='vddl-draggable btn-element'][normalize-space()='Text Area'])[1]";
    const addressField = "(//div[@class='vddl-draggable btn-element'][normalize-space()='Address Fields'])[1]";
    const countryList = "(//div[@class='vddl-draggable btn-element'][normalize-space()='Country List'])[1]";
    const numaricField = "(//div[@class='vddl-draggable btn-element'][normalize-space()='Numeric Field'])[1]";
    const dropdown = "(//div[@class='vddl-draggable btn-element'][normalize-space()='Dropdown'])[1]";
    const radioBtn = "(//div[@class='vddl-draggable btn-element'][normalize-space()='Radio Field'])[1]";
    const checkbox = "(//div[@class='vddl-draggable btn-element'][normalize-space()='Check Box'])[1]";
    const multipleChoice = "(//div[@class='vddl-draggable btn-element'][normalize-space()='Multiple Choice'])[1]";
    const websiteUrl = "(//div[@class='vddl-draggable btn-element'][normalize-space()='Website URL'])[1]";
    const timeDate = "(//div[@class='vddl-draggable btn-element'][normalize-space()='Time & Date'])[1]";
    const imageUpload = "(//div[@class='vddl-draggable btn-element'][normalize-space()='Image Upload'])[1]";
    const fileUpload = "(//div[@class='vddl-draggable btn-element'][normalize-space()='File Upload'])[1]";
    const customHtml = "(//div[@class='vddl-draggable btn-element'][normalize-space()='Custom HTML'])[1]";
    const phoneField = "(//div[@class='vddl-draggable btn-element'][normalize-space()='Phone/Mobile Field'])[1]";
}