<?php

declare(strict_types=1);

namespace Tests\Support;

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
     * Login to WordPress
     * @return void
     */
    public function wpLogin()
    {
        $this->wantTo('Login to Wordpress');
        $this->amOnPage('/wp-login.php');
        $this->fillField('Username','admin');
        $this->fillField('Password','admin');
        $this->click('Log In');
        $this->see('Dashboard');
    }

    public function installFluentForm()
    {
        $this->wantTo('Install FluentForm plugin');
        $this->amOnPage('wp-admin/plugin-install.php?s=Fluent+Forms+contact+form&tab=search&type=term');
        if ($this->tryToSee('Install Now', '.plugin-card.plugin-card-fluentform'))
        {
            $this->click('Install Now', '.plugin-card.plugin-card-fluentform');
            $this->waitForText('Activate',30,'.plugin-card.plugin-card-fluentform');
            $this->click('Activate', '.plugin-card.plugin-card-fluentform');
        }
        $this->amOnPage('/wp-admin/plugins.php');
        $this->see('Fluent Forms');
    }

    public function installFluentFormPro()
    {
        $KEY = fopen("tests/Support/Data/licensekey.txt", "r") or die("Unable to open file!");
        $LICENSE_KEY = fgets($KEY);


        $this->wantTo('Install FluentForm Pro plugin');
        $this->amOnPage('wp-admin/plugin-install.php');
        $this->seeElement('.upload');
        $this->click('.upload');
        $this->attachFile('input[type="file"]','fluentformpro.zip');
        $this->seeElement('#install-plugin-submit');
        $this->click('#install-plugin-submit');
        $this->waitForText('Activate Plugin',30,'.button.button-primary');
        $this->click('.button.button-primary');
        if($this->tryToSee('The Fluent Forms Pro Add On license needs to be activated. Activate Now', "div[class='error error_notice_ff_fluentform_pro_license'] p"))
        {
            $this->click('Activate Now', "div[class='error error_notice_ff_fluentform_pro_license'] p");
            $this->waitForElement("input[name='_ff_fluentform_pro_license_key']",30);
            $this->fillField("input[name='_ff_fluentform_pro_license_key']",$LICENSE_KEY);
            $this->click("input[value='Activate License']");
            $this->waitForText('Your license is active! Enjoy Fluent Forms Pro Add On');
            $this->see('Your license is active! Enjoy Fluent Forms Pro Add On');
        }
        $this->amOnPage('/wp-admin/plugins.php');
        $this->see('Fluent Forms Pro Add On Pack');
    }

    public function installFluentFormPdfGenerator()
    {
        $this->wantTo('Install FluentForm PDF Generator plugin');
        $this->amOnPage('wp-admin/plugin-install.php?s=Fluent+Forms+PDF+Generator&tab=search&type=term');
        if($this->tryToSee('Install Now', '.plugin-card.plugin-card-fluentforms-pdf'))
        {
            $this->click('Install Now', '.plugin-card.plugin-card-fluentforms-pdf');
            $this->waitForText('Activate',30,'.plugin-card.plugin-card-fluentforms-pdf');
            $this->click('Activate', '.plugin-card.plugin-card-fluentforms-pdf');
        }
        $this->amOnPage('/wp-admin/plugins.php');
        $this->see('Fluent Forms PDF Generator');
    }

    public function uninstallFluentFormPro()
    {
        //delete fluentform pro
        $this->click('Deactivate', "tr[data-slug='fluent-forms-pro-add-on-pack'] td[class='plugin-title column-primary']");
        $this->waitForText('Plugin deactivated.',30,"div[id='message'] p");
        $this->see('Plugin deactivated.',"div[id='message'] p");
        $this->click('Delete', "tr[data-slug='fluent-forms-pro-add-on-pack'] td[class='plugin-title column-primary']");
        $this->tryToAcceptPopup();
        $this->waitForText('Fluent Forms Pro Add On Pack was successfully deleted.');
        $this->see('Fluent Forms Pro Add On Pack was successfully deleted.');
    }

    public function uninstallFluentFormPdfGenerator()
    {
        //delete fluentform pdf generator
        $this->click('Deactivate', "tr[data-slug='fluentforms-pdf'] td[class='plugin-title column-primary']");
        $this->waitForText('Plugin deactivated.',30,"div[id='message'] p");
        $this->see('Plugin deactivated.',"div[id='message'] p");
        $this->click('Delete', "tr[data-slug='fluentforms-pdf'] td[class='plugin-title column-primary']");
        $this->tryToAcceptPopup();
        $this->waitForText('Fluent Forms PDF Generator was successfully deleted.');
        $this->see('Fluent Forms PDF Generator was successfully deleted.');
    }

    public function uninstallFluentForm()
    {
        //delete fluentform
        $this->click('Deactivate', "tr[data-slug='fluentform'] td[class='plugin-title column-primary']");
        $this->waitForText('Plugin deactivated.',30,"div[id='message'] p");
        $this->see('Plugin deactivated.',"div[id='message'] p");
        $this->click('Delete', "tr[data-slug='fluentform'] td[class='plugin-title column-primary']");
        $this->tryToAcceptPopup();
        $this->waitForText('Fluent Forms was successfully deleted.');
        $this->see('Fluent Forms was successfully deleted.');
    }


}
