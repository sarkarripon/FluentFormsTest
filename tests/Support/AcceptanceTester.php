<?php

declare(strict_types=1);
namespace Tests\Support;

use Tests\Support\Helper\Acceptance\Selectors\GlobalPageSelec;
use Tests\Support\Helper\Acceptance\Selectors\AccepTestSelec;

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
     * Install FluentForm plugin
     * @return void
     */
    public function installFluentForm(): void
    {
        //Install FluentForm plugin from local
        $this->wantTo('Install FluentForm plugin');
        $this->amOnPage(GlobalPageSelec::pluginInstallPage);
        $this->seeElement(AccepTestSelec::uploadField);
        $this->click(AccepTestSelec::uploadField);
        $this->attachFile(AccepTestSelec::inputField,AccepTestSelec::fluentForm);
        $this->seeElement(AccepTestSelec::submitButton);
        $this->click(AccepTestSelec::submitButton);
        $this->waitForText('Activate Plugin',5,AccepTestSelec::activateButton);
        $this->click(AccepTestSelec::activateButton);
    }

    /**
     * @author Sarkar Ripon
     * Install FluentForm PDF Generator plugin
     * @return void
     */
    public function installFluentFormPdfGenerator(): void
    {
        //Install FluentForm PDF Generator plugin from local
        $this->wantTo('Install FluentForm PDF generator plugin');
        $this->amOnPage(GlobalPageSelec::pluginInstallPage);
        $this->seeElement(AccepTestSelec::uploadField);
        $this->click(AccepTestSelec::uploadField);
        $this->attachFile(AccepTestSelec::inputField,AccepTestSelec::fluentFormPdf);
        $this->seeElement(AccepTestSelec::submitButton);
        $this->click(AccepTestSelec::submitButton);
        $this->waitForText('Activate Plugin',10,AccepTestSelec::activateButton);
        $this->click(AccepTestSelec::activateButton);
    }

    /**
     * @author Sarkar Ripon
     * Install FluentForm Pro plugin
     * @return void
     */
    public function installFluentFormPro(): void
    {
        //Install FluentForm Pro plugin from local
        $this->wantTo('Install FluentForm Pro plugin');
        $this->amOnPage(GlobalPageSelec::pluginInstallPage);
        $this->seeElement(AccepTestSelec::uploadField);
        $this->click(AccepTestSelec::uploadField);
        $this->attachFile(AccepTestSelec::inputField,AccepTestSelec::fluentFormPro);
        $this->seeElement(AccepTestSelec::submitButton);
        $this->click(AccepTestSelec::submitButton);
        $this->waitForText('Activate Plugin',10,AccepTestSelec::activateButton);
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
     * Remove FluentForm Pro license
     * @return void
     */
    public function removeFluentFormProLicense():void
    {
        $this->tryToClick('Deactivate License',AccepTestSelec::licenseBtn);
        $this->see('Enter your license key', AccepTestSelec::licenseBtn);
    }

    /**
     * @author Sarkar Ripon
     * Uninstall FluentForm Pro plugin
     * @return void
     */
    public function uninstallFluentFormPro():void
    {
        //delete fluent form pro
        $this->click('Deactivate', AccepTestSelec::fFormProRemoveBtn);
        $this->waitForText('Plugin deactivated.',10,AccepTestSelec::msg);
        $this->see('Plugin deactivated.',AccepTestSelec::msg);
        $this->click('Delete', AccepTestSelec::fFormProRemoveBtn);
        $this->tryToAcceptPopup();
        $this->waitForText('Fluent Forms Pro Add On Pack was successfully deleted.');
        $this->see('Fluent Forms Pro Add On Pack was successfully deleted.');
    }

    /**
     * @author Sarkar Ripon
     * Uninstall FluentForm PDF Generator plugin
     * @return void
     */
    public function uninstallFluentFormPdfGenerator():void
    {
        //delete fluent form pdf generator
        $this->click('Deactivate', AccepTestSelec::fFormPdfRemoveBtn);
        $this->waitForText('Plugin deactivated.',10,AccepTestSelec::msg);
        $this->see('Plugin deactivated.',AccepTestSelec::msg);
        $this->click('Delete', AccepTestSelec::fFormPdfRemoveBtn);
        $this->tryToAcceptPopup();
        $this->waitForText('Fluent Forms PDF Generator was successfully deleted.');
        $this->see('Fluent Forms PDF Generator was successfully deleted.');
    }

    /**
     * @author Sarkar Ripon
     * Uninstall FluentForm plugin
     * @return void
     */
    public function uninstallFluentForm():void
    {
        //delete fluent form
        $this->click('Deactivate', AccepTestSelec::fFormRemoveBtn);
        $this->waitForText('Plugin deactivated.',10,AccepTestSelec::msg);
        $this->see('Plugin deactivated.',AccepTestSelec::msg);
        $this->click('Delete', AccepTestSelec::fFormRemoveBtn);
        $this->tryToAcceptPopup();
        $this->waitForText('Fluent Forms was successfully deleted.');
        $this->see('Fluent Forms was successfully deleted.');
    }


}
