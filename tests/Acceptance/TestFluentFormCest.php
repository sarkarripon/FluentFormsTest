<?php

namespace Tests\Acceptance;

use Tests\Support\AcceptanceTester;
use Codeception\Util\Locator;
use Facebook\WebDriver\Exception\WebDriverException;

class TestFluentFormCest
{
    public function _before(AcceptanceTester $I)
    {
        $I->wpLogin();
    }

    public function Install_plugins(AcceptanceTester $I)
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
        DELETE FROM 'wp_fluentform_forms';
        try {
            $I->wantTo('Create a blank form with general fields');
            $I->amOnPage('/wp-admin/admin.php?page=fluent_forms');

            $tr= count($I->grabMultiple("tr"));
            for ($i = 1; $i<$tr; $i++)
            {
                do{
                    $I->tryToMoveMouseOver("tbody tr:nth-child($i) td:nth-child(2)");
                    $I->tryToClick('Delete', "tbody tr:nth-child($i) td:nth-child(2)");
                    $I->waitFor("confirm",1);
                    $I->click('confirm');

                    $I->tryToSee("Successfully deleted the form.");
                }while ($I->tryToSee("tbody tr:nth-child($i) td:nth-child(2)") == true);
            }

            die();

            if ($I->tryToClick('Add a New Form') || $I->tryToClick('Click Here to Create Your First Form', ".fluent_form_intro")) {
                $I->tryToMoveMouseOver("(//div[@class='ff-el-banner-text-inside ff-el-banner-text-inside-hoverable'])[1]");
                $I->tryToClick('Create Form');

                //rename form
                $I->tryToClick("div[id='js-ff-nav-title'] span");
                $I->tryToFillField("input[placeholder='Awesome Form']", "Acceptance Test Form");
                $I->tryToClick("Rename", "div[aria-label='Rename Form'] div[class='el-dialog__footer']");
                $I->tryToSee("The form is successfully updated.");

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

            }
        }catch (WebDriverException $e) {
                codecept_debug($e->getMessage());
            }

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