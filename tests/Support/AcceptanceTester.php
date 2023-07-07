<?php
declare(strict_types=1);
namespace Tests\Support;

use Exception;
use Tests\Support\Selectors\AccepTestSelec;
use Tests\Support\Selectors\FluentFormsAddonsSelectors;
use Tests\Support\Selectors\FluentFormsSelectors;
use Tests\Support\Selectors\FluentFormsSettingsSelectors;
use Tests\Support\Selectors\FormFields;
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

    /**
     * @author Sarkar Ripon
     * @param $selector
     * @return void
     */
    public function reloadIfElementNotFound($selector): void
    {
        try {
            $this->seeElement($selector);
        } catch (Exception $e){
            $this->reloadPage();
            $this->seeElement($selector);
        }
    }

    public function seeSuccess($message): void
    {
        $this->assertStringContainsString('Success',
            $this->grabTextFrom("//div[@role='alert']//h2[normalize-space()='Success'][1]"), $message);
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
        $this->wait(2);
        $tableRow =count($this->grabMultiple("tr"));
//        codecept_debug($tableRow);

        for ($i = 1; $i < ($tableRow); $i++) {
            do {
                $this->wait(1);
                $this->moveMouseOver(FluentFormsSelectors::mouseHoverMenu);
                $this->clicked( FluentFormsSelectors::deleteBtn);
                $this->clicked(FluentFormsSelectors::confirmBtn);
                $this->reloadPage();
            } while ($this->tryToClick(FluentFormsSelectors::deleteBtn)==true);

        }
    }
    /**
     * @author Sarkar Ripon
     * @return void
     * Create a new form
     */
    public function initiateNewForm(): void
    {
        $this->amOnPage(FluentFormsSelectors::fFormPage);
        $this->clicked(FluentFormsSelectors::addNewForm);
        $this->clicked(FluentFormsSelectors::blankForm);
    }

    /**
     * @author Sarkar Ripon
     * @param $formName
     * @return void
     * This function will rename the form
     */
    public function renameForm($formName):void
    {
        $this->click(RenameFormSelec::rename);
        $this->fillField(RenameFormSelec::renameField, $formName);
        $this->click("Rename", RenameFormSelec::renameBtn);
        $this->wait(1);
    }

    /**
     *
     * This function will delete all the existing pages
     * @author Sarkar Ripon
     * @return void
     */
    public function deleteExistingPages(): void
    {
        $this->amOnPage(GlobalPageSelec::newPageCreationPage);
        $existingPage = $this->checkElement(NewPageSelectors::previousPageAvailable);
        if($existingPage)
        {
            $this->clicked(NewPageSelectors::selectAllCheckMark);
            $this->selectOption(NewPageSelectors::selectMoveToTrash, "Move to Trash");
            $this->click(NewPageSelectors::applyBtn);
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
            $this->waitForElement(NewPageSelectors::formShortCode, 10);
            $content = $this->grabTextFrom(NewPageSelectors::formShortCode);
        }
        $this->amOnPage(GlobalPageSelec::newPageCreationPage);
        $this->clicked(NewPageSelectors::addNewPage);
        $this->wait(1);
        $this->executeJS(sprintf(NewPageSelectors::jsForTitle,$title));
        $this->executeJS(sprintf(NewPageSelectors::jsForContent,$content));
        $this->clicked( NewPageSelectors::publishBtn);
        $this->waitForElementClickable(NewPageSelectors::confirmPublish);
        $this->clicked( NewPageSelectors::confirmPublish);
        $this->wait(1);
        $pageUrl = $this->grabAttributeFrom(NewPageSelectors::viewPage, 'href');
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
        $this->clicked(FluentFormsSelectors::generalSection);

        foreach ($data as $fieldType => $fields) {
            $sectionType = match ($fieldType) {
                'advancedFields' => 'advancedSection',
                default => 'generalSection',
            };
            $this->clicked(constant(FluentFormsSelectors::class . '::' . $sectionType));
            foreach ($fields as $inputField){
                $selector = constant(FluentFormsSelectors::class . '::' . $fieldType)[$inputField];
                $this->clicked($selector);
            }
        }
    }

    public function mapPlatformlyFields(): void
    {
        $this->waitForElement(FluentFormsSelectors::feedName,20);
        $this->fillField(FluentFormsSelectors::feedName,'Platformly Integration');

        $this->clicked(FluentFormsSelectors::plarformlySegmentDropDown);
        $this->clicked(FluentFormsSelectors::plarformlySegment);

        $this->clicked(FluentFormsSelectors::mapEmailDropdown);
        $this->clicked(FluentFormsSelectors::mapEmail);
        $this->fillField(FluentFormsSelectors::mapField(1),'{inputs.names.first_name}');
        $this->fillField(FluentFormsSelectors::mapField(2),'{inputs.names.last_name}');
        $this->fillField(FluentFormsSelectors::mapField(3),'{inputs.phone}');

        $otherFieldsArray = [
            2=>'{inputs.address_1.address_line_1}',
            3=>'{inputs.address_1.address_line_2}',
            4=>'{inputs.address_1.city}',
            5=>'{inputs.address_1.state}',
            6=>'{inputs.address_1.zip}',
            7=>'{inputs.address_1.country}',
        ];
        $counter = 1;
        foreach ($otherFieldsArray as $fieldValuePosition => $fieldValue) {
            $this->clicked(FluentFormsSelectors::openFieldLabel($counter));

            try {
                $this->executeJS(FluentFormsSelectors::jsForFieldLabelFromTop($fieldValuePosition));
            }catch (\Exception $e){
                $this->executeJS(FluentFormsSelectors::jsForFieldLabelFromBottom($fieldValuePosition));
                echo $e->getMessage();
            }

            $this->fillField(FluentFormsSelectors::fieldValue($counter), $fieldValue);
            $this->clicked(FluentFormsSelectors::addField($counter));
            $counter++;
        }

        $this->clicked(FluentFormsSelectors::contactTag);
        $this->clickByJS("//span[normalize-space()='Non_US']");
        $this->clickByJS("//span[normalize-space()='Asian']");


        $this->clickWithLeftButton(FluentFormsSelectors::saveFeed);
        $this->wait(2);
    }




    public function configurePlatformlyApiSettings($searchKey): void
    {
        $this->amOnPage(FluentFormsSelectors::fFormPage);
        $this->waitForElement(FluentFormsSelectors::mouseHoverMenu,10);
        $this->moveMouseOver(FluentFormsSelectors::mouseHoverMenu);
        $this->clicked(FluentFormsSelectors::formSettings);
        $this->clicked(FluentFormsSelectors::allIntegrations);
        $this->clicked(FluentFormsSelectors::addNewIntegration);
        $this->fillField(FluentFormsSelectors::searchIntegration,$searchKey);
        $this->clicked(FluentFormsSelectors::searchResult);

    }

    /**
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
       $this->amOnPage(FluentFormsAddonsSelectors::integrationsPage);

       $element = $this->checkElement("(//div[@class='ff_card_footer'])[{$integrationPositionNumber}]//i[@class='el-icon-setting']");

       if (!$element)
       {
           $this->clickWithLeftButton("(//span[@class='el-switch__core'])[{$integrationPositionNumber}]");
       }

       $this->clickWithLeftButton("(//DIV[@class='ff_card_footer_group'])[{$integrationPositionNumber}]//I[@class='el-icon-setting']");


        if($integrationPositionNumber == 12)
        {
            $saveSettings = $this->checkElement(FluentFormsSettingsSelectors::disconnectPlatformly);

            if (!$saveSettings) // Check if the platformly integration is already configured.
            {
                $this->waitForElement(FluentFormsSettingsSelectors::platformlyApiKey,5);
                $this->fillField(FluentFormsSettingsSelectors::platformlyApiKey,$api);
                $this->waitForElement(FluentFormsSettingsSelectors::platformlyProjectID,5);
                $this->fillField(FluentFormsSettingsSelectors::platformlyProjectID,$projectID);
                $this->clicked(FluentFormsSettingsSelectors::platformlySaveButton);
            }
            $this->configurePlatformlyApiSettings("Platformly");
        }

   }


}
