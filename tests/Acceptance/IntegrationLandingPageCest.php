<?php


namespace Tests\Acceptance;

use Tests\Support\AcceptanceTester;
use Tests\Support\Helper\Acceptance\Integrations\IntegrationHelper;
use Tests\Support\Helper\Acceptance\Integrations\LandingPage;

class IntegrationLandingPageCest
{
    use IntegrationHelper, LandingPage;
    public function _before(AcceptanceTester $I)
    {
        $I->loadDotEnvFile();
        $I->loginWordpress();
    }

    public function test_landing_page(AcceptanceTester $I)
    {
        global $landingPageUrl;
        $this->prepareForm($I, __FUNCTION__, ['generalFields' => ['email', 'nameFields']]);
        $this->configureLandingPage($I,2);
        $I->amOnUrl($landingPageUrl);
        $I->dontSee(getenv("WORDPRESS_USERNAME"));


    }


}
