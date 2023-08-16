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
//        $this->waitForJs('return document.readyState === "complete"', 30);
        $this->waitForElementVisible($selector,15);
        $this->clickWithLeftButton($selector);
        parent::fillField($selector,$value);
        $this->wait(1);
    }

    public function clickOnText(string $actionText, string $followingText =null, $index=1): void
    {
//        $this->waitForJs('return document.readyState === "complete"', 30);
        $this->wait(1);
        $following = null;
        if (isset($followingText) and !empty($followingText)) {
            $following = "label[normalize-space()='$followingText']/following::";
        }
        $xpathVariations = [
            "(//$following"."div[@x-placement='bottom-start']//span[contains(text(),'{$actionText}')])[$index]",
            "(//$following"."div[@x-placement='top-start']//span[contains(text(),'{$actionText}')])[$index]",
            "(//$following"."label[normalize-space()='{$actionText}'])[$index]",
            "(//$following"."label[contains(text(),'{$actionText}')])[$index]",
            "(//$following"."span[normalize-space()='{$actionText}'])[$index]",
            "(//$following"."span[contains(text(),'{$actionText}')])[$index]",
            "(//$following"."button[contains(text(),'{$actionText}')])[$index]",
            "(//$following"."a[contains(text(),'{$actionText}')])[$index]",
            "(//$following"."h1[normalize-space()='{$actionText}'])[$index]",
            "(//$following"."h2[normalize-space()='{$actionText}'])[$index]",
            "(//$following"."h3[normalize-space()='{$actionText}'])[$index]",
            "(//$following"."h4[normalize-space()='{$actionText}'])[$index]",
            "(//$following"."p[contains(text(),'{$actionText}')])[$index]",
            "(//$following"."input[@placeholder='{$actionText}'])[$index]",
        ];

        $exception = [];
        foreach ($xpathVariations as $xpath) {
            try {
//                $this->waitForElementVisible($xpath,1);
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
           $this->fail($actionText." not found");
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
     * @param string $actionText
     * @return void
     * @throws Exception
     * @author Sarkar Ripon
     * This function will wait for the element until it can be seen.
     * This is a workaround for the issue of Codeception not waiting for the element to be visible before seen it.
     */
    public function seeText(string $actionText): void
    {
        $this->waitForText($actionText);
        parent::see($actionText);
        $this->enableImplicitWait();
    }

    public function seeTextCaseInsensitive($actionText, $selector): void
    {
        $elementText = $this->grabTextFrom($selector);
        $actionText = preg_quote($actionText, '/');
        $this->assertRegExp("/$actionText/i", $elementText);
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
            $this->waitForElement($element);
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