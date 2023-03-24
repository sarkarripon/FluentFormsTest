<?php
namespace Tests\Support\Helper\Acceptance;

use Codeception\Module\WebDriver;

class AcceptanceHelper extends WebDriver
{
    /**
     * @author Sarkar Ripon
     * Login to WordPress
     * @return void
     */
    public function wpLogin(): void
    {
        $this->amOnPage('/wp-login.php');
        $this->fillField('Username',$this->config['wp_username']);
        $this->fillField('Password',$this->config['wp_password']);
        $this->click('Log In');
        $this->see('Dashboard');
    }

}