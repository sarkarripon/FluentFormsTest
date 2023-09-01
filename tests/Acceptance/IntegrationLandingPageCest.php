<?php


namespace Tests\Acceptance;

use Tests\Support\AcceptanceTester;
use Tests\Support\Helper\Acceptance\Integrations\IntegrationHelper;
use Tests\Support\Helper\Acceptance\Integrations\LandingPage;

class IntegrationLandingPageCest
{
    use IntegrationHelper, LandingPage;
    public function _before(AcceptanceTester $I): void
    {
        $I->loadDotEnvFile(); $I->loginWordpress();
    }

    public function test_landing_page(AcceptanceTester $I): void
    {
        $pageName = __FUNCTION__.'_'.rand(1,100);
        
        global $landingPageUrl;
        $this->prepareForm($I, $pageName, ['generalFields' => ['email', 'nameFields']]);
        $this->configureLandingPage($I,2);
        $I->amOnUrl($landingPageUrl);
        $I->dontSee(getenv("WORDPRESS_USERNAME"));
    }


}
