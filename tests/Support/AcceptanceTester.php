<?php
declare(strict_types=1);

namespace Tests\Support;

use Codeception\Exception\ModuleException;
use Codeception\Lib\Actor\Shared\Retry;
use Exception;
use Tests\Support\Selectors\AccepTestSelec;
use Tests\Support\Selectors\FluentFormsAllEntries;
use Tests\Support\Selectors\FluentFormsSelectors;
use Tests\Support\Selectors\FluentFormsSettingsSelectors;
use Tests\Support\Selectors\GlobalPageSelec;
use Tests\Support\Selectors\NewPageSelectors;
use Tests\Support\Selectors\RenameFormSelec;


/**
 * Inherited Methods
 * @method void wantTo($text)
 * @method void wantToTest($text)
 * @method void execute($callable)
 * @method void expectTo($prediction)
 * @method void expect($prediction)
 * @method void amGoingTo($argumentation)
 * @method void am($role)
 * @method void lookForwardTo($achieveValue)
 * @method void comment($description)
 * @method void pause($vars = [])
 *
 * @SuppressWarnings(PHPMD)
 */
class AcceptanceTester extends \Codeception\Actor
{
    use _generated\AcceptanceTesterActions;
    use \Codeception\Lib\Actor\Shared\Retry;


    public function toggleOn(AcceptanceTester $I, string $followingText, bool $isToggleRight= true ): void
    {
        if ($isToggleRight) {
            $selector = "(//span[normalize-space()='$followingText']/following::*[contains(@class, 'el-checkbox__input') or contains(@class, 'el-switch') or contains(@class, 'el-radio')])[1]";
        } else {
            $selector = "(//span[normalize-space()='$followingText']/preceding::*[contains(@class, 'el-checkbox__input') or contains(@class, 'el-switch') or contains(@class, 'el-radio')])[1]";
        }
        try {
            $I->waitForElementVisible($selector);
            $classAttribute = $I->grabAttributeFrom($selector, 'class');
            if (!str_contains($classAttribute, 'is-checked')) {
                $I->clicked($selector);
            }
        }catch (Exception $e){
        }
    }

    public function runShellCommand(AcceptanceTester $I, $commands): void
    {
        if (!is_array($commands)) {
            $commands = [$commands]; // Convert single string to array
        }
        foreach ($commands as $command) {
            // Execute a shell command
            $output = [];
            exec($command, $output);

            // Display the output
            foreach ($output as $line) {
                $I->comment($line);
            }
        }
    }

    /**
     * @param array $texts
     * @return void
     * @author Sarkar Ripon
     * This function will wait for the element until it can be seen.
     * This is a workaround for the issue of Codeception not waiting for the element to be visible before seen it.
     */
    public function seeText($texts): void
    {
        if (!is_array($texts)) {
            $texts = [$texts]; // Convert single string to array
        }
        $this->retry(4, 200);
        $foundTexts = [];
        $missingTexts = [];

        foreach ($texts as $text) {
            try {
                $this->retrySee($text);
                $foundTexts[] = $text;
            } catch (\Exception $e) {
                $missingTexts[] = $text;
            }
        }
        $message = '';
        if (count($foundTexts) > 0) {
            $message .= "Found Texts:" . PHP_EOL;
            foreach ($foundTexts as $foundText) {
                $message .= "- " . $foundText . PHP_EOL;
            }
        }
        if (count($missingTexts) > 0) {
            $message .= "Missing Texts:" . PHP_EOL;
            foreach ($missingTexts as $missingText) {
                $message .= "- " . $missingText . PHP_EOL;
            }
            $this->fail($message);
        }
    }
    public function checkText($texts): ?bool
    {
        if (!is_array($texts)) {
            $texts = [$texts]; // Convert single string to array
        }
        $this->retry(4, 200);
        $missingTexts = [];

        foreach ($texts as $text) {
            try {
                $this->retrySee($text);
            } catch (\Exception $e) {
                $missingTexts[] = $text;
            }
        }
        if (count($missingTexts) > 0) {
            return false; // Some texts are missing
        }
        return true; // All texts are found
    }



    /**
     * ```
     * This function will check if the element is present or not first, then reload once if not found.
     * ```
     * @param $selector
     * @return void
     * @author Sarkar Ripon
     */
    public function reloadIfElementNotFound($selector): void
    {
        try {
            $this->seeElementInDOM($selector);
        } catch (Exception $e) {
            $this->reloadPage();
        }
    }

    /**
     * ```
     * This function will check the Success message
     * ```
     * @param $message
     * @return void
     * @author Sarkar Ripon
     */
    public function seeSuccess($message): void
    {
        $this->waitForElementVisible("(//div[@role='alert'])[1]");
        $text =  $this->grabTextFrom("(//div[@role='alert'])[1]");
        echo $text .PHP_EOL;
        $this->assertStringContainsString($message, $text);

    }

    /**
     * ```
     * This function will install the plugin from the Data directory.
     * ```
     * @param string $pluginName
     * @return void
     * Install plugin from local
     * @author Sarkar Ripon
     */
    public function installPlugin(string $pluginName): void
    {
        $this->wantTo('Install ' . $pluginName . ' plugin');
        $this->amOnPage(GlobalPageSelec::pluginInstallPage);
        $this->seeElement(AccepTestSelec::uploadField);
        $this->click(AccepTestSelec::uploadField);
        $this->attachFile(AccepTestSelec::inputField, $pluginName);
        $this->seeElement(AccepTestSelec::submitButton);
        $this->click(AccepTestSelec::submitButton);
        $this->waitForText('Activate Plugin', 5, AccepTestSelec::activateButton);
        $this->click(AccepTestSelec::activateButton);
    }

    /**
     * ```
     * Activate FluentForm Pro plugin
     * ```
     * @return void
     * @author Sarkar Ripon
     */
    public function activateFluentFormPro(): void
    {
        //Import license key
        $KEY = fopen(AccepTestSelec::licenseKey, "r") or die("Unable to open file!");
        $LICENSE_KEY = fgets($KEY);
        fclose($KEY);

        if ($this->tryToSee('The Fluent Forms Pro Add On license needs to be activated', AccepTestSelec::activeNowBtn)) {
            $this->click('Activate Now', AccepTestSelec::activeNowBtn);
            $this->waitForElement(AccepTestSelec::licenseInputField, 60);
            $this->fillField(AccepTestSelec::licenseInputField, $LICENSE_KEY);
            $this->click(AccepTestSelec::activateLicenseBtn);
            $this->see('Your license is active! Enjoy Fluent Forms Pro Add On');
        }
    }

    /**
     * ```
     * Remove FluentForm Pro license
     * ```
     * @return void
     * @author Sarkar Ripon
     */
    public function removeFluentFormProLicense(): void
    {
        $this->tryToClick('Deactivate License', AccepTestSelec::licenseBtn);
        $this->see('Enter your license key', AccepTestSelec::licenseBtn);
    }

    /**
     * ```
     * Uninstall plugin


     * ```
     * @param string $pluginSlug
     * @return void
     *
     * @author Sarkar Ripon
     */
    public function uninstallPlugin(string $pluginSlug): void
    {
        $slug = str_replace(" ", "-", strtolower($pluginSlug));

        $this->click('Deactivate', "tr[data-slug='" . $slug . "'] td[class='plugin-title column-primary']");
        $this->waitForText('Plugin deactivated.', 10, AccepTestSelec::msg);
        $this->see('Plugin deactivated.', AccepTestSelec::msg);
        $this->click('Delete', "tr[data-slug='" . $slug . "'] td[class='plugin-title column-primary']");
        $this->tryToAcceptPopup();
        $this->waitForText('successfully deleted.');
        $this->see('successfully deleted.');


    }

    /**
     * ```
     * This function will delete all the existing forms
     * ```
     * @return void
     * @author Sarkar Ripon
     */
    public function deleteExistingForms(): void
    {
        $this->amOnPage(FluentFormsSelectors::fFormPage);
        $this->wait(2);
        $tableRows = $this->grabMultiple("tr");
        $tableRows = array_slice($tableRows, 0, -1);

        foreach ($tableRows as $row) {
            $this->retryMoveMouseOver(FluentFormsSelectors::mouseHoverMenu);
            $this->retryClicked(FluentFormsSelectors::deleteBtn);
            $this->waitForElementVisible(FluentFormsSelectors::confirmBtn);
            $this->retryClicked(FluentFormsSelectors::confirmBtn);
//            $this->reloadPage();
        }
    }
    /**
     * ```
     * Create a new form
     * ```
     * @return void
     * @author Sarkar Ripon
     */
    public function initiateNewForm(): void
    {
        $this->amOnPage(FluentFormsSelectors::fFormPage);
        $this->clicked(FluentFormsSelectors::addNewForm);
        $this->clicked(FluentFormsSelectors::blankForm);
    }
    public function initiateNewCptForm( $isPost = true): void
    {
        $this->amOnPage(FluentFormsSelectors::fFormPage);
        $this->clicked(FluentFormsSelectors::addNewForm);
        $this->clicked(FluentFormsSelectors::cptForm);
        $this->clicked("//h4[normalize-space()='Select Post Type']/following::input[@placeholder='Select']");

        if ($isPost) {
            $this->clickOnExactText("post",'Select Post Type');
        } else {
            $this->clickOnExactText("page",'Select Post Type');
        }
        $this->clickOnExactText('Continue','Select Post Type');

    }

    /**
     * ```
     * This function will rename the form
     * ```
     * @param $formName
     * @return void
     * @author Sarkar Ripon
     */
    public function renameForm($formName): void
    {
        $this->waitForElementVisible(RenameFormSelec::rename, 10);
        $this->click(RenameFormSelec::rename);
        $this->fillField(RenameFormSelec::renameField, $formName);
        $this->click("Rename", RenameFormSelec::renameBtn);
    }

    /**
     *```
     * This function will delete all the existing pages
     * ```
     * @return void
     * @author Sarkar Ripon
     */
    public function deleteExistingPages(): void
    {
        $this->wait(1);
        $this->amOnPage(GlobalPageSelec::newPageCreationPage);
        $existingPage = $this->checkElement(NewPageSelectors::previousPageAvailable);

        if ($existingPage) {
            $this->clicked(NewPageSelectors::selectAllCheckMark);
            $this->selectOption(NewPageSelectors::selectMoveToTrash, "Move to Trash");
            $this->click(NewPageSelectors::applyBtn);
            $this->assertStringContainsString('moved to the Trash',
                $this->grabTextFrom('#message'), 'Existing pages were deleted successfully!');
            $this->clicked("//li[@class='trash']");
            $this->clicked("(//input[@id='delete_all'])[1]");
        }
    }

    /**
     * ```
     * This function will create a new page with title and content
     * ```
     * @param string $title
     * @param string|null $formID
     * @return string
     * @author Sarkar Ripon
     */
    public function createNewPage(string $title, string $formID=null): string
    {
        $this->wait(1);
        global $pageUrl;
        global $formID;
        echo $formID;
        if (empty($formID)) {
            $this->amOnPage(FluentFormsSelectors::fFormPage);
            $this->waitForElement(NewPageSelectors::formShortCode, 10);
            $formID = $this->grabTextFrom(NewPageSelectors::formShortCode);
        }
        $uri = $this->tryToSeeCurrentUrlMatches('edit\.php');
        if (!$uri) {
            $this->amOnPage(GlobalPageSelec::newPageCreationPage);
        }
//        $this->amOnPage(GlobalPageSelec::newPageCreationPage);
        $this->tryToClicked(NewPageSelectors::addNewPage);

        $this->tryToExecuteJS(sprintf(NewPageSelectors::jsForTitle, $title));
        $this->tryToExecuteJS(sprintf(NewPageSelectors::jsForContent, $formID));
        $this->tryToClicked(NewPageSelectors::publishBtn);
        $this->waitForElementClickable(NewPageSelectors::confirmPublish);
        $this->clicked(NewPageSelectors::confirmPublish);
        $this->waitForElement(NewPageSelectors::viewPage);
        $pageUrl = $this->grabAttributeFrom(NewPageSelectors::viewPage, 'href');
        return $pageUrl; // it will return the page url and assign it to $pageUrl global variable above.
    }

    /**
     * ```
     * This function will click on different field from different section.
     * ```
     * @param $data
     * @return void
     * @author Sarkar Ripon
     */
    public function createFormField($data, $isCpt=false): void
    {
        $this->wantTo('Create a form for integrations');
        $isCpt
            ? $this->clicked(FluentFormsSelectors::postSection)
            : $this->clicked(FluentFormsSelectors::generalSection);

        foreach ($data as $fieldType => $fields) {
            $sectionType = match ($fieldType) {
                default => 'generalSection',
                'advancedFields' => 'advancedSection',
                'postFields' => 'postSection',
                'taxonomyFields' => 'taxonomySection',
            };
            $this->clicked(constant(FluentFormsSelectors::class . '::' . $sectionType));
            foreach ($fields as $inputField) {
                $selector = constant(FluentFormsSelectors::class . '::' . $fieldType)[$inputField];
                $this->clicked($selector);
            }
        }
    }

    public function createCustomFormField($data, array $customNameArr = null, $isCpt=false): void
    {
        $this->wantTo('Create a form for integrations');
        $isCpt
            ? $this->clicked(FluentFormsSelectors::postSection)
            : $this->clicked(FluentFormsSelectors::generalSection);


        $counter = 1;
        foreach ($data as $fieldType => $fields) {
            $sectionType = match ($fieldType) {
                default => 'generalSection',
                'advancedFields' => 'advancedSection',
                'postFields' => 'postSection',
                'taxonomyFields' => 'taxonomySection',
            };
            $this->clicked(constant(FluentFormsSelectors::class . '::' . $sectionType));
            foreach ($fields as $inputField) {
                $customNames = $customNameArr[$inputField] ?? null;
                if (is_array($customNames)) {
                    foreach ($customNames as $customName) {
                        $selector = constant(FluentFormsSelectors::class . '::' . $fieldType)[$inputField];
                        $this->clicked($selector);
                        $this->clickByJS("(//div[contains(@class,'item-actions-wrapper')])[{$counter}]");

                        if ($inputField === 'nameFields') {
                            $this->filledField("//div[@edititem='[object Object]']//input[@type='text']", $customName);
                        } else {
                            $this->filledField("//div[@prop='label']//input[@type='text']", $customName);
                        }
                        $this->clicked("//a[normalize-space()='Input Fields']");
                        $counter++;
                    }
                } else {
                    $selector = constant(FluentFormsSelectors::class . '::' . $fieldType)[$inputField];
                    $this->clicked($selector);
                    $this->clickByJS("(//div[contains(@class,'item-actions-wrapper')])[{$counter}]");

                    if ($inputField == 'nameFields') {
                        $this->filledField("//div[@edititem='[object Object]']//input[@type='text']", $customNames);
                    } else {
                        $this->filledField("//div[@prop='label']//input[@type='text']", $customNames);
                    }
                    $this->clicked("//a[normalize-space()='Input Fields']");
                    $counter++;
                }
            }
        }
    }


//    public function createCustomFormField($data, array $customNameArr = null): void
//    {
//        $this->wantTo('Create a form for integrations');
//        $this->clicked(FluentFormsSelectors::generalSection);
//
//        $counter = 1;
//
//        foreach ($data as $fieldType => $fields) {
//            $sectionType = match ($fieldType) {
//                default => 'generalSection',
//                'advancedFields' => 'advancedSection',
//            };
//            $this->clicked(constant(FluentFormsSelectors::class . '::' . $sectionType));
//
//            foreach ($fields as $inputField) {
//                $selector = constant(FluentFormsSelectors::class . '::' . $fieldType)[$inputField];
//                $this->clicked($selector);
//                $this->clickByJS("(//div[contains(@class,'item-actions-wrapper')])[{$counter}]");
//
//                $customNames = is_array($customNameArr[$inputField] ?? null) ? $customNameArr[$inputField] : [$customNameArr[$inputField]];
//
//                foreach ($customNames as $customName) {
//                    if ($customName) {
//                        if ($inputField == 'nameFields') {
//                            $this->filledField("//div[@edititem='[object Object]']//input[@type='text']", $customName);
//                        } else {
//                            $this->filledField("//div[@prop='label']//input[@type='text']", $customName);
//                        }
//                    }
//                }
//
//                $this->clicked("//a[normalize-space()='Input Fields']");
//                $counter++;
//            }
//        }
//    }

    /**
     * ```
     * This function will check API status from the entries page
     * ```
     * @param $text
     * @param $selector
     * @return string
     * @author Sarkar Ripon
     */
    public function checkAPICallStatus($text, $selector): string
    {
        $this->wait(5);
        $this->amOnPage(FluentFormsAllEntries::entriesPage);
        $this->clicked(FluentFormsAllEntries::viewEntry);
        $this->clicked(FluentFormsAllEntries::apiCalls);
        $this->waitForElement($selector, 10);

        for ($i = 0; $i < 6; $i++) {
            try {
                $this->clicked(FluentFormsAllEntries::apiCalls);
                $this->waitForElement($selector, 10);
                $this->seeTextCaseInsensitive($text, $selector);
                break;
            } catch (Exception $e) {
                $this->wait(15);
                $this->reloadPage();
            }
        }
        return $this->grabTextFrom($selector);
    }

    public function loginGoogle(): void
    {
        $cookiesFilePath = "tests/Support/Data/googlecookie.json";
        $cookiesJson = file_get_contents($cookiesFilePath);
        $cookiesData = json_decode($cookiesJson, true);
        if (isset($cookiesData) && is_array($cookiesData)) {
            foreach ($cookiesData as $cookie) {
                if (isset($cookie['domain']) && isset($cookie['expirationDate']) && isset($cookie['hostOnly']) && isset($cookie['httpOnly']) && isset($cookie['name']) && isset($cookie['path']) && isset($cookie['sameSite']) && isset($cookie['secure']) && isset($cookie['session']) && isset($cookie['storeId']) && isset($cookie['value'])) {
                    $this->setCookie($cookie['name'], $cookie['value'], $cookie['expirationDate'], $cookie['path'], $cookie['domain'], $cookie['secure'], $cookie['httpOnly'], $cookie['sameSite']);
                }
            }
        }
    }


}
