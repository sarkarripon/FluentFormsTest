<?php
namespace Tests\Support\Helper\Acceptance;

use Codeception\Module\WebDriver;
use Exception;

class AcceptanceHelper extends WebDriver
{
    /**
     * @author Sarkar Ripon
     * @return void
     * Login to WordPress
     */
    public function wpLogin(): void
    {
        $this->amOnPage('/wp-login.php');
        $this->fillField('Username',$this->config['wp_username']);
        $this->fillField('Password',$this->config['wp_password']);
        $this->click('Log In');
        $this->see('Dashboard');
    }

    /**
     * @author Sarkar Ripon
     * @return void
     * @throws Exception
     * logout from WordPress
     */
    public function wpLogout(): void
    {
        $this->wait(2);
        $this->amOnPage('/wp-admin/index.php');
        $this->moveMouseOver("(//span[@class='display-name'])[1]");
        $this->waitForText('Log Out',1);
        $this->click('Log Out');
        $this->waitForText('You are now logged out.',5);
        $this->seeCurrentUrlMatches('/(^|\?)loggedout=true($|&)/');
        $this->see('You are now logged out.');
    }

}