<?php

namespace Tests\Acceptance;

use Tests\Support\AcceptanceTester;
use Codeception\Util\Locator;
class WpLoginCest
{
    public function _before(AcceptanceTester $I)
    {
        $I->wpLogin();
    }

    public function Install_plugins(AcceptanceTester $I)
    {
        $I->installFluentForm();
//        $I->installFluentFormPdfGenerator();
        $I->installFluentFormPro();
    }


//Main test function goes here




    public function UninstallPlugins(AcceptanceTester $I)
    {
        $I->wantTo('Clean up plugin');
        $I->amOnPage('/wp-admin/plugins.php');

//        $I->uninstallFluentFormPro();
//        $I->uninstallFluentFormPdfGenerator();
//        $I->uninstallFluentForm();
    }
}