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

//    #[Skip]
//    public function numberOfTr(AcceptanceTester $I): int
//    {
//        $I->amOnPage(GlobalPage::fFormPage);
//        return count($I->grabMultiple('tr'));
//    }

    /**
     * @author Sarkar Ripon
     * @return array
     * fluent form comes with 2 default forms
     * So, This function will instruct below function two times to delete default forms
     */
//    #[Skip]
    public function count_existing_form(AcceptanceTester $I): array
    {
        global $tr;
        $data = [];
        for ($i = 1; $i < ($tr); $i++) {
            $data[] = ['xpath' => DeleteForm::deleteBtn];
        }
        return $data;
    }
//
//    /**
//     * @author Sarkar Ripon
//     * @param AcceptanceTester $I
//     * @param Example $example
//     * @return void
//     * This function will delete all the existing forms
//     * @dataProvider count_existing_form
//     */
     #[DataProvider('count_existing_form')]
    public function deleteExistingForms(AcceptanceTester $I, Example $example): void
    {
        global $tr;
        $I->amOnPage(GlobalPage::fFormPage);
        $tr = count($I->grabMultiple('tr'));

        $I->amOnPage(GlobalPage::fFormPage);

        if($I->tryToClick($example['xpath']))
        {
            $I->moveMouseOver($example['xpath']);
            $I->wait(1);
            $I->click('Delete', DeleteForm::deleteBtn);
            $I->waitForText('confirm', 2);
            $I->click(DeleteForm::confirmBtn);
            $I->wait(1);
        }
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

    }

    public function create_blank_form_with_advanced_fields(AcceptanceTester $I): void
    {
        $I->wantTo('Create a blank form with advanced fields');
        $I->createNewForm();
        $I->clicked(GeneralField::nameField);
        $I->moveMouseOver(AdvancedField::advField);
        $I->click(AdvancedField::advField);
        $I->click(AdvancedField::passField);
        $I->click(NewForm::saveForm);
        $I->wait(1);
        $I->see("Success");
        $I->wait(5);
        $I->renameForm("Signup Form");



    }


    /**
     * @author Sarkar Ripon
     * @param AcceptanceTester $I
     * @return void
     * This function will delete all the existing pages
     */
    public function delete_existing_pages(AcceptanceTester $I): void
    {
         $I->wantTo('Delete all the existing pages');

        $I->amOnPage(GlobalPage::newPageCreationPage);
       if ( $I->tryToClick(NewPage::previousPageAvailable))
       {
           $I->click(NewPage::selectAllCheckMark);
           $I->selectOption(NewPage::selectMoveToTrash, "Move to Trash");
           $I->click(NewPage::applyBtn);
           $I->see('moved to the Trash');
       }
    }

    /**
     * @author Sarkar Ripon
     * @param AcceptanceTester $I
     * @return string
     * This function will create a new page with the form shortcode
     */
    #[Before('delete_existing_pages')] // #[Skip('Because this test will be run by fill_form_with_data function')]
    public function create_new_page_with_form(AcceptanceTester $I): string
    {
        global $pageUrl;
        $I->wantTo('Create a new page with the form shortcode');

        $I->amOnPage(GlobalPage::fFormPage);
        $shortcode= $I->grabTextFrom(NewPage::formShortCode);

        $I->amOnPage(GlobalPage::newPageCreationPage);
        $I->click(NewPage::addNewPage);
        $I->wait(1);
        $I->executeJS(sprintf(NewPage::jsForTitle,"Acceptance test form"));
        $I->executeJS(sprintf(NewPage::jsForContent,$shortcode));
        $I->click( NewPage::publishBtn);
        $I->waitForElementClickable(NewPage::confirmPublish);
        $I->click( NewPage::confirmPublish);
        $I->wait(1);
        $pageUrl = $I->grabAttributeFrom(NewPage::viewPage, 'href');
        return $pageUrl;
    }

    public function fill_form_with_data(AcceptanceTester $I): void
    {
        global $pageUrl;
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