<?php

namespace Tests\Support\Selectors;
use Codeception\Module\WebDriver;
use Tests\Support\AcceptanceTester;

class FluentFormsAddonsSelectors extends WebDriver
{
    const integrationsPage = "wp-admin/admin.php?page=fluent_forms_add_ons";

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
     * @return string
//     */
//    public static function turnOnIntegration($integrationPositionNumber): string
//    {
//        $element = $I->seeElement("(//div[@class='addon_footer'])[{$integrationPositionNumber}]//span[@class='dashicons dashicons-admin-generic']");
//        if (!$element) {
//
//            $I->clicked( "(//div[@class='addon_footer'])[{$integrationPositionNumber}]//span[@class='dashicons dashicons-admin-generic']");
//            $I->clicked("(//span[@class='el-switch__core'])[{$integrationPositionNumber}]");
//        }
//    }
//    public static function integrationConfigurationSettings(AcceptanceTester $I, $integrationPositionNumber): void
//    {
//        $element = $I->seeElement("(//div[@class='addon_footer'])[{$integrationPositionNumber}]//span[@class='dashicons dashicons-admin-generic']");
//        if (!$element) {
//
//            $I->clicked( "(//div[@class='addon_footer'])[{$integrationPositionNumber}]//span[@class='dashicons dashicons-admin-generic']");
//            $I->clicked("(//span[@class='el-switch__core'])[{$integrationPositionNumber}]");
//        }
//    }


}
