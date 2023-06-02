<?php

namespace Tests\Support\Selectors;

class FluentFormsSelectors
{
    const fFormPage = '/wp-admin/admin.php?page=fluent_forms';
    const createFirstForm = ".fluent_form_intro";
    const blankForm = "(//div[@class='ff-el-banner-text-inside ff-el-banner-text-inside-hoverable'])[1]";
    const saveForm = "(//button[normalize-space()='Save Form'])[1]";
    const mouseHoverMenu = "(//div[contains(@class,'cell')])[8]";
    const deleteBtn = "(//a[contains(text(),'Delete')])[1]";
    const confirmBtn = "[class='el-popover el-popper']:last-child button:last-child";
    const formSettings = "//span[@class='ff_edit']//a[contains(text(),'Settings')]";
    const settingsAndIntegrations = "//a[normalize-space()='Settings & Integrations']";
    const allIntegrations = "//a[@data-route_key='/all-integrations']";
    const addNewIntegration = "//button[normalize-space()='Add New Integration']";
    const searchIntegration = "//input[@placeholder='Search Integration']";
    const searchResult = "[class$='el-dropdown-menu__item']:nth-child(2)";
}