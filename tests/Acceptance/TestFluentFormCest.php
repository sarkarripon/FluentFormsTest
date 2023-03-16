<?php

namespace Tests\Acceptance;

use Tests\Support\AcceptanceTester;
use Codeception\Util\Locator;
class TestFluentFormCest
{
    public function _before(AcceptanceTester $I)
    {
        $I->wpLogin();
    }

    public function Install_plugins(AcceptanceTester $I)
    {
        $I->installFluentForm();
        $I->installFluentFormPdfGenerator();
        $I->installFluentFormPro();
    }


    //Main test function goes here

    public function create_blank_form_with_general_fields(AcceptanceTester $I)
    {
        $I->wantTo('Create a blank form with general fields');
        $I->amOnPage('/wp-admin/admin.php?page=fluent_forms');
        $I->tryToClick('Add a New Form');
        $I->tryToMoveMouseOver("(//div[@class='ff-el-banner-text-inside ff-el-banner-text-inside-hoverable'])[1]");
        $I->tryToClick('Create Form');
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




    public function UninstallPlugins(AcceptanceTester $I)
    {
        $I->wantTo('Clean up plugins');

        $I->amOnPage('/wp-admin/admin.php?page=fluent_forms_add_ons&sub_page=fluentform-pro-add-on');
        $I->removeFluentFormProLicense();

        $I->amOnPage('/wp-admin/plugins.php');
        $I->uninstallFluentFormPro();
        $I->uninstallFluentFormPdfGenerator();
        $I->uninstallFluentForm();
    }
}