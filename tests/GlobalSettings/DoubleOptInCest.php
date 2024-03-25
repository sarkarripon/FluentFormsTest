<?php


namespace Tests\GlobalSettings;

use Tests\Support\AcceptanceTester;
use Tests\Support\Helper\GlobalSettingsCustomizer;

class DoubleOptInCest
{
    use GlobalSettingsCustomizer;
    public function _before(AcceptanceTester $I)
    {
        $I->loadDotEnvFile();
        $I->loginWordpress();
    }

    // tests
    public function test_double_opt_in(AcceptanceTester $I)
    {
        $this->customizeGlobalDoubleOptIn($I,
            [
                'enableModule' => true,

            ]);


    }
}
