<?php

declare(strict_types=1);
namespace Tests\Support;

use Codeception\Module\WebDriver;
use Tests\Support\Selectors\AccepTestSelec;
use Tests\Support\Selectors\FluentFormsSelectors;
use Tests\Support\Selectors\FluentFormsSettingsSelectors;
use Tests\Support\Selectors\FormFields;
use Tests\Support\Selectors\GlobalPageSelec;
use Tests\Support\Selectors\NewPageSelec;
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

    /**
     * @author Sarkar Ripon
     * @param $selector
     * @return void
     */
    public function reloadIfElementNotFound($selector): void
    {
        try {
            $this->seeElement($selector);
        } catch (\Exception $e){
            $this->reloadPage();
            $this->seeElement($selector);
        }
    }

    /**
     * @author Sarkar Ripon
     * @param string $pluginName
     * @return void
     * Install plugin from local
     */
    public function installPlugin(string $pluginName): void
    {
        $this->wantTo('Install ' . $pluginName . ' plugin');
        $this->amOnPage(GlobalPageSelec::pluginInstallPage);
        $this->seeElement(AccepTestSelec::uploadField);
        $this->click(AccepTestSelec::uploadField);
        $this->attachFile(AccepTestSelec::inputField,$pluginName);
        $this->seeElement(AccepTestSelec::submitButton);
        $this->click(AccepTestSelec::submitButton);
        $this->waitForText('Activate Plugin',5,AccepTestSelec::activateButton);
        $this->click(AccepTestSelec::activateButton);
    }

    /**
     * @author Sarkar Ripon
     * Activate FluentForm Pro plugin
     * @return void
     */
    public function activateFluentFormPro(): void
    {
        //Import license key
        $KEY = fopen(AccepTestSelec::licenseKey, "r") or die("Unable to open file!");
        $LICENSE_KEY = fgets($KEY);
        fclose($KEY);

        if($this->tryToSee('The Fluent Forms Pro Add On license needs to be activated', AccepTestSelec::activeNowBtn))
        {
            $this->click('Activate Now', AccepTestSelec::activeNowBtn);
            $this->waitForElement(AccepTestSelec::licenseInputField,60);
            $this->fillField(AccepTestSelec::licenseInputField,$LICENSE_KEY);
            $this->click(AccepTestSelec::activateLicenseBtn);
            $this->see('Your license is active! Enjoy Fluent Forms Pro Add On');
        }
    }

    /**
     * @author Sarkar Ripon
     * @return void
     * Remove FluentForm Pro license
     */
    public function removeFluentFormProLicense():void
    {
        $this->tryToClick('Deactivate License',AccepTestSelec::licenseBtn);
        $this->see('Enter your license key', AccepTestSelec::licenseBtn);
    }
    /**
     * @author Sarkar Ripon
     * @param string $pluginSlug
     * @return void
     * Uninstall plugin
     */
    public function uninstallPlugin(string $pluginSlug):void
    {
        $slug = str_replace(" ", "-", strtolower($pluginSlug));

        $this->click('Deactivate', "tr[data-slug='".$slug."'] td[class='plugin-title column-primary']");
        $this->waitForText('Plugin deactivated.',10,AccepTestSelec::msg);
        $this->see('Plugin deactivated.',AccepTestSelec::msg);
        $this->click('Delete', "tr[data-slug='".$slug."'] td[class='plugin-title column-primary']");
        $this->tryToAcceptPopup();
        $this->waitForText('successfully deleted.');
        $this->see('successfully deleted.');
    }

    /**
     * @return void
     * This function will delete all the existing forms
     * @author Sarkar Ripon
     */
    public function deleteExistingForms(): void
    {
        $this->amOnPage(FluentFormsSelectors::fFormPage);
        $tableRow =count($this->grabMultiple("tr"));
//        codecept_debug($tableRow);

        for ($i = 1; $i < ($tableRow); $i++) {
            do {
                $this->wait(1);
                $this->moveMouseOver(FluentFormsSelectors::mouseHoverMenu);
                $this->clicked( FluentFormsSelectors::deleteBtn);
                $this->clicked(FluentFormsSelectors::confirmBtn);
            } while ($this->tryToClick(FluentFormsSelectors::deleteBtn)==true);
            $this->reloadPage();
        }
    }
    /**
     * @author Sarkar Ripon
     * @return void
     * Create a new form
     */
    public function initiateNewForm():void
    {
        $this->amOnPage(FluentFormsSelectors::fFormPage);
        if ($this->tryToClick('Add a New Form') ||
            $this->tryToClick('Click Here to Create Your First Form', FluentFormsSelectors::createFirstForm)) {
            $this->tryToMoveMouseOver(FluentFormsSelectors::blankForm);
            $this->tryToClick('Create Form');
        }
    }

    /**
     * @author Sarkar Ripon
     * @param $formName
     * @return void
     * This function will rename the form
     */
    public function renameForm($formName):void
    {
        $this->tryToClick(RenameFormSelec::rename);
        $this->tryToFillField(RenameFormSelec::renameField, $formName);
        $this->tryToClick("Rename", RenameFormSelec::renameBtn);
        $this->wait(1);
        $this->see("Success!");
    }

    /**
     * @return void
     * This function will delete all the existing pages
     * @author Sarkar Ripon
     */
    public function deleteExistingPages(): void
    {
        $this->amOnPage(GlobalPageSelec::newPageCreationPage);

        if ($this->elementCheck(NewPageSelec::previousPageAvailable))
        {
            $this->clicked(NewPageSelec::selectAllCheckMark);
            $this->selectOption(NewPageSelec::selectMoveToTrash, "Move to Trash");
            $this->click(NewPageSelec::applyBtn);
            $this->assertStringContainsString('moved to the Trash',
                $this->grabTextFrom('#message'), 'Existing pages were deleted successfully!');
        }
    }

    /**
     * @param $title
     * @param $content
     * @return string
     * This function will create a new page with title and content
     * @author Sarkar Ripon
     */
    public function createNewPage($title, $content=null): string
    {
        global $pageUrl;
        $this->amOnPage(FluentFormsSelectors::fFormPage);
        if(!isset($content)){
            $content = $this->grabTextFrom(NewPageSelec::formShortCode);
        }
        $this->amOnPage(GlobalPageSelec::newPageCreationPage);
        $this->clicked(NewPageSelec::addNewPage);
        $this->wait(1);
        $this->executeJS(sprintf(NewPageSelec::jsForTitle,$title));
        $this->executeJS(sprintf(NewPageSelec::jsForContent,$content));
        $this->clicked( NewPageSelec::publishBtn);
        $this->waitForElementClickable(NewPageSelec::confirmPublish);
        $this->clicked( NewPageSelec::confirmPublish);
        $this->wait(1);
        $pageUrl = $this->grabAttributeFrom(NewPageSelec::viewPage, 'href');
        return $pageUrl; // it will return the page url and assign it to $pageUrl global variable above.
    }

    /**
     * @author Sarkar Ripon
     * @param $data
     * @return void
     */
    public function createFormField($data): void
    {
        $this->wantTo('Create a form for integrations');
        $this->clicked(FormFields::generalSection);

        foreach ($data as $fieldType => $fields) {
            $sectionType = match ($fieldType) {
                'advancedFields' => 'advancedSection',
                default => 'generalSection',
            };
            $this->clicked(constant(FormFields::class . '::' . $sectionType));
            foreach ($fields as $inputField){
                $selector = constant(FormFields::class . '::' . $fieldType)[$inputField];
                $this->clicked($selector);
            }
        }
    }




    /**
     *
     *
     * [!] This is the positions of the integrations in the list.
     * Use the position number to turn on the integration.
     *
     * * User Registration or Update = 1
     * * Landing Pages = 2
     * * Quiz Module = 3
     * * Inventory Module = 4
     * * Post/CPT Creation = 5
     * * Webhooks = 6
     * * Zapier = 7
     * * Mailchimp = 8
     * * Campaign Monitor = 9
     * * GetResponse = 10
     * * ActiveCampaign = 11
     * * Platformly = 12
     * * Trello = 13
     * * Drip = 14
     * * Sendinblue = 15
     * * Zoho = 16
     * * iContact = 17
     * * MooSend = 18
     * * SendFox = 19
     * * ConvertKit = 20
     * * Twilio = 21
     * * ClickSend = 22
     * * Constant Contact = 23
     * * HubSpot = 24
     * * Google Sheets = 25
     * * PipeDrive = 26
     * * MailerLite = 27
     * * GitGist = 28
     * * CleverReach = 29
     * * Salesforce = 30
     * * AmoCRM = 31
     * * OnePageCRM = 32
     * * Airtable = 33
     * * Mailjet = 34
     * * Insightly = 35
     * * Mailster = 36
     * * Automizy = 37
     * * Salesflare = 38
     * * Telegram = 39
     * * Discord = 40
     * * Slack = 41
     *
     *
     *
     * @param $integrationPositionNumber
     * @param $api
     * @param $projectID
     * @return void
     */

   public function configureIntegration($integrationPositionNumber, $api, $projectID): void
   {
       $element = $this->checkElement("//div[starts-with(@class, 'add_on_card addon_enabled_')][{$integrationPositionNumber}]//span[normalize-space()='Enabled']");

       if ($element){
           $this->clickWithLeftButton("(//span[@class='el-switch__core'])[{$integrationPositionNumber}]");
       }
       $this->clickWithLeftButton("(//div[@class='addon_footer'])[{$integrationPositionNumber}]//span[@class='dashicons dashicons-admin-generic']");

        if($integrationPositionNumber == 12)
        {
            $saveSettings = $this->checkElement(FluentFormsSettingsSelectors::platformlySaveButton);

            if (!$saveSettings) // if the platformly integration is already configured
            {
                $this->retryFillField(FluentFormsSettingsSelectors::platformlyApiKey,$api,2);
                $this->retryFillField(FluentFormsSettingsSelectors::platformlyProjectID,$projectID,2);
                $this->clicked(FluentFormsSettingsSelectors::platformlySaveButton);
                $this->seeText("Success");
            }
            $this->configurePlatformlyApiSettings("Platformly");


        }

   }









//    public function createFormFieldBySearch($fieldName): void
//    {
//        $this->fillField("(//input[@placeholder='Search (name, address)'])[1]", $fieldName);
//        $this->clicked("div[class='v-row mb15'] div[class='vddl-draggable btn-element']");
//
//    }



}
