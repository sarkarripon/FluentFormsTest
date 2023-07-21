<?php
declare(strict_types=1);
namespace Tests\Support;

use Exception;
use Tests\Support\Selectors\AccepTestSelec;
use Tests\Support\Selectors\FluentFormsAllEntries;
use Tests\Support\Selectors\FluentFormsSelectors;
use Tests\Support\Selectors\GlobalPageSelec;
use Tests\Support\Selectors\NewPageSelectors;
use Tests\Support\Selectors\RenameFormSelec;


/**
 * Inherited Methods
 * @method void wantTo($text)
 * @method void wantToTest($text)
 * @method void execute($callable)
 * @method void expectTo($prediction)
 * @method void expect($prediction)
 * @method void amGoingTo($argumentation)
 * @method void am($role)
 * @method void lookForwardTo($achieveValue)
 * @method void comment($description)
 * @method void pause($vars = [])
 *
 * @SuppressWarnings(PHPMD)
*/
class AcceptanceTester extends \Codeception\Actor
{
    use _generated\AcceptanceTesterActions;

    /**
     * @author Sarkar Ripon
     * @param $selector
     * @return void
     */
    public function reloadIfElementNotFound($selector): void
    {
        try {
            $this->seeElement($selector);
        } catch (Exception $e){
            $this->reloadPage();
            $this->seeElement($selector);
        }
    }

    public function seeSuccess($message): void
    {
        $this->wait(1);
        $this->assertStringContainsString('Success',
            $this->grabTextFrom("//div[@role='alert']//h2[normalize-space()='Success'][1]"), $message);
    }

    /**
     * @author Sarkar Ripon
     * @param string $pluginName
     * @return void
     * Install plugin from local
     */
    public function installPlugin(string $pluginName): void
    {
        $this->wantTo('Install ' . $pluginName . ' plugin');
        $this->amOnPage(GlobalPageSelec::pluginInstallPage);
        $this->seeElement(AccepTestSelec::uploadField);
        $this->click(AccepTestSelec::uploadField);
        $this->attachFile(AccepTestSelec::inputField,$pluginName);
        $this->seeElement(AccepTestSelec::submitButton);
        $this->click(AccepTestSelec::submitButton);
        $this->waitForText('Activate Plugin',5,AccepTestSelec::activateButton);
        $this->click(AccepTestSelec::activateButton);
    }

    /**
     * @author Sarkar Ripon
     * Activate FluentForm Pro plugin
     * @return void
     */
    public function activateFluentFormPro(): void
    {
        //Import license key
        $KEY = fopen(AccepTestSelec::licenseKey, "r") or die("Unable to open file!");
        $LICENSE_KEY = fgets($KEY);
        fclose($KEY);

        if($this->tryToSee('The Fluent Forms Pro Add On license needs to be activated', AccepTestSelec::activeNowBtn))
        {
            $this->click('Activate Now', AccepTestSelec::activeNowBtn);
            $this->waitForElement(AccepTestSelec::licenseInputField,60);
            $this->fillField(AccepTestSelec::licenseInputField,$LICENSE_KEY);
            $this->click(AccepTestSelec::activateLicenseBtn);
            $this->see('Your license is active! Enjoy Fluent Forms Pro Add On');
        }
    }

    /**
     * @author Sarkar Ripon
     * @return void
     * Remove FluentForm Pro license
     */
    public function removeFluentFormProLicense():void
    {
        $this->tryToClick('Deactivate License',AccepTestSelec::licenseBtn);
        $this->see('Enter your license key', AccepTestSelec::licenseBtn);
    }
    /**
     * @author Sarkar Ripon
     * @param string $pluginSlug
     * @return void
     * Uninstall plugin
     */
    public function uninstallPlugin(string $pluginSlug):void
    {
        $slug = str_replace(" ", "-", strtolower($pluginSlug));

        $this->click('Deactivate', "tr[data-slug='".$slug."'] td[class='plugin-title column-primary']");
        $this->waitForText('Plugin deactivated.',10,AccepTestSelec::msg);
        $this->see('Plugin deactivated.',AccepTestSelec::msg);
        $this->click('Delete', "tr[data-slug='".$slug."'] td[class='plugin-title column-primary']");
        $this->tryToAcceptPopup();
        $this->waitForText('successfully deleted.');
        $this->see('successfully deleted.');
    }

    /**
     * @return void
     * This function will delete all the existing forms
     * @author Sarkar Ripon
     */
    public function deleteExistingForms(): void
    {
        $this->amOnPage(FluentFormsSelectors::fFormPage);
        $this->wait(2);
        $tableRow =count($this->grabMultiple("tr"));
//        codecept_debug($tableRow);

        for ($i = 1; $i < ($tableRow); $i++) {
            do {
                $this->wait(1);
                $this->moveMouseOver(FluentFormsSelectors::mouseHoverMenu);
                $this->clicked( FluentFormsSelectors::deleteBtn);
                $this->clicked(FluentFormsSelectors::confirmBtn);
                $this->reloadPage();
            } while ($this->tryToClick(FluentFormsSelectors::deleteBtn)==true);

        }
    }
    /**
     * @author Sarkar Ripon
     * @return void
     * Create a new form
     */
    public function initiateNewForm(): void
    {
        $this->amOnPage(FluentFormsSelectors::fFormPage);
        $this->clicked(FluentFormsSelectors::addNewForm);
        $this->clicked(FluentFormsSelectors::blankForm);
    }

    /**
     * @author Sarkar Ripon
     * @param $formName
     * @return void
     * This function will rename the form
     */
    public function renameForm($formName):void
    {
        $this->waitForElement(RenameFormSelec::rename, 10);
        $this->click(RenameFormSelec::rename);
        $this->fillField(RenameFormSelec::renameField, $formName);
        $this->click("Rename", RenameFormSelec::renameBtn);
    }

    /**
     *
     * This function will delete all the existing pages
     * @author Sarkar Ripon
     * @return void
     */
    public function deleteExistingPages(): void
    {
        $this->amOnPage(GlobalPageSelec::newPageCreationPage);
        $existingPage = $this->checkElement(NewPageSelectors::previousPageAvailable);
        if($existingPage)
        {
            $this->clicked(NewPageSelectors::selectAllCheckMark);
            $this->selectOption(NewPageSelectors::selectMoveToTrash, "Move to Trash");
            $this->click(NewPageSelectors::applyBtn);
            $this->assertStringContainsString('moved to the Trash',
                $this->grabTextFrom('#message'), 'Existing pages were deleted successfully!');
        }
    }

    /**
     * @param $title
     * @param $content
     * @return string
     * This function will create a new page with title and content
     * @author Sarkar Ripon
     */
    public function createNewPage($title, $content=null): string
    {
        global $pageUrl;
        $this->amOnPage(FluentFormsSelectors::fFormPage);
        if(!isset($content)){
            $this->waitForElement(NewPageSelectors::formShortCode, 10);
            $content = $this->grabTextFrom(NewPageSelectors::formShortCode);
        }
        $this->amOnPage(GlobalPageSelec::newPageCreationPage);
        $this->clicked(NewPageSelectors::addNewPage);
        $this->wait(1);
        $this->executeJS(sprintf(NewPageSelectors::jsForTitle,$title));
        $this->executeJS(sprintf(NewPageSelectors::jsForContent,$content));
        $this->clicked( NewPageSelectors::publishBtn);
        $this->waitForElementClickable(NewPageSelectors::confirmPublish);
        $this->clicked( NewPageSelectors::confirmPublish);
        $this->wait(1);
        $pageUrl = $this->grabAttributeFrom(NewPageSelectors::viewPage, 'href');
        return $pageUrl; // it will return the page url and assign it to $pageUrl global variable above.
    }

    /**
     * @author Sarkar Ripon
     * @param $data
     * @return void
     */
    public function createFormField($data): void
    {
        $this->wantTo('Create a form for integrations');
        $this->clicked(FluentFormsSelectors::generalSection);

        foreach ($data as $fieldType => $fields) {
            $sectionType = match ($fieldType) {
                'advancedFields' => 'advancedSection',
                default => 'generalSection',
            };
            $this->clicked(constant(FluentFormsSelectors::class . '::' . $sectionType));
            foreach ($fields as $inputField){
                $selector = constant(FluentFormsSelectors::class . '::' . $fieldType)[$inputField];
                $this->clicked($selector);
            }
        }
    }

    public function checkAPICallStatus($text, $cssORXpath):string
    {
        $this->wait(5);
        $this->amOnPage(FluentFormsAllEntries::entriesPage);
        $this->clicked(FluentFormsAllEntries::viewEntry);
        $this->clicked(FluentFormsAllEntries::apiCalls);
        $this->waitForElement($cssORXpath,10);

        for ($i = 0; $i < 6; $i++) {
            try {
                $this->clicked(FluentFormsAllEntries::apiCalls);
                $this->waitForElement($cssORXpath,10);
                $this->seeTextCaseInsensitive($text, $cssORXpath);
                break;
            } catch (Exception $e) {
                try {
                    $this->wait(10);
                    $this->reloadPage();
                } catch (Exception $e) {
                }
            }
        }
        return $this->grabTextFrom($cssORXpath);
    }




}
