<?php

namespace Tests\Acceptance;

use Codeception\Attribute\DataProvider;
use Codeception\Attribute\Skip;
use JetBrains\PhpStorm\NoReturn;
use Tests\Support\AcceptanceTester;
use Codeception\Attribute\Before;
use Codeception\Attribute\After;
use Codeception\Util\Locator;
use Facebook\WebDriver\Exception\WebDriverException;
use \Facebook\WebDriver\WebDriverKeys;
use \Codeception\Attribute\Examples;
use Codeception\Example;

class TestFluentFormCest
{

    public function _before(AcceptanceTester $I): void
    {
        $I->wpLogin();
    }

    public function Install_required_plugins(AcceptanceTester $I): void
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
    #[DataProvider('count_existing_form')]
    public function delete_existing_forms(AcceptanceTester $I, Example $example): void
    {
        $I->amOnPage('/wp-admin/admin.php?page=fluent_forms');

        if($I->tryToClick($example['xpath']))
        {
            $I->moveMouseOver($example['xpath']);
            $I->wait(1);
            $I->click('Delete', "tbody tr:nth-child(1) td:nth-child(2)");
            $I->waitForText('confirm', 2);
            $I->click("/html[1]/body[1]/div[2]/div[1]/button[2]");
            $I->wait(1);
        }
    }


    public function count_existing_form():array
    {
        return [
            ['xpath' =>'tbody tr:nth-child(1) td:nth-child(2)'],
            ['xpath' =>'tbody tr:nth-child(1) td:nth-child(2)'],
            ['xpath' =>'tbody tr:nth-child(1) td:nth-child(2)']
        ];
    }

    //Main test function goes here

    #[After('rename_newly_created_form')]
    #[NoReturn] public function create_blank_form_with_general_fields(AcceptanceTester $I): void
    {
            $I->wantTo('Create a blank form with general fields');
            $I->amOnPage('/wp-admin/admin.php?page=fluent_forms');

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



            }
    }

    public function rename_newly_created_form(AcceptanceTester $I):void
    {
        //rename form
        $I->tryToClick("div[id='js-ff-nav-title'] span");
        $I->tryToFillField("input[placeholder='Awesome Form']", "Acceptance Test Form");
        $I->tryToClick("Rename", "div[aria-label='Rename Form'] div[class='el-dialog__footer']");
        $I->see("The form is successfully updated.");

    }


    public function delete_existing_pages(AcceptanceTester $I): void
    {
        $I->amOnPage('/wp-admin/edit.php?post_type=page');
       if ( $I->tryToClick("(//td[@class='title column-title has-row-actions column-primary page-title'])[1]"))
       {
           $I->click("(//input[@id='cb-select-all-1'])[1]");
           $I->selectOption("(//select[@id='bulk-action-selector-top'])[1]", "Move to Trash");
           $I->click("(//input[@id='doaction'])[1]");
           $I->see('moved to the Trash');
       }
    }

    #[Before('delete_existing_pages')]
    public function create_new_page_with_form(AcceptanceTester $I): void
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


    #[Before('create_new_page_with_form')] #[DataProvider('data_provider')]
    public function insert_data_to_general_field(AcceptanceTester $I , Example $example): void
    {



    }

    public function data_provider(): array
    {
        return [
            ['name' => 'John', 'email' => 'mail@mail.com'],
            ['name' => 'Doe', 'email' => 'doe@mail.com']

        ];

    }

    #[Skip]
    public function UninstallPlugins(AcceptanceTester $I): void
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