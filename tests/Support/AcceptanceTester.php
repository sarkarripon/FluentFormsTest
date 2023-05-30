<?php

declare(strict_types=1);
namespace Tests\Support;

use Codeception\Attribute\DataProvider;
use Codeception\Attribute\Skip;
use Codeception\Example;
use Codeception\Util\Locator;
use Tests\Support\Helper\Acceptance\Selectors\AdvancedFieldSelec;
use Tests\Support\Helper\Acceptance\Selectors\ContainerSelec;
use Tests\Support\Helper\Acceptance\Selectors\DeleteFormSelec;
use Tests\Support\Helper\Acceptance\Selectors\FormFields;
use Tests\Support\Helper\Acceptance\Selectors\GlobalPageSelec;
use Tests\Support\Helper\Acceptance\Selectors\AccepTestSelec;
use Tests\Support\Helper\Acceptance\Selectors\NewFormSelec;
use Tests\Support\Helper\Acceptance\Selectors\NewPageSelec;
use Tests\Support\Helper\Acceptance\Selectors\RenameFormSelec;

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
        $this->amOnPage(GlobalPageSelec::fFormPage);

        $tr = count($this->grabMultiple('tr'));
        for ($i = 1; $i < ($tr); $i++) {
            do {
                try {
                    $this->click('Delete', DeleteFormSelec::deleteBtn);
                    $this->waitForText('confirm', 2);
                    $this->click(DeleteFormSelec::confirmBtn);
                    $this->wait(1);
                } catch (\Exception $e) {
                    $this->wait(1);
                }
            } while ($this->tryToClick(DeleteFormSelec::deleteBtn)==true);
        }
    }
    /**
     * @author Sarkar Ripon
     * @return void
     * Create a new form
     */
    public function initiateNewForm():void
    {
        $this->amOnPage(GlobalPageSelec::fFormPage);
        if ($this->tryToClick('Add a New Form') ||
            $this->tryToClick('Click Here to Create Your First Form', FormFields::createFirstForm)) {
            $this->tryToMoveMouseOver(FormFields::blankForm);
            $this->tryToClick('Create Form');
        }
    }

    /**
     * @author Sarkar Ripon
     * @param $formName
     * @return void
     * This function will rename the form
     */
    public function renameForm($formName):void
    {
        $this->tryToClick(RenameFormSelec::rename);
        $this->tryToFillField(RenameFormSelec::renameField, $formName);
        $this->tryToClick("Rename", RenameFormSelec::renameBtn);
        $this->wait(1);
        $this->see("Success!");
    }

    /**
     * @return void
     * This function will delete all the existing pages
     * @author Sarkar Ripon
     */
    public function deleteExistingPages(): void
    {
        $this->amOnPage(GlobalPageSelec::newPageCreationPage);
        if ( $this->tryToClick(NewPageSelec::previousPageAvailable))
        {
            $this->click(NewPageSelec::selectAllCheckMark);
            $this->selectOption(NewPageSelec::selectMoveToTrash, "Move to Trash");
            $this->click(NewPageSelec::applyBtn);
            $this->see('moved to the Trash');
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
        $this->amOnPage(GlobalPageSelec::fFormPage);
        if(!isset($content)){
            $content = $this->grabTextFrom(NewPageSelec::formShortCode);
        }
        $this->amOnPage(GlobalPageSelec::newPageCreationPage);
        $this->click(NewPageSelec::addNewPage);
        $this->wait(1);
        $this->executeJS(sprintf(NewPageSelec::jsForTitle,$title));
        $this->executeJS(sprintf(NewPageSelec::jsForContent,$content));
        $this->click( NewPageSelec::publishBtn);
        $this->waitForElementClickable(NewPageSelec::confirmPublish);
        $this->click( NewPageSelec::confirmPublish);
        $this->wait(1);
        $pageUrl = $this->grabAttributeFrom(NewPageSelec::viewPage, 'href');
        return $pageUrl; // it will return the page url and assign it to $pageUrl global variable above.
    }

    public function createFormField($data): void
    {
        $this->wantTo('Create a form for integrations');
        $this->clicked(FormFields::generalSection);

        foreach ($data as $fieldType => $fields) {
            $sectionType = match ($fieldType) {
                'advancedFields' => 'advancedSection',
                default => 'generalSection',
            };
            $this->clicked(constant(FormFields::class . '::' . $sectionType));
            foreach ($fields as $inputField){
                $selector = constant(FormFields::class . '::' . $fieldType)[$inputField];
                $this->clicked($selector);
            }
        }

    }

    public function createFormFieldBySearch($fieldName): void
    {
        $this->fillField("(//input[@placeholder='Search (name, address)'])[1]", $fieldName);
        $this->clicked("div[class='v-row mb15'] div[class='vddl-draggable btn-element']");

    }



}
