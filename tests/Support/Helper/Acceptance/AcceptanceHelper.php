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
        $this->wait(1);
        $this->fillField('Username',$this->config['wp_username']);
        $this->fillField('Password',$this->config['wp_password']);
        $this->click('Log In');
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

    /**
     * @author Sarkar Ripon
     * @param string $selector
     * @return void
     * @throws Exception
     * This function will wait for the element to be visible and then click on it.
     * This is a workaround for the issue of Codeception not waiting for the element to be visible before clicking on it.
     */
    public function clicked(string $selector): void
    {
        $this->wait(1);
        $this->waitForElement($selector, 15);
        $this->moveMouseOver($selector);
        parent::clickWithLeftButton($selector);
    }

    public function prepareJSforXpath(string $cssORxpath):string
    {
        return <<<JS
        var xpathExpression = "$cssORxpath";
        var element = document.evaluate(xpathExpression, document, null, XPathResult.FIRST_ORDERED_NODE_TYPE, null).singleNodeValue;
        if (element) {
            element.click();
        }
        JS;
    }
    public function clickByJS(string $cssORxpath): void
    {
        $this->executeJS($this->prepareJSforXpath($cssORxpath));
    }


    /**
     * @param string $text
     * @return void
     * @throws Exception
     * @author Sarkar Ripon
     * This function will wait for the element until it can be seen.
     * This is a workaround for the issue of Codeception not waiting for the element to be visible before seen it.
     */
    public function seeText(string $text): void
    {
        $this->waitForText($text, 10);
        parent::see($text);
        $this->enableImplicitWait();
    }

    /**
     * @author Sarkar Ripon
     * If element is found return true, if not, return false
     * @param $element
     * @return bool
     */
    public function checkElement($element): bool
    {
        try {
            $this->seeElementInDOM($element);
           return true;
        } catch (\Exception $e) {
            echo $e->getMessage()."\n";
            return false;
        }
    }





}