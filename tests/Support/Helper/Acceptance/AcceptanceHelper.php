<?php
namespace Tests\Support\Helper\Acceptance;

use Codeception\Module\WebDriver;
use Exception;
use Dotenv;

class AcceptanceHelper extends WebDriver
{

    public function env(): void
    {
        $root = $_SERVER['PWD'];
        $repository = Dotenv\Repository\RepositoryBuilder::createWithNoAdapters()
            ->addAdapter(Dotenv\Repository\Adapter\EnvConstAdapter::class)
            ->addWriter(Dotenv\Repository\Adapter\PutenvAdapter::class)
            ->immutable()
            ->make();

        $dotenv = Dotenv\Dotenv::create($repository, $root);
        $dotenv->load();
    }
    /**
     * @author Sarkar Ripon
     * @return void
     * Login to WordPress
     */
    public function wpLogin(): void
    {
//        $this->env();

        $this->amOnPage('/wp-login.php');
        $this->wait(1);
        $this->fillField('Username',getenv('WORDPRESS_USERNAME'));
        $this->fillField('Password',getenv('WORDPRESS_PASSWORD'));
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
        $this->waitForElementVisible( $selector);
        $this->moveMouseOver($selector);
        parent::clickWithLeftButton($selector);
    }

    /**
     * @throws Exception
     */
    public function filledField($selector, $value): void
    {
        $this->wait(5);
        $this->clickWithLeftButton($selector);
        parent::fillField($selector,$value);
        $this->wait(1);
    }

    public function clickOnText($text): void
    {
        $this->wait(1);
        $xpathVariations = [
            "//div[@x-placement='bottom-start']//span[contains(text(),'{$text}')]",
            "//div[@x-placement='top-start']//span[contains(text(),'{$text}')]",
            "//label[normalize-space()='{$text}']",
            "//label[contains(text(),'{$text}')]",
            "//span[normalize-space()='{$text}']",
            "//span[contains(text(),'{$text}')]",
            "//button[contains(text(),'{$text}')]",
            "//a[contains(text(),'{$text}')]",
            "//h2[normalize-space()='{$text}']",
            "//p[contains(text(),'{$text}')]",
            "//input[@placeholder='{$text}']",
        ];

        $exception = [];
        foreach ($xpathVariations as $xpath) {
            try {
                $this->seeElementInDOM($xpath);
                $this->moveMouseOver($xpath);
                $this->clickByJS($xpath);
                break; // Exit the loop if the element is found and clicked successfully
            } catch (\Exception $e) {
                $exception[] = $e->getMessage();
                // If the element is not found or the click fails, continue to the next XPath variation
            }
        }
        if(count($exception) === count($xpathVariations)){
           $this->fail($text." not found");
        }
    }

    /**
     * @throws Exception
     */
    public function clickByJS(string $selector): void
    {
        $escapeXpath = str_replace('\\', '\\\\', $selector);
        $escapedXpath = addslashes($escapeXpath);
        $this->waitForElementClickable( $selector);
        $js = <<<JS
        var xpathExpression = "$escapedXpath";
        var element = document.evaluate(xpathExpression, document, null, XPathResult.FIRST_ORDERED_NODE_TYPE, null).singleNodeValue;
        if (element) {
            element.click();
        }
        JS;
        $this->executeJS($js);
    }

    /**
     *
     * @param string $selector
     * @param string $value
     * @return void The converted XPath expression.
     * @throws Exception
     */
    public function fillByJS(string $selector, string $value): void
    {
        $escapeXpath = str_replace('\\', '\\\\', $selector);
        $escapedXpath = addslashes($escapeXpath);
        $this->waitForElementVisible($selector);
        $this->executeJS("
        var xpathResult = document.evaluate('$escapedXpath', document, null, XPathResult.FIRST_ORDERED_NODE_TYPE, null);
        var element = xpathResult.singleNodeValue;
        element.value = '$value';");

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
        $this->waitForText($text);
        parent::see($text);
        $this->enableImplicitWait();
    }

    public function seeTextCaseInsensitive($text, $selector): void
    {
        $elementText = $this->grabTextFrom($selector);
        $text = preg_quote($text, '/');
        $this->assertRegExp("/$text/i", $elementText);
    }

    /**
     * ```
     * If element is found return true, if not, return false
     * ```
     * @author Sarkar Ripon
     * @param $element
     * @return bool
     */
    public function checkElement($element): bool
    {
        try {
            $this->seeElementInDOM($element);
           return true;
        } catch (\Exception $e) {
            return false;
        }
    }

    /**
     * ```
     * This will help to check if the string is present or not.
     * Ex Arr: [$needle => $haystack]
     * ```
     * @param $checkAbleArr
     * @return void
     */
    public function assertString($checkAbleArr): void
    {
        $exception = [];
        foreach ($checkAbleArr as $needle => $haystack) {
            try {
                $this->assertStringContainsString($needle, $haystack);
            } catch (Exception $e) {
                $exception[] = $e->getMessage();
            }
        }
        if (count($exception) > 0) {
            $errorMessage = implode(PHP_EOL, $exception);
            $this->fail('Some Data missing: ' . $errorMessage. PHP_EOL);
        }
    }





}