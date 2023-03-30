<?php

declare(strict_types=1);
namespace Tests\Support;

use Codeception\Attribute\DataProvider;
use Codeception\Attribute\Skip;
use Codeception\Example;
use Tests\Support\Helper\Acceptance\Selectors\DeleteForm;
use Tests\Support\Helper\Acceptance\Selectors\GlobalPage;
use Tests\Support\Helper\Acceptance\Selectors\AccepTestSelec;
use Tests\Support\Helper\Acceptance\Selectors\NewForm;
use Tests\Support\Helper\Acceptance\Selectors\RenameForm;

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
        $this->amOnPage(GlobalPage::pluginInstallPage);
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
     * @author Sarkar Ripon
     * @return void
     * Create a new form
     *
     */
    public function createNewForm():void
    {
        $this->amOnPage(GlobalPage::fFormPage);
        if ($this->tryToClick('Add a New Form') ||
            $this->tryToClick('Click Here to Create Your First Form', NewForm::createFirstForm)) {
            $this->tryToMoveMouseOver(NewForm::blankForm);
            $this->tryToClick('Create Form');
//            $this->wait(1);
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
        $this->tryToClick(RenameForm::rename);
        $this->tryToFillField(RenameForm::renameField, $formName);
        $this->tryToClick("Rename", RenameForm::renameBtn);
        $this->wait(1);
        $this->see("Success!");
    }

}
