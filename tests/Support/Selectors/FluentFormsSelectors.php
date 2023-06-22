<?php

namespace Tests\Support\Selectors;

class FluentFormsSelectors
{
    const fFormPage = '/wp-admin/admin.php?page=fluent_forms';
    const createFirstForm = ".fluent_form_intro";
    const blankForm = "(//div[@class='ff-el-banner-text-inside ff-el-banner-text-inside-hoverable'])[1]";
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