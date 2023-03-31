<?php

namespace Tests\Acceptance;

use Codeception\Attribute\DataProvider;
use Codeception\Attribute\Skip;
use JetBrains\PhpStorm\NoReturn;
use Tests\Support\AcceptanceTester;
use Codeception\Attribute\Before;
use Codeception\Attribute\After;
use Facebook\WebDriver\Exception\WebDriverException;
use Codeception\Example;
use Codeception\Actor;

use Tests\Support\Helper\Acceptance\Selectors\AdvancedField;
use Tests\Support\Helper\Acceptance\Selectors\DeleteForm;
use Tests\Support\Helper\Acceptance\Selectors\GeneralField;
use Tests\Support\Helper\Acceptance\Selectors\GlobalPage;
use Tests\Support\Helper\Acceptance\Selectors\NewForm;
use Tests\Support\Helper\Acceptance\Selectors\NewPage;


class FluentFormCest
{
    /**
     *@author Sarkar Ripon
     * @param AcceptanceTester $I
     * @return void
     * This function will run before every test function
     */
    public function _before(AcceptanceTester $I): void
    {
        $I->wpLogin();

    }

    public function _after(AcceptanceTester $I): void
    {
        $I->wpLogout();
    }

    /**
     * @author Sarkar Ripon
     * @param AcceptanceTester $I
     * @return void
     * This function will install all the required plugins, skip if already installed
     */
    public function Install_required_plugins(AcceptanceTester $I): void
    {
        $I->wantTo('Install required plugins');
        $I->amOnPage(GlobalPage::pluginPage);

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
        $I->amOnPage(GlobalPage::pluginPage);
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
            $I->deleteExistingForms();
            $I->createNewForm();
            //add general fields
            $I->click(GeneralField::nameField);
            $I->click(GeneralField::emailField);
            $I->click(GeneralField::simpleText);
            $I->click(GeneralField::maskInput);
            $I->click(GeneralField::textArea);
            $I->click(GeneralField::addressField);
            $I->click(GeneralField::countryList);
            $I->click(GeneralField::numaricField);
            $I->click(GeneralField::dropdown);
            $I->click(GeneralField::radioBtn);
            $I->click(GeneralField::checkbox);
            $I->click(GeneralField::multipleChoice);
            $I->click(GeneralField::websiteUrl);
            $I->click(GeneralField::timeDate);
            $I->click(GeneralField::imageUpload);
            $I->click(GeneralField::fileUpload);
            $I->click(GeneralField::customHtml);
            $I->click(GeneralField::phoneField);
            $I->waitForElementClickable(NewForm::saveForm,1);
            $I->click(NewForm::saveForm);
            $I->wait(1);
            $I->see("Success");
            $I->wait(5);
            $I->renameForm("General Fields Form");
            $I->createNewPage("General Fields");
    }

    public function create_blank_form_with_advanced_fields(AcceptanceTester $I): void
    {
        global $pageUrl;
        $I->wantTo('Create a blank form with advanced fields');
        $I->createNewForm();
        $I->clicked(GeneralField::nameField);
        $I->click(GeneralField::emailField);
        $I->clicked(AdvancedField::advField);
        $I->click(AdvancedField::passField);
        $I->clicked(GeneralField::fieldCustomise(3));
        $I->click(NewForm::saveForm);
        $I->seeText("Success");
        $I->renameForm("Signup Form");

        $I->deleteExistingPages();
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

        $I->amOnPage(GlobalPage::fFormLicensePage);
        $I->removeFluentFormProLicense();

        $I->amOnPage(GlobalPage::pluginPage);
        $I->uninstallPlugin("Fluent Forms Pro Add On Pack");
        $I->uninstallPlugin("FluentForms PDF");
        $I->uninstallPlugin("FluentForm");

    }
}