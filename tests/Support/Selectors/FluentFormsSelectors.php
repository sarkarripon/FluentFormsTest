<?php

namespace Tests\Support\Selectors;

class FluentFormsSelectors
{
    const fFormPage = '/wp-admin/admin.php?page=fluent_forms';
    const createFirstForm = "(//button[contains(@class,'el-button el-button--primary el-button--large')])[1]";
    const addNewForm = "//button[contains(@class,'el-button el-button--primary')][1]";
    const blankForm = "(//div[contains(@class,'ff_card ff_card_form_action ff_card_shadow_lg hover-zoom')])[1]";
    const saveForm = "(//button[normalize-space()='Save Form'])[1]";
    const mouseHoverMenu = "//tbody/tr[contains(@class,'el-table__row')]/td[2]/div[1]";
    const deleteBtn = "//a[normalize-space()='Delete']";
    const confirmBtn = "[class='el-popover el-popper']:last-child button:last-child";
    const formSettings = "//span[@class='ff_edit']//a[contains(text(),'Settings')]";
    const settingsAndIntegrations = "//a[normalize-space()='Settings & Integrations']";
    const allIntegrations = "//a[@data-route_key='/all-integrations']";
    const addNewIntegration = "//button[normalize-space()='Add New Integration']";
    const searchIntegration = "//input[@placeholder='Search Integration']";
    const searchResult = "[class$='el-dropdown-menu__item']:nth-child(2)";




    //general fields
    public static function fieldCustomise($fieldNumber): string
    {
        return "(//div[@class='item-actions-wrapper hover-action-middle'])[$fieldNumber]";
    }

    const generalSection = "(//h5[normalize-space()='General Fields'])[1]";
    const generalFields = [
        'nameField' => "//div[contains(@class,'vddl-draggable btn-element')]//span[normalize-space()='Name Fields']",
        'emailField' => "//div[contains(@class,'vddl-draggable btn-element')]//span[normalize-space()='Email']",
        'simpleText' => "//div[contains(@class,'vddl-draggable btn-element')]//span[normalize-space()='Simple Text']",
        'maskInput' => "//div[contains(@class,'vddl-draggable btn-element')]//span[normalize-space()='Mask Input']",
        'textArea' => "//div[contains(@class,'vddl-draggable btn-element')]//span[normalize-space()='Text Area']",
        'addressField' => "//div[contains(@class,'vddl-draggable btn-element')]//span[normalize-space()='Address Fields']",
        'countryList' => "//div[contains(@class,'vddl-draggable btn-element')]//span[normalize-space()='Country List']",
        'numaricField' => "//div[contains(@class,'vddl-draggable btn-element')]//span[normalize-space()='Numeric Field']",
        'dropdown' => "//div[contains(@class,'vddl-draggable btn-element')]//span[normalize-space()='Dropdown']",
        'radioField' => "//div[contains(@class,'vddl-draggable btn-element')]//span[normalize-space()='Radio Field']",
        'checkbox' => "//div[contains(@class,'vddl-draggable btn-element')]//span[normalize-space()='Check Box']",
        'multipleChoice' => "//div[contains(@class,'vddl-draggable btn-element')]//span[normalize-space()='Multiple Choice']",
        'websiteUrl' => "//div[contains(@class,'vddl-draggable btn-element')]//span[normalize-space()='Website URL']",
        'timeDate' => "//div[contains(@class,'vddl-draggable btn-element')]//span[normalize-space()='Time & Date']",
        'imageUpload' => "//div[contains(@class,'vddl-draggable btn-element')]//span[normalize-space()='Image Upload']",
        'fileUpload' => "//div[contains(@class,'vddl-draggable btn-element')]//span[normalize-space()='File Upload']",
        'customHtml' => "//div[contains(@class,'vddl-draggable btn-element')]//span[normalize-space()='Custom HTML']",
        'phoneField' => "//div[contains(@class,'vddl-draggable btn-element')]//span[normalize-space()='Phone/Mobile']",

    ];

    const advancedSection = "(//h5[normalize-space()='Advanced Fields'])[1]";
    const advancedFields = [
        'hiddenField' => "//div[contains(@class,'vddl-draggable btn-element')]//span[normalize-space()='Hidden Field']",
        'sectionBreak' => "//div[contains(@class,'vddl-draggable btn-element')]//span[normalize-space()='Section Break']",
        'reCaptcha' => "//div[contains(@class,'vddl-draggable btn-element')]//span[normalize-space()='reCaptcha']",
        'hCapcha' => "//div[contains(@class,'vddl-draggable btn-element')]//span[normalize-space()='hCaptcha']",
        'turnstile' => "//div[contains(@class,'vddl-draggable btn-element')]//span[normalize-space()='Turnstile']",
        'shortCode' => "//div[contains(@class,'vddl-draggable btn-element')]//span[normalize-space()='Shortcode']",
        'tnc' => "//div[contains(@class,'vddl-draggable btn-element')]//span[normalize-space()='Terms & Conditions']",
        'actionHook' => "//div[contains(@class,'vddl-draggable btn-element')]//span[normalize-space()='Action Hook']",
        'formStep' => "//div[contains(@class,'vddl-draggable btn-element')]//span[normalize-space()='Form Step']",
        'rating' => "//div[contains(@class,'vddl-draggable btn-element')]//span[normalize-space()='Ratings']",
        'checkableGrid' => "//div[contains(@class,'vddl-draggable btn-element')]//span[normalize-space()='Checkable Grid']",
        'gdpr' => "//div[contains(@class,'vddl-draggable btn-element')]//span[normalize-space()='GDPR Agreement']",
        'passwordField' => "//div[contains(@class,'vddl-draggable btn-element')]//span[normalize-space()='Password']",
        'customSubBtn' => "//div[contains(@class,'vddl-draggable btn-element')]//span[normalize-space()='Custom Submit Button']",
        'rangeSlider' => "//div[contains(@class,'vddl-draggable btn-element')]//span[normalize-space()='Range Slider']",
        'netPromoter' => "//div[contains(@class,'vddl-draggable btn-element')]//span[normalize-space()='Net Promoter Score']",
        'chainedSelect' => "//div[contains(@class,'vddl-draggable btn-element')]//span[normalize-space()='Chained Select']",
        'colorPicker' => "//div[contains(@class,'vddl-draggable btn-element')]//span[normalize-space()='Color Picker']",
        'repeat' => "//div[contains(@class,'vddl-draggable btn-element')]//span[normalize-space()='Repeat Field']",
        'post_cpt' => "//div[contains(@class,'vddl-draggable btn-element')]//span[normalize-space()='Post/CPT Selection']",
        'richText' => "//div[contains(@class,'vddl-draggable btn-element')]//span[normalize-space()='Rich Text Input']",
        'save_resume' => "//div[contains(@class,'vddl-draggable btn-element')]//span[normalize-space()='Save & Resume']",

    ];

    public static function selectContainer($containerNumber): string
    {
        return "(//i[contains(text(),'+')])[$containerNumber]";
    }
    const containerSection = "(//h5[normalize-space()='Container'])[1]";

    const containers = [
        'oneColumn' => "//div[contains(@class,'vddl-draggable btn-element')]//span[normalize-space()='One Column Container']",
        'twoColumns' => "//div[contains(@class,'vddl-draggable btn-element')]//span[normalize-space()='Two Column Container']",
        'threeColumns' => "//div[contains(@class,'vddl-draggable btn-element')]//span[normalize-space()='Three Column Container']",
        'fourColumns' => "//div[contains(@class,'vddl-draggable btn-element')]//span[normalize-space()='Four Column Container']",
        'fiveColumns' => "//div[contains(@class,'vddl-draggable btn-element')]//span[normalize-space()='Five Column Container']",
        'sixColumns' => "//div[contains(@class,'vddl-draggable btn-element')]//span[normalize-space()='Six Column Container']",

    ];
    const paymentSection = "(//h5[normalize-space()='Payment Fields'])[1]";
    const paymentFields = [
        'paymentItem' => "//div[contains(@class,'vddl-draggable btn-element')]//span[normalize-space()='Payment Item']",
        'subscription' => "//div[contains(@class,'vddl-draggable btn-element')]//span[normalize-space()='Subscription']",
        'customPaymentAmount' => "//div[contains(@class,'vddl-draggable btn-element')]//span[normalize-space()='Custom Payment Amount']",
        'itmQuantity' => "//div[contains(@class,'vddl-draggable btn-element')]//span[normalize-space()='Item Quantity']",
        'paymentMethod' => "//div[contains(@class,'vddl-draggable btn-element')]//span[normalize-space()='Payment Method']",
        'paymentSummary' => "//div[contains(@class,'vddl-draggable btn-element')]//span[normalize-space()='Payment Summary']",
        'coupon' => "//div[contains(@class,'vddl-draggable btn-element')]//span[normalize-space()='Coupon']",
    ];



    // Add New Platformly Integration Feed selectors

    const feedName = "//input[@placeholder='Your Feed Name']";
    const plarformlySegmentDropDown = "(//i[contains(@class,'el-select__caret el-input__icon el-icon-arrow-up')])[1]";
    const plarformlySegment = "//div[@x-placement='bottom-start']//ul[contains(@class,'el-scrollbar__view el-select-dropdown__list')]";
    const mapEmailDropdown = "//tbody//div//div[@class='el-select']//i[contains(@class,'el-select__caret el-input__icon el-icon-arrow-up')]";
    const mapEmail = "//span[normalize-space()='Email']";

    public static function mapField($fieldPosition): string
    {
        return "(//input[@placeholder='Select a Field or Type Custom value'])[{$fieldPosition}]";
    }
    const saveFeed = "//button[contains(@class,'el-button pull-right el-button--primary el-button--small')]";


    //Other Fields
    const addField = "(//span[contains(text(),'+')])[1]";
    const removeField = "(//span[contains(text(),'-')])[1]";
    public static function fieldLabel($fieldPosition): string
    {
        return "(//input[@placeholder='Select'])[{$fieldPosition}]";
    }
//    public static function selectField($fieldName): string
//    {
//        return "//div[@x-placement='bottom-start']//span[normalize-space()='{$fieldName}']";
//    }

    const selectField = "(//span[normalize-space()='City'])";
    const contactTag = "//input[contains(@class,'el-select')]";
}