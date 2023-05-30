<?php
namespace Tests\Acceptance;

use Tests\Support\AcceptanceTester;
use Tests\Support\Helper\Acceptance\Integrations\Platformly;
use Tests\Support\Helper\Acceptance\Selectors\GeneralFieldSelec;

class PreCheckCest
{
    public function _before(AcceptanceTester $I): void
    {
        $I->wpLogin();
    }

//    public function PullData(Platformly $I)
//    {
//        $allData = json_decode($I->platformlyData("etlldnkbtzp@internetkeno.com"));
//        echo $allData->first_name;
//
//    }

    public function formcr(AcceptanceTester $I)
    {
        $I->initiateNewForm();
        $I->createFormWithGeneralField('GeneralFieldSelec',array('nameField','emailField','phoneField','addressField','timeDate','numaricField'));
    }


}
