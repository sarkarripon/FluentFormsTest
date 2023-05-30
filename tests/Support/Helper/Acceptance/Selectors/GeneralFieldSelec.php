<?php

namespace Tests\Support\Helper\Acceptance\Selectors;

class GeneralFieldSelec
{
    //general fields
    public static function fieldCustomise($fieldNumber): string
    {
        return "(//div[@class='item-actions-wrapper hover-action-middle'])[$fieldNumber]";
    }

    const generalField = "(//h5[normalize-space()='General Fields'])[1]";
    const generalFields = [
        'nameField' => "//div[@class='vddl-draggable btn-element'][normalize-space()='Name Fields']",
        'emailField' => "(//div[@class='vddl-draggable btn-element'][normalize-space()='Email Address'])[1]",
        'simpleText' => "(//div[@class='vddl-draggable btn-element'][normalize-space()='Simple Text'])[1]",
        'maskInput' => "(//div[@class='vddl-draggable btn-element'][normalize-space()='Mask Input'])[1]",
        'textArea' => "(//div[@class='vddl-draggable btn-element'][normalize-space()='Text Area'])[1]",
        'addressField' => "(//div[@class='vddl-draggable btn-element'][normalize-space()='Address Fields'])[1]",
        'countryList' => "(//div[@class='vddl-draggable btn-element'][normalize-space()='Country List'])[1]",
        'numaricField' => "(//div[@class='vddl-draggable btn-element'][normalize-space()='Numeric Field'])[1]",
        'dropdown' => "(//div[@class='vddl-draggable btn-element'][normalize-space()='Dropdown'])[1]",
        'radioBtn' => "(//div[@class='vddl-draggable btn-element'][normalize-space()='Radio Field'])[1]",
        'checkbox' => "(//div[@class='vddl-draggable btn-element'][normalize-space()='Check Box'])[1]",
        'multipleChoice' => "(//div[@class='vddl-draggable btn-element'][normalize-space()='Multiple Choice'])[1]",
        'websiteUrl' => "(//div[@class='vddl-draggable btn-element'][normalize-space()='Website URL'])[1]",
        'timeDate' => "(//div[@class='vddl-draggable btn-element'][normalize-space()='Time & Date'])[1]",
        'imageUpload' => "(//div[@class='vddl-draggable btn-element'][normalize-space()='Image Upload'])[1]",
        'fileUpload' => "(//div[@class='vddl-draggable btn-element'][normalize-space()='File Upload'])[1]",
        'customHtml' => "(//div[@class='vddl-draggable btn-element'][normalize-space()='Custom HTML'])[1]",
        'phoneField' => "(//div[@class='vddl-draggable btn-element'][normalize-space()='Phone/Mobile Field'])[1]",
        ];

    const advancedSection = "(//h5[normalize-space()='Advanced Fields'])[1]";
    const advancedFields = [
        'hiddenField' => "(//div[contains(text(),'Hidden Field')])[1]",
        'sectionBreak' => "(//div[contains(text(),'Section Break')])[1]",
        'reCaptcha' => "(//div[contains(text(),'reCaptcha')])[1]",
        'hCapcha' => "(//div[contains(text(),'hCaptcha')])[1]",
        'turnstile' => "(//div[contains(text(),'Turnstile')])[1]",
        'shortCode' => "(//div[contains(text(),'Shortcode')])[1]",
        'tnc' => "(//div[contains(text(),'Terms & Conditions')])[1]",
        'actionHook' => "(//div[contains(text(),'Action Hook')])[1]",
        'formStep' => "(//div[contains(text(),'Form Step')])[1]",
        'rating' => "(//div[contains(text(),'Ratings')])[1]",
        'checkableGrid' => "(//div[contains(text(),'Checkable Grid')])[1]",
        'gdpr' => "(//div[contains(text(),'GDPR Agreement')])[1]",
        'passField' => "(//div[contains(text(),'Password Field')])[1]",
        'customSubBtn' => "(//div[contains(text(),'Custom Submit Button')])[1]",
        'rangeSlider' => "(//div[contains(text(),'Range Slider Field')])[1]",
        'netPromoter' => "(//div[contains(text(),'Net Promoter Score')])[1]",
        'chainedSelect' => "(//div[contains(text(),'Chained Select Field')])[1]",
        'colorPicker' => "(//div[contains(text(),'Color Picker Field')])[1]",
        'repeat' => "(//div[contains(text(),'Repeat Field')])[1]",
        'post_cpt' => "(//div[contains(text(),'Post/CPT Selection')])[1]",
        'richText' => "(//div[contains(text(),'Rich Text Input')])[1]",
        'save_resume' => "(//div[contains(text(),'Save & Resume')])[1]"
        ];



}