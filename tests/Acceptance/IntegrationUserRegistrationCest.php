<?php


namespace Tests\Acceptance;
use Codeception\Module\WebDriver;
use Facebook\WebDriver\WebDriverKeys;
use Tests\Support\AcceptanceTester;

class IntegrationUserRegistrationCest
{
    public function _before(AcceptanceTester $I)
    {
        $I->loadDotEnvFile(); $I->loginWordpress();
    }

    public function test_user_registration(AcceptanceTester $I)
    {
        $I->amOnPage('/');
        $I->wait(2);
        $I->seeText(array('admin'));
        $I->restartSession();
        $I->amOnPage('/');
        $I->wait(2);
        $I->dontSee('admin');

        $I->loginWordpress('ripon','#dz)UzUzfR)lKhMthT$bnTEm');
        exit();

    }
}
