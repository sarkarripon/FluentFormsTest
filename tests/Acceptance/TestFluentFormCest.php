<?php

namespace Tests\Acceptance;

use Tests\Support\AcceptanceTester;
use Codeception\Util\Locator;
use Facebook\WebDriver\Exception\WebDriverException;
use \Facebook\WebDriver\WebDriverKeys;
use Codeception\Example;

class TestFluentFormCest
{
    public function _before(AcceptanceTester $I)
    {
        $I->wpLogin();
    }

    public function Install_required_plugins(AcceptanceTester $I)
    {
        $I->amOnPage('/wp-admin/plugins.php');
        if (!$I->tryToSee('Fluent Forms'))
        {
            $I->installFluentForm();
        }
        if (!$I->tryToSee('Fluent Forms PDF Generator'))
        {
            $I->installFluentFormPdfGenerator();
        }
        if (!$I->tryToSee('Fluent Forms Pro'))
        {
            $I->installFluentFormPro();
            $I->activateFluentFormPro();
        }

    }

    //Main test function goes here

    public function create_blank_form_with_general_fields(AcceptanceTester $I)
    {
            $I->wantTo('Create a blank form with general fields');
            $I->amOnPage('/wp-admin/admin.php?page=fluent_forms');

            //delete existing forms
            $I->moveMouseOver("tbody tr:nth-child(1) td:nth-child(2)");
            $I->wait(1);
            $I->click('Delete', "tbody tr:nth-child(1) td:nth-child(2)");
            $I->waitForText('confirm',2);
            $I->click("/html[1]/body[1]/div[2]/div[1]/button[2]");
            $I->wait(1);


            if ($I->tryToClick('Add a New Form') || $I->tryToClick('Click Here to Create Your First Form', ".fluent_form_intro")) {
                $I->tryToMoveMouseOver("(//div[@class='ff-el-banner-text-inside ff-el-banner-text-inside-hoverable'])[1]");
                $I->tryToClick('Create Form');

                //add general fields
                $I->tryToClick("div[class='option-fields-section option-fields-section_active'] div[class='option-fields-section--content'] div:nth-child(1) div:nth-child(1) div:nth-child(1)");
                $I->tryToClick("div[class='option-fields-section option-fields-section_active'] div[class='option-fields-section--content'] div:nth-child(1) div:nth-child(2) div:nth-child(1)");
                $I->tryToClick("div[class='option-fields-section option-fields-section_active'] div[class='option-fields-section--content'] div:nth-child(1) div:nth-child(3) div:nth-child(1)");
                $I->tryToClick("body > div:nth-child(3) > div:nth-child(2) > div:nth-child(2) > div:nth-child(1) > div:nth-child(2) > div:nth-child(2) > div:nth-child(1) > div:nth-child(1) > div:nth-child(1) > div:nth-child(2) > div:nth-child(1) > div:nth-child(2) > div:nth-child(2) > div:nth-child(1) > div:nth-child(2) > div:nth-child(2) > div:nth-child(1) > div:nth-child(1)");
                $I->tryToClick("body > div:nth-child(3) > div:nth-child(2) > div:nth-child(2) > div:nth-child(1) > div:nth-child(2) > div:nth-child(2) > div:nth-child(1) > div:nth-child(1) > div:nth-child(1) > div:nth-child(2) > div:nth-child(1) > div:nth-child(2) > div:nth-child(2) > div:nth-child(1) > div:nth-child(2) > div:nth-child(2) > div:nth-child(2) > div:nth-child(1)");
                $I->tryToClick("body > div:nth-child(3) > div:nth-child(2) > div:nth-child(2) > div:nth-child(1) > div:nth-child(2) > div:nth-child(2) > div:nth-child(1) > div:nth-child(1) > div:nth-child(1) > div:nth-child(2) > div:nth-child(1) > div:nth-child(2) > div:nth-child(2) > div:nth-child(1) > div:nth-child(2) > div:nth-child(2) > div:nth-child(3) > div:nth-child(1)");
                $I->tryToClick("div[class='option-fields-section option-fields-section_active'] div:nth-child(3) div:nth-child(1) div:nth-child(1)");
                $I->tryToClick("div[class='option-fields-section option-fields-section_active'] div:nth-child(3) div:nth-child(2) div:nth-child(1)");
                $I->tryToClick("div[class='option-fields-section option-fields-section_active'] div:nth-child(3) div:nth-child(3) div:nth-child(1)");
                $I->tryToClick("div[class='option-fields-section option-fields-section_active'] div:nth-child(4) div:nth-child(1) div:nth-child(1)");
                $I->tryToClick("div[class='option-fields-section option-fields-section_active'] div:nth-child(4) div:nth-child(2) div:nth-child(1)");
                $I->tryToClick("div[class='option-fields-section option-fields-section_active'] div:nth-child(4) div:nth-child(3) div:nth-child(1)");
                $I->tryToClick("div[class='option-fields-section option-fields-section_active'] div:nth-child(5) div:nth-child(1) div:nth-child(1)");
                $I->tryToClick("div[class='option-fields-section option-fields-section_active'] div:nth-child(5) div:nth-child(2) div:nth-child(1)");
                $I->tryToClick("div[class='option-fields-section option-fields-section_active'] div:nth-child(5) div:nth-child(3) div:nth-child(1)");
                $I->tryToClick("div[class='option-fields-section option-fields-section_active'] div:nth-child(6) div:nth-child(1) div:nth-child(1)");
                $I->tryToClick("div[class='option-fields-section option-fields-section_active'] div:nth-child(6) div:nth-child(2) div:nth-child(1)");
                $I->tryToClick("div[class='option-fields-section option-fields-section_active'] div:nth-child(6) div:nth-child(3) div:nth-child(1)");
                $I->waitForElementClickable("(//button[normalize-space()='Save Form'])[1]",10);
                $I->click("(//button[normalize-space()='Save Form'])[1]");
                $I->wait(1);

                //rename form
                $I->tryToClick("div[id='js-ff-nav-title'] span");
                $I->tryToFillField("input[placeholder='Awesome Form']", "Acceptance Test Form");
                $I->tryToClick("Rename", "div[aria-label='Rename Form'] div[class='el-dialog__footer']");
                $I->tryToSee("The form is successfully updated.");
            }
    }

    public function delete_existing_pages(AcceptanceTester $I)
    {
        $I->amOnPage('/wp-admin/edit.php?post_type=page');
        $I->click("(//input[@id='cb-select-all-1'])[1]");
        $I->selectOption("(//select[@id='bulk-action-selector-top'])[1]", "Move to Trash");
        $I->click("(//input[@id='doaction'])[1]");
    }

    public function create_new_page_with_form(AcceptanceTester $I)
    {
        $I->amOnPage('/wp-admin/admin.php?page=fluent_forms');
        $shortcode= $I->grabTextFrom("(//code[@title='Click to copy shortcode'])[1]");

        $I->amOnPage('/wp-admin/edit.php?post_type=page');
        $I->click(".page-title-action");
        $I->wait(1);
        $I->executeJS(sprintf('wp.data.dispatch("core/editor").editPost({title: "%s"})',"Acceptance test form"));
        $I->executeJS(sprintf("wp.data.dispatch('core/block-editor').insertBlock(wp.blocks.createBlock('core/paragraph',{content:'%s'}))",$shortcode));
        $I->click( "(//button[normalize-space()='Publish'])[1]");
        $I->wait(1);
        $I->click( "(//button[@class='components-button editor-post-publish-button editor-post-publish-button__button is-primary'])[1]");
        $I->wait(1);
        $I->click( "(//a[@class='components-button is-primary'])[1]");

    }

    public function insert_data_to_general_field(AcceptanceTester $I , Example $example)
    {



    }

    public function data_provider(): array
    {
        return [
            []

        ];

    }

    public function UninstallPlugins(AcceptanceTester $I)
    {
        $I->wantTo('Clean up plugins');
        try {
            $I->amOnPage('/wp-admin/admin.php?page=fluent_forms_add_ons&sub_page=fluentform-pro-add-on');
            $I->removeFluentFormProLicense();

            $I->amOnPage('/wp-admin/plugins.php');
            $I->uninstallFluentFormPro();
            $I->uninstallFluentFormPdfGenerator();
            $I->uninstallFluentForm();

        }catch (WebDriverException $e) {
            codecept_debug($e->getMessage());
        }


    }
}