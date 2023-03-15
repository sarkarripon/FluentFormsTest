<?php

namespace Tests\Acceptance;

use Tests\Support\AcceptanceTester;
use Codeception\Util\Locator;

class WpLoginCest
{
    public function _before(AcceptanceTester $I)
    {
        $I->wantTo('Login to Wordpress');
        $I->amOnPage('/wp-login.php');
        $I->fillField('Username','admin');
        $I->fillField('Password','admin');
        $I->click('Log In');
        $I->see('Dashboard');
    }

    public function Install_fluentForm_plugin(AcceptanceTester $I)
    {
        $I->wantTo('Install FluentForm plugin');
        $I->amOnPage('wp-admin/plugin-install.php?s=Fluent+Forms+contact+form&tab=search&type=term');
        $I->click('Install Now', '.plugin-card.plugin-card-fluentform');
        $I->waitForText('Activate',30,'.plugin-card.plugin-card-fluentform');
        $I->click('Activate', '.plugin-card.plugin-card-fluentform');
        $I->amOnPage('/wp-admin/plugins.php');
        $I->see('Fluent Forms');
    }

    public function Install_fluentForm_pdf_generator_plugin(AcceptanceTester $I)
    {
        $I->wantTo('Install FluentForm PDF Generator plugin');
        $I->amOnPage('wp-admin/plugin-install.php?s=Fluent+Forms+PDF+Generator&tab=search&type=term');
        $I->click('Install Now', '.plugin-card.plugin-card-fluentforms-pdf');
        $I->waitForText('Activate',30,'.plugin-card.plugin-card-fluentforms-pdf');
        $I->click('Activate', '.plugin-card.plugin-card-fluentforms-pdf');
        $I->amOnPage('/wp-admin/plugins.php');
        $I->see('Fluent Forms PDF Generator');
    }

    public function Install_fluentFormPro_plugin( AcceptanceTester $I)
    {
        $I->wantTo('Install FluentForm Pro plugin');
        $I->amOnPage('wp-admin/plugin-install.php');
        $I->seeElement('.upload');
        $I->click('.upload');
        $I->attachFile('input[type="file"]','fluentformpro.zip');
        $I->seeElement('#install-plugin-submit');
        $I->click('#install-plugin-submit');
        $I->waitForText('Activate Plugin',30,'.button.button-primary');
        $I->click('.button.button-primary');
        $I->waitForText('The Fluent Forms Pro Add On license needs to be activated. Activate Now',30, "div[class='error error_notice_ff_fluentform_pro_license'] p");
        $I->click('Activate Now', "div[class='error error_notice_ff_fluentform_pro_license'] p");
        $I->waitForElement("input[name='_ff_fluentform_pro_license_key']",30);
        $I->fillField("input[name='_ff_fluentform_pro_license_key']",'97019eb28ede80342d3a17da2da5f41d');
        $I->click("input[value='Activate License']");
        $I->waitForText('Your license is active! Enjoy Fluent Forms Pro Add On');
        $I->see('Your license is active! Enjoy Fluent Forms Pro Add On');

//        $I->amOnPage('/wp-admin/plugins.php');
//        $I->see('Fluent Forms Pro Add On Pack');

    }
}
