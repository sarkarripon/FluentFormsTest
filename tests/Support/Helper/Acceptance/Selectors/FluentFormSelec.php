<?php
namespace Tests\Support\Helper\Acceptance\Selectors;

class FluentFormSelec
{
    const fFormPage = '/wp-admin/admin.php?page=fluent_forms';
    const deleteBtn = "tbody tr:nth-child(1) td:nth-child(2)";
    const confirmBtn = "/html[1]/body[1]/div[2]/div[1]/button[2]";
    const createFirstForm = ".fluent_form_intro";
    const blankForm = "(//div[@class='ff-el-banner-text-inside ff-el-banner-text-inside-hoverable'])[1]";

    //general fields
    const nameField = "div[class='option-fields-section option-fields-section_active'] div[class='option-fields-section--content'] div:nth-child(1) div:nth-child(1) div:nth-child(1)";
    const emailField = "div[class='option-fields-section option-fields-section_active'] div[class='option-fields-section--content'] div:nth-child(1) div:nth-child(2) div:nth-child(1)";
    const simpleText = "div[class='option-fields-section option-fields-section_active'] div[class='option-fields-section--content'] div:nth-child(1) div:nth-child(3) div:nth-child(1)";
    const maskInput = "body > div:nth-child(3) > div:nth-child(2) > div:nth-child(2) > div:nth-child(1) > div:nth-child(2) > div:nth-child(2) > div:nth-child(1) > div:nth-child(1) > div:nth-child(1) > div:nth-child(2) > div:nth-child(1) > div:nth-child(2) > div:nth-child(2) > div:nth-child(1) > div:nth-child(2) > div:nth-child(2) > div:nth-child(1) > div:nth-child(1)";
    const textArea = "body > div:nth-child(3) > div:nth-child(2) > div:nth-child(2) > div:nth-child(1) > div:nth-child(2) > div:nth-child(2) > div:nth-child(1) > div:nth-child(1) > div:nth-child(1) > div:nth-child(2) > div:nth-child(1) > div:nth-child(2) > div:nth-child(2) > div:nth-child(1) > div:nth-child(2) > div:nth-child(2) > div:nth-child(2) > div:nth-child(1)";
    const addressField = "body > div:nth-child(3) > div:nth-child(2) > div:nth-child(2) > div:nth-child(1) > div:nth-child(2) > div:nth-child(2) > div:nth-child(1) > div:nth-child(1) > div:nth-child(1) > div:nth-child(2) > div:nth-child(1) > div:nth-child(2) > div:nth-child(2) > div:nth-child(1) > div:nth-child(2) > div:nth-child(2) > div:nth-child(3) > div:nth-child(1)";
    const countryList = "div[class='option-fields-section option-fields-section_active'] div:nth-child(3) div:nth-child(1) div:nth-child(1)";
    const numaricField = "div[class='option-fields-section option-fields-section_active'] div:nth-child(3) div:nth-child(2) div:nth-child(1)";
    const dropdown = "div[class='option-fields-section option-fields-section_active'] div:nth-child(3) div:nth-child(3) div:nth-child(1)";
    const radioBtn = "div[class='option-fields-section option-fields-section_active'] div:nth-child(4) div:nth-child(1) div:nth-child(1)";
    const checkbox = "div[class='option-fields-section option-fields-section_active'] div:nth-child(4) div:nth-child(2) div:nth-child(1)";
    const multipleChoice = "div[class='option-fields-section option-fields-section_active'] div:nth-child(4) div:nth-child(3) div:nth-child(1)";
    const websiteUrl = "div[class='option-fields-section option-fields-section_active'] div:nth-child(5) div:nth-child(1) div:nth-child(1)";
    const timeDate = "div[class='option-fields-section option-fields-section_active'] div:nth-child(5) div:nth-child(2) div:nth-child(1)";
    const imageUpload = "div[class='option-fields-section option-fields-section_active'] div:nth-child(5) div:nth-child(3) div:nth-child(1)";
    const fileUpload = "div[class='option-fields-section option-fields-section_active'] div:nth-child(6) div:nth-child(1) div:nth-child(1)";
    const customHtml = "div[class='option-fields-section option-fields-section_active'] div:nth-child(6) div:nth-child(2) div:nth-child(1)";
    const phoneField = "div[class='option-fields-section option-fields-section_active'] div:nth-child(6) div:nth-child(3) div:nth-child(1)";
    const saveForm = "(//button[normalize-space()='Save Form'])[1]";

    //rename form
    const rename = "div[id='js-ff-nav-title'] span";
    const renameField = "input[placeholder='Awesome Form']";
    const renameBtn = "div[aria-label='Rename Form'] div[class='el-dialog__footer']";
    const successMsg = "(//div[@role='alert'])[1]";


    const previousPageAvailable = "(//td[@class='title column-title has-row-actions column-primary page-title'])[1]";
    const selectAllCheckMark = "(//input[@id='cb-select-all-1'])[1]";
    const selectMoveToTrash = "(//select[@id='bulk-action-selector-top'])[1]";
    const applyBtn = "(//input[@id='doaction'])[1]";
    const formShortCode = "(//code[@title='Click to copy shortcode'])[1]";
    const addNewPage = ".page-title-action";
    const jsForTitle = 'wp.data.dispatch("core/editor").editPost({title: "%s"})';
    const jsForContent = "wp.data.dispatch('core/block-editor').insertBlock(wp.blocks.createBlock('core/paragraph',{content:'%s'}))";
    const publishBtn = "(//button[normalize-space()='Publish'])[1]";
    const confirmPublish = "(//button[@class='components-button editor-post-publish-button editor-post-publish-button__button is-primary'])[1]";
    const viewPage = "a[class='components-button is-primary']";


}

