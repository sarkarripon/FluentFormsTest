<?php

namespace Tests\Acceptance;

use Codeception\Attribute\Skip;
use Tests\Support\AcceptanceTester;

use Tests\Support\Helper\Acceptance\Selectors\AdvancedFieldSelec;
use Tests\Support\Helper\Acceptance\Selectors\GeneralFieldSelec;
use Tests\Support\Helper\Acceptance\Selectors\GlobalPageSelec;
use Tests\Support\Helper\Acceptance\Selectors\NewFormSelec;



class FluentFormCest
{
    /**
     * @author Sarkar Ripon
     * @param AcceptanceTester $I
     * @return void
     * This function will run before every test function
     */
    public function _before(AcceptanceTester $I): void
    {
        $I->wpLogin();
    }

//    public function _after(AcceptanceTester $I): void
//    {
//        $I->wpLogout();
//    }

    /**
     * @author Sarkar Ripon
     * @param AcceptanceTester $I
     * @return void
     * This function will install all the required plugins, skip if already installed
     */
    public function Install_required_plugins(AcceptanceTester $I): void
    {
        $I->wantTo('Install required plugins');
        $I->amOnPage(GlobalPageSelec::pluginPage);

        if (!$I->tryToSee('Fluent Forms')) {
            $I->installPlugin("fluentform.zip");
        }
        if (!$I->tryToSee('Fluent Forms PDF Generator')) {
            $I->installPlugin("fluentforms-pdf.zip");
        }
        if (!$I->tryToSee('Fluent Forms Pro')) {
            $I->installPlugin("fluentformpro.zip");

            $I->activateFluentFormPro();
        }
        $I->amOnPage(GlobalPageSelec::pluginPage);
        $I->see('Fluent Forms Pro Add On Pack');
        $I->see('Fluent Forms');
        $I->see('Fluent Forms PDF Generator');
    }

    //************************************************* Main test function start here *************************************************//

    /**
     * @author Sarkar Ripon
     * @param AcceptanceTester $I
     * @return void
     * This function will create a blank form with general fields
     */
    public function create_blank_form_with_general_fields(AcceptanceTester $I): void
    {
            $I->wantTo('Create a blank form with general fields');
//            $I->deleteExistingForms();
            $I->initiateNewForm();
            //general fields
            $I->clicked(GeneralFieldSelec::nameField);
            $I->click(GeneralFieldSelec::emailField);
            $I->click(GeneralFieldSelec::simpleText);
            $I->click(GeneralFieldSelec::maskInput);
            $I->click(GeneralFieldSelec::textArea);
            $I->click(GeneralFieldSelec::addressField);
            $I->click(GeneralFieldSelec::countryList);
            $I->click(GeneralFieldSelec::numaricField);
            $I->click(GeneralFieldSelec::dropdown);
            $I->click(GeneralFieldSelec::radioBtn);
            $I->click(GeneralFieldSelec::checkbox);
            $I->click(GeneralFieldSelec::multipleChoice);
            $I->click(GeneralFieldSelec::websiteUrl);
            $I->click(GeneralFieldSelec::timeDate);
            $I->click(GeneralFieldSelec::imageUpload);
            $I->click(GeneralFieldSelec::fileUpload);
            $I->click(GeneralFieldSelec::customHtml);
            $I->click(GeneralFieldSelec::phoneField);
            $I->clicked(NewFormSelec::saveForm);
            $I->seeText("Success");
            $I->renameForm("General Fields Form");
            $I->createNewPage("General Fields");
    }

    public function create_blank_form_with_advanced_fields(AcceptanceTester $I): void
    {
        global $pageUrl;
        $I->wantTo('Create a blank form with advanced fields');
//        $I->deleteExistingForms();
        $I->initiateNewForm();
        $I->clicked(GeneralFieldSelec::nameField);
        $I->click(GeneralFieldSelec::emailField);
        $I->clicked(AdvancedFieldSelec::advField);
        $I->click(AdvancedFieldSelec::passField);
        $I->clicked(GeneralFieldSelec::fieldCustomise(3)); //click on the 3rd field
        $I->click(NewFormSelec::saveForm);
        $I->seeText("Success");
        $I->renameForm("Signup Form");

//        $I->deleteExistingPages();
        $I->createNewPage("Signup Form");
        $I->wantTo('Fill the form with sample data');
        $I->amOnUrl($pageUrl);
    }


    //************************************************* Main test function end here *************************************************//

    /**
     * @author Sarkar Ripon
     * @param AcceptanceTester $I
     * @return void
     * This function will uninstall all the plugins after the end of the test
     */
    #[Skip('Because I do not want to uninstall plugins when test is done')]
    public function UninstallPlugins(AcceptanceTester $I): void
    {
        $I->wantTo('Clean up plugins');

        $I->amOnPage(GlobalPageSelec::fFormLicensePage);
        $I->removeFluentFormProLicense();

        $I->amOnPage(GlobalPageSelec::pluginPage);
        $I->uninstallPlugin("Fluent Forms Pro Add On Pack");
        $I->uninstallPlugin("FluentForms PDF");
        $I->uninstallPlugin("FluentForm");

    }
}