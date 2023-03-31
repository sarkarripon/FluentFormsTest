<?php


namespace Tests\Acceptance;

use Tests\Support\AcceptanceTester;
use Tests\Support\Helper\Acceptance\Selectors\DeleteForm;
use Tests\Support\Helper\Acceptance\Selectors\GlobalPage;

class PreCheckCest
{
    public function _before(AcceptanceTester $I): void
    {
        $I->wpLogin();
    }





}
