<?php

namespace Tests\Support\Helper\Acceptance;

use Codeception\Module\WebDriver;
use Dotenv;
use Exception;

class AcceptanceHelper extends WebDriver
{
    public function loadDotEnvFile(): void
    {
        $root = $_SERVER['PWD'];
        $repository = Dotenv\Repository\RepositoryBuilder::createWithNoAdapters()->addAdapter(Dotenv\Repository\Adapter\EnvConstAdapter::class)->addWriter(Dotenv\Repository\Adapter\PutenvAdapter::class)->immutable()->make();
        $dotenv = Dotenv\Dotenv::create($repository, $root);
        $dotenv->load();
    }

    /**
     * @return void
     * Login to WordPress
     * @throws Exception
     * @author Sarkar Ripon
     */
    public function loginWordpress(string $username = null, string $password = null): void
    {
        $username = $username ?? getenv('WORDPRESS_USERNAME');
        $password = $password ?? getenv('WORDPRESS_PASSWORD');
        $this->amOnPage('/wp-login.php');
        $this->wait(1);
        $this->fillField('Username', $username);
        $this->fillField('Password', $password);
        $this->click('Log In');
        $this->waitForText('Dashboard', 5);
        $this->see("Dashboard");
        $this->saveSessionSnapshot("loginWordpress");

    }

    /**
     * @throws Exception
     */
    public function restartSession(): void
    {
        parent::_restart();
    }

    public function cleanCookies(): void
    {
        $this->executeJS('
            var cookies = document.cookie.split(";");
            for (var i = 0; i < cookies.length; i++) {
                var cookie = cookies[i].trim();
                var cookieName = cookie.split("=")[0];
                document.cookie = cookieName + "=; expires=Thu, 01 Jan 1970 00:00:00 UTC; path=/;";
            }
        ');
        $this->reloadPage();
    }

    /**
     * @return void
     * @throws Exception
     * logout from WordPress
     * @author Sarkar Ripon
     */
    public function wpLogout(): void
    {
        $this->wait(2);
        $this->amOnPage('/wp-admin/index.php');
        $this->moveMouseOver("(//span[@class='display-name'])[1]");
        $this->waitForText('Log Out', 1);
        $this->click('Log Out');
        $this->waitForText('You are now logged out.', 5);
        $this->seeCurrentUrlMatches('/(^|\?)loggedout=true($|&)/');
        $this->see('You are now logged out.');
    }

    /**
     * @throws Exception
     */
    public function filledField($selector, $value): void
    {
        $this->waitForElementVisible($selector);
        $this->clearField($selector);
        $this->clickWithLeftButton($selector);
        parent::type($value, .7);
    }

    public function clickOnText(string $actionText, string $followingText = null, $index = 1): void
    {
//        $this->wait(1);
        $following = null;
        if (isset($followingText) and !empty($followingText)) {
            $following .= "*[normalize-space()='$followingText' or contains(text(),'$followingText')]/following::";
        }
        $xpathVariations = ["(//$following" . "*[@x-placement]//*[contains(text(),'{$actionText}')])[$index]", "(//$following" . "*[@x-placement]//*[normalize-space()='{$actionText}')])[$index]", "(//$following" . "*[normalize-space()='{$actionText}'])[$index]", "(//$following" . "*[contains(text(),'{$actionText}')])[$index]", "(//$following" . "*[@placeholder='{$actionText}'])[$index]",];
//        print_r($xpathVariations);

        $exception = [];
        foreach ($xpathVariations as $xpath) {
            try {
                $this->waitForElementVisible($xpath);
                $this->clicked($xpath);
                echo "Clicked on " . $xpath . PHP_EOL;
                break; // Exit the loop if the element is found and clicked successfully
            } catch (Exception $e) {
                $exception[] = $e->getMessage();
                // If the element is not found or the click fails, continue to the next XPath variation
            }
        }
        if (count($exception) === count($xpathVariations)) {
            $this->fail($actionText . " not found");
        }
    }

    /**
     * @param string $selector
     * @return void
     * @throws Exception
     * This function will wait for the element to be visible and then click on it.
     * This is a workaround for the issue of Codeception not waiting for the element to be visible before clicking on it.
     * @author Sarkar Ripon
     */
    public function clicked(string $selector): void
    {
        $this->waitForElementClickable($selector);
        $this->moveMouseOver($selector);
        parent::clickWithLeftButton($selector);
    }

    public function clickedOnText(string $actionText, string $followingText = null, $index = null): void
    {
        $following = "";
        if (!empty($followingText)) {
            $following = "*[normalize-space()='$followingText' or contains(text(),'$followingText')]/following::";
        }

        $indexPart = "";
        if ($index !== null) {
            $indexPart = "[$index]";
        }

        $xpathVariations = ["(//$following" . "*[@x-placement]//*[contains(text(),'{$actionText}')])$indexPart", "(//$following" . "*[@x-placement]//*[normalize-space()='{$actionText}'])$indexPart", "(//$following" . "*[normalize-space()='{$actionText}'])$indexPart", "(//$following" . "*[contains(text(),'{$actionText}')])$indexPart", "(//$following" . "*[@placeholder='{$actionText}'])$indexPart",];
//        print_r($xpathVariations);

        $exception = [];
        foreach ($xpathVariations as $xpath) {
            try {
                $this->waitForElementVisible($xpath,3);
                $isMultiple = count($this->grabMultiple($xpath));
                if ($isMultiple >= 2) {
                    $this->clickWithLeftButton($xpath . "[$isMultiple]", 10, 10) . PHP_EOL;
                    echo "Multiple found,clicked on " . $xpath . "[$isMultiple]" . PHP_EOL;
                } else {
                    $this->clickWithLeftButton($xpath, 10, 10);
                    echo "Clicked on " . $xpath . PHP_EOL;
                }
                break; // Exit the loop if the element is found and clicked successfully
            } catch (Exception $e) {
                $exception[] = $e->getMessage();
                // If the element is not found or the click fails, continue to the next XPath variation
            }
        }
        if (count($exception) === count($xpathVariations)) {
            $this->fail($actionText . " not found");
        }
    }

    public function clickOnExactText(string $actionText, string $followingText = null, $index = null): void
    {
        $following = "";
        if (!empty($followingText)) {
            $following = "*[normalize-space()='$followingText']/following::";
        }

        $indexPart = "";
        if ($index !== null) {
            $indexPart = "[$index]";
        }

        $xpathVariations = ["(//$following" . "*[@x-placement]//*[text()='{$actionText}'])$indexPart", "(//$following" . "*[@x-placement]//*[normalize-space()='{$actionText}'])$indexPart", "(//$following" . "*[normalize-space()='{$actionText}'])$indexPart", "(//$following" . "*[text()='{$actionText}'])$indexPart", "(//$following" . "*[@placeholder='{$actionText}'])$indexPart",];
//        print_r($xpathVariations);

        $exception = [];
        foreach ($xpathVariations as $xpath) {
            try {
                $this->waitForElementVisible($xpath,3);
                $isMultiple = count($this->grabMultiple($xpath));
                if ($isMultiple >= 2) {
                    $this->clickWithLeftButton($xpath . "[$isMultiple]") . PHP_EOL;
                    echo "Multiple found,clicked on " . $xpath . "[$isMultiple]" . PHP_EOL;
                } else {
                    $this->clickWithLeftButton($xpath);
                    echo "Clicked on " . $xpath . PHP_EOL;
                }
                break; // Exit the loop if the element is found and clicked successfully
            } catch (Exception $e) {
                $exception[] = $e->getMessage();
                // If the element is not found or the click fails, continue to the next XPath variation
            }
        }
        if (count($exception) === count($xpathVariations)) {
            $this->fail($actionText . " not found");
        }
    }

    /**
     * @throws Exception
     */
    public function clickByJS(string $selector): void
    {
        $escapeXpath = str_replace('\\', '\\\\', $selector);
        $escapedXpath = addslashes($escapeXpath);
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
     * @param $element
     * @return bool
     * @author Sarkar Ripon
     */
    public function checkElement($element): bool
    {
        try {
            $this->waitForElementVisible($element,5);
            $this->seeElementInDOM($element);
            return true;
        } catch (Exception $e) {
            return false;
        }
    }

    /**
     * ```
     * This will help to check if the string is present or not.
     * Ex Arr: [$needle => $haystack]
     * ```
     * @param array $checkAbleArr
     * @return void
     */
    public function assertString(array $checkAbleArr): void
    {
        $exception = [];
        foreach ($checkAbleArr as $needle => $haystack) {
            try {
                if (isset($haystack) and !empty($haystack)) {
                    $this->assertStringContainsString($needle, $haystack);
                } else {
                    $this->fail($needle . " not found");
                }

            } catch (Exception $e) {
                $exception[] = $e->getMessage();
            }
        }
        if (count($exception) > 0) {
            $errorMessage = implode(PHP_EOL, $exception);
            $this->fail('Some Data missing: ' . $errorMessage . PHP_EOL);
        } else {
            echo "Hurray......! All data found.";
        }
    }

//    public function checkValuesInArray($dataArray, $searchStrings) {
//        $foundValues = [];
//        $notFoundValues = [];
//
//        foreach ($searchStrings as $searchString) {
//            $found = false;
//
//            array_walk_recursive($dataArray, function ($value) use ($searchString, &$found) {
//                if (is_string($value) && stripos($value, $searchString) !== false) {
//                    $found = true;
//                }
//            });
//
//            if ($found) {
//                $foundValues[] = $searchString;
//            } else {
//                $notFoundValues[] = $searchString;
//            }
//        }
//
//        return [
//            'found' => $foundValues,
//            'notFound' => $notFoundValues,
//        ];
//    }


    public function checkValuesInArray(array $dataArray, $searchStrings): bool
    {
        $foundValues = [];
        $notFoundValues = [];

        if (is_string($searchStrings)) {
            $searchStrings = [$searchStrings];
        }

        foreach ($searchStrings as $searchString) {
            $found = false;

            array_walk_recursive($dataArray, function ($value) use ($searchString, & $found) {
                if (is_string($value) && stripos($value, $searchString) !== false) {
                    $found = true;
                }
            });

            if ($found) {
                $foundValues[] = $searchString;
            } else {
                $notFoundValues[] = $searchString;
            }
        }

        $message = '';
        if (count($foundValues) > 0) {
            $message .= "Found Values:" . PHP_EOL;
            foreach ($foundValues as $foundValue) {
                $message .= "- " . $foundValue . PHP_EOL;
            }
        }
        if (count($notFoundValues) > 0) {
            $message .= "Missing Values:" . PHP_EOL;
            foreach ($notFoundValues as $notFoundValue) {
                $message .= "- " . $notFoundValue . PHP_EOL;
            }
        }

        if (count($notFoundValues) > 0) {
            $this->fail($message);
        } else {
            return true;
        }

        return false;
    }


}