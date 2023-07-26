<?php
namespace Tests\Support\Selectors;

class FluentFormsSettingsSelectors
{
    const APISaveButton = "//button[contains(@class,'el-button--primary')]";
    const APIDisconnect = "//button[contains(@class,'el-button--danger')]";


    //Mailchimp
    const MailchimpApiKey ="//label[normalize-space()='Mailchimp API Key']/following::input[@class='el-input__inner']";


    //Platformly
    const PlatformlyApiKey = "(//input[@placeholder='API Key'])";
    const PlatformlyProjectID = "(//input[@placeholder='Project ID'])";





}
