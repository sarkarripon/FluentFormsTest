<?php


namespace Tests\Acceptance;

use Tests\Support\AcceptanceTester;

class IntegrationGoogleSheetCest
{
    public function _before(AcceptanceTester $I)
    {
        $I->env();
        $I->wpLogin();
    }

    public function test_google_sheet_push_data(AcceptanceTester $I)
    {

    }
}
