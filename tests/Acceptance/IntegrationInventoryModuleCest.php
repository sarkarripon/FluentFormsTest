<?php


namespace Tests\Acceptance;

use Tests\Support\AcceptanceTester;
use Tests\Support\Helper\Acceptance\Integrations\FieldCustomizer;
use Tests\Support\Helper\Acceptance\Integrations\IntegrationHelper;

class IntegrationInventoryModuleCest
{
    use IntegrationHelper, FieldCustomizer;
    public function _before(AcceptanceTester $I): void
    {
//        $I->loadDotEnvFile();
//        $I->loginWordpress();
    }

    // tests
    public function test_inventory_module(AcceptanceTester $I)
    {

        $customName=[
            'nameFields'=>'Name',
            'email'=>'Email Address',
            'checkBox'=>['T-shirt','Shirt']
        ];
        $ind = $this->convertToIndexArray($customName);
        print_r($ind);
        exit();

        $this->prepareForm($I, __FUNCTION__, [
            'generalFields' => ['nameFields','email','checkBox'],
        ],'yes',$customName);
        exit();

        $this->configureUserRegistration($I, "User Registration or Update");
        $this->mapUserRegistrationField($I,$customName);
        $this->preparePage($I, __FUNCTION__);
    }
}
