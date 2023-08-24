<?php
namespace Tests\Support\Helper\Acceptance;

use Codeception\Module\WebDriver;
use Exception;
use Dotenv;

class AcceptanceHelper extends WebDriver
{
    public function loadDotEnvFile(): void
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
     * @return void
     * Login to WordPress
     * @throws Exception
     * @author Sarkar Ripon
     */
    public function loginWordpress(string $username=null, string $password=null): void
    {
        $username = $username ?? getenv('WORDPRESS_USERNAME');
        $password = $password ?? getenv('WORDPRESS_PASSWORD');
        $this->amOnPage('/wp-login.php');
        $this->wait(1);
        $this->fillField('Username',$username);
        $this->fillField('Password',$password);
        $this->click('Log In');
        $this->waitForText('Dashboard',5);
        $this->see("Dashboard");
        $this->saveSessionSnapshot("loginWordpress");

    }
    public function restartSession(array $config = []): void
    {
        parent::_restart($config); // TODO: Change the autogenerated stub
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
        $this->waitForElementClickable( $selector);
        $this->moveMouseOver($selector);
        parent::clickWithLeftButton($selector);
    }

    /**
     * @throws Exception
     */
    public function filledField($selector, $value): void
    {
//        $this->performOn($selector, function (WebDriver $I) use ($selector, $value) {
//            $I->moveMouseOver($selector);
//            $I->fillField($selector, $value);
//        });
        $this->waitForElementVisible($selector);
        $this->clickWithLeftButton($selector);
        parent::fillField($selector,$value);
    }

    public function clickOnText(string $actionText, string $followingText =null, $index=1): void
    {
        $this->wait(2);
        $following = null;
        if (isset($followingText) and !empty($followingText)) {
            $following .= "*[normalize-space()='$followingText' or contains(text(),'$followingText')]/following::";
        }
        $xpathVariations = [
            "(//$following"."*[@x-placement]//*[contains(text(),'{$actionText}')])[$index]",
            "(//$following"."*[@x-placement]//*[normalize-space()='{$actionText}')])[$index]",
            "(//$following"."*[normalize-space()='{$actionText}'])[$index]",
            "(//$following"."*[contains(text(),'{$actionText}')])[$index]",
            "(//$following"."*[@placeholder='{$actionText}'])[$index]",
        ];
//        print_r($xpathVariations);

        $exception = [];
        foreach ($xpathVariations as $xpath) {
            try {
                $this->seeElementInDOM($xpath);
                $this->moveMouseOver($xpath);
                $this->clicked($xpath);
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
//        $this->waitForElementClickable( $selector);
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
//            $this->waitForElement($element);
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
    public function assertString(array $checkAbleArr): void
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
        }else{
            echo "Hurray......! All data found.";
        }
    }





}