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
        $I->loadDotEnvFile();
        $I->loginWordpress();
    }

    // tests
    public function test_inventory_module(AcceptanceTester $I)
    {
        $customName = [
            'nameFields' => 'Name',
            'email' => 'Email Address',
            'checkBox' => ['T-shirt', 'Shirt']
        ];
        $this->prepareForm($I, __FUNCTION__, ['generalFields' => ['nameFields','email','checkBox']],
            'yes',$customName);
        $ind = $this->convertToIndexArray($customName);
        $this->customizeCheckBox($I, $ind[2],
            ['adminFieldLabel' => 'T-shirt Inventory', 'options' => ['Small', 'Medium', 'Large'],],
            ['inventorySettings' => [2, 2, 2],]);
        $this->customizeCheckBox($I, $ind[3],
            ['adminFieldLabel' => 'Shirt Inventory', 'options' => [15, 16, 17],],
            ['inventorySettings' => [2, 2, 2],]);

        $this->preparePage($I, __FUNCTION__);
        exit();
    }
}
