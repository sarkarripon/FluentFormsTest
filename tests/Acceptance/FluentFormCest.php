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

use Tests\Support\Helper\Acceptance\Selectors\GlobalPageSelec;
use Tests\Support\Helper\Acceptance\Selectors\FluentFormSelec;



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

    /**
     * @author Sarkar Ripon
     * @dataProvider count_existing_form
     * @param AcceptanceTester $I
     * @param Example $example
     * @return void
     * This function will delete all the existing forms
     */
    #[DataProvider('count_existing_form')]
    public function delete_existing_forms(AcceptanceTester $I, Example $example): void
    {
        $I->amOnPage(FluentFormSelec::fFormPage);

        if($I->tryToClick($example['xpath']))
        {
            $I->moveMouseOver($example['xpath']);
            $I->wait(1);
            $I->click('Delete', FluentFormSelec::deleteBtn);
            $I->waitForText('confirm', 2);
            $I->click(FluentFormSelec::confirmBtn);
            $I->wait(1);
        }
    }

    /**
     * @author Sarkar Ripon
     * @return array
     * fluent form comes with 2 default forms
     * So, This function will instruct above function two times to delete default forms
     */
    public function count_existing_form():array
    {
        return [
            ['xpath' =>FluentFormSelec::deleteBtn],
            ['xpath' =>FluentFormSelec::deleteBtn]
        ];
    }

    //************************************************* Main test function start here *************************************************//

    /**
     * @author Sarkar Ripon
     * @param AcceptanceTester $I
     * @return void
     * This function will create a blank form with general fields
     */
    #[After('rename_newly_created_form')]
    public function create_blank_form_with_general_fields(AcceptanceTester $I): void
    {
            $I->wantTo('Create a blank form with general fields');

            $I->amOnPage(FluentFormSelec::fFormPage);

            if ($I->tryToClick('Add a New Form') || $I->tryToClick('Click Here to Create Your First Form', FluentFormSelec::createFirstForm)) {
                $I->tryToMoveMouseOver(FluentFormSelec::blankForm);
                $I->tryToClick('Create Form');

                //add general fields
                $I->click(FluentFormSelec::nameField);
                $I->click(FluentFormSelec::emailField);
                $I->click(FluentFormSelec::simpleText);
                $I->click(FluentFormSelec::maskInput);
                $I->click(FluentFormSelec::textArea);
                $I->click(FluentFormSelec::addressField);
                $I->click(FluentFormSelec::countryList);
                $I->click(FluentFormSelec::numaricField);
                $I->click(FluentFormSelec::dropdown);
                $I->click(FluentFormSelec::radioBtn);
                $I->click(FluentFormSelec::checkbox);
                $I->click(FluentFormSelec::multipleChoice);
                $I->click(FluentFormSelec::websiteUrl);
                $I->click(FluentFormSelec::timeDate);
                $I->click(FluentFormSelec::imageUpload);
                $I->click(FluentFormSelec::fileUpload);
//                $I->click(FluentFormSelec::customHtml);
                $I->click(FluentFormSelec::phoneField);
                $I->waitForElementClickable(FluentFormSelec::saveForm,1);
                $I->click(FluentFormSelec::saveForm);
                $I->wait(1);
                $I->see("Success");
                $I->wait(5);
            }
    }

    /**
     * @author Sarkar Ripon
     * @param AcceptanceTester $I
     * @return void
     * This function will rename the newly created form
     */
    #[Skip('Because this test has already been run by previous test function')]
    public function rename_newly_created_form(AcceptanceTester $I):void
    {
        $I->wantTo('Rename the newly created form');

        $I->tryToClick(FluentFormSelec::rename);
        $I->tryToFillField(FluentFormSelec::renameField, "Acceptance Test Form");
        $I->tryToClick("Rename", FluentFormSelec::renameBtn);
        $I->wait(1);
        $I->see("Success!");
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

        $I->amOnPage(GlobalPageSelec::newPageCreationPage);
       if ( $I->tryToClick(FluentFormSelec::previousPageAvailable))
       {
           $I->click(FluentFormSelec::selectAllCheckMark);
           $I->selectOption(FluentFormSelec::selectMoveToTrash, "Move to Trash");
           $I->click(FluentFormSelec::applyBtn);
           $I->see('moved to the Trash');
       }
    }

    /**
     * @author Sarkar Ripon
     * @param AcceptanceTester $I
     * @return void
     * This function will create a new page with the form shortcode
     */
    #[Before('delete_existing_pages')] // #[Skip('Because this test will be run by fill_form_with_data function')]
    public function create_new_page_with_form(AcceptanceTester $I): string
    {
        global $pageUrl;
        $I->wantTo('Create a new page with the form shortcode');

        $I->amOnPage(GlobalPageSelec::fFormPage);
        $shortcode= $I->grabTextFrom(FluentFormSelec::formShortCode);

        $I->amOnPage(GlobalPageSelec::newPageCreationPage);
        $I->click(FluentFormSelec::addNewPage);
        $I->wait(1);
        $I->executeJS(sprintf(FluentFormSelec::jsForTitle,"Acceptance test form"));
        $I->executeJS(sprintf(FluentFormSelec::jsForContent,$shortcode));
        $I->click( FluentFormSelec::publishBtn);
        $I->waitForElementClickable(FluentFormSelec::confirmPublish);
        $I->click( FluentFormSelec::confirmPublish);
        $I->wait(1);
        $pageUrl = $I->grabAttributeFrom(FluentFormSelec::viewPage, 'href');
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

        $I->amOnPage(GlobalPageSelec::fFormLicensePage);
        $I->removeFluentFormProLicense();
        $I->amOnPage(GlobalPageSelec::pluginPage);

        $I->uninstallPlugin("Fluent Forms Pro Add On Pack");
        $I->uninstallPlugin("FluentForms PDF");
        $I->uninstallPlugin("FluentForm");

    }
}