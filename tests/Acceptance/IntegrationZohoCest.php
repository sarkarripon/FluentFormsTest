<?php


namespace Tests\Acceptance;

use Tests\Support\AcceptanceTester;
use Tests\Support\Helper\Acceptance\Integrations\IntegrationHelper;
use Tests\Support\Helper\Acceptance\Integrations\Zoho;

class IntegrationZohoCest
{
    use IntegrationHelper, Zoho;
    public function _before(AcceptanceTester $I): void
    {
        $I->env();
        $I->wpLogin();
    }
    public function test_zoho_push_data(AcceptanceTester $I)
    {
        $I->amOnPage('wp-admin/admin.php?page=fluent_forms&form_id=641&route=settings&sub_route=form_settings#/all-integrations/0/platformly');
        $I->waitForJs('return document.readyState === "complete"', 30);
        $I->filledField("(//input[@placeholder='Your Feed Name'])[1]",'Platformly Integration');
//        $I->clicked("//input[@placeholder='Select Platformly Segment']");
        $I->clickOnText("Select Platformly Segment","Platformly Segment");
        exit();

    }
}
