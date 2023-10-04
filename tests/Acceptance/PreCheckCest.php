<?php
namespace Tests\Acceptance;
use Tests\Support\AcceptanceTester;
use Tests\Support\Helper\Acceptance\Integrations\Activecampaign;
use Tests\Support\Helper\Acceptance\Integrations\IntegrationHelper;
use Tests\Support\Helper\Acceptance\Integrations\Googlesheet;
use Tests\Support\Helper\Acceptance\Integrations\Mailchimp;
use Tests\Support\Helper\Acceptance\Integrations\Platformly;
use Tests\Support\Helper\Acceptance\Integrations\Trello;


class PreCheckCest
{
    use IntegrationHelper;

    public function _before(AcceptanceTester $I): void
    {
        $I->loadDotEnvFile();
        $I->loginWordpress();
    }


    public function check_test(AcceptanceTester $I, $isApi=true, $isNative=false)
    {
//        $I->amOnPage("wp-admin/admin.php?page=fluent_forms_all_entries");
//        $I->clicked("(//span[contains(text(),'View')])[1]");
//        if ($isApi)
//        {
//            $I->clicked("(//span[normalize-space()='API Calls'])[1]");
//            $I->waitForElementVisible("(//span[contains(@class,'log_status')])",10);
//            return $I->grabTextFrom("(//div[@class='wpf_entry_details'])[3]");
//
//        }
//        if ($isNative)
//        {
//            $I->waitForElementVisible("(//div[@class='wpf_entry_details'])[3]");
//            return $I->grabTextFrom("(//div[@class='wpf_entry_details'])[3]");
//        }
        $gg = $I->checkAPICallStatus("Success","(//span[contains(@class,'log_status')])");
        dd($gg);




    }


}