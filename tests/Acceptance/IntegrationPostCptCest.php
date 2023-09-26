<?php


namespace Tests\Acceptance;

use Tests\Support\AcceptanceTester;
use Tests\Support\Helper\Acceptance\Integrations\IntegrationHelper;

class IntegrationPostCptCest
{
    use IntegrationHelper;
    public function _before(AcceptanceTester $I)
    {
        $I->loadDotEnvFile();
        $I->loginWordpress();
    }

    // tests
    public function test_post_creation_using_cpt(AcceptanceTester $I)
    {
        $pageName = __FUNCTION__.'_'.rand(1,100);

        $this->turnOnIntegration($I,"Post/CPT Creation");
        $customName=[
            'email'=>'Email',
            'nameFields'=>'Name',
        ];
        $this->prepareForm($I, $pageName, [
            'postFields' => ['postTitle', 'postContent','postExcerpt'],
        ],'yes',$customName,true,true);



        exit();


    }
}
