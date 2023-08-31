<?php


namespace Tests\Acceptance;

use Tests\Support\AcceptanceTester;
use Tests\Support\Factories\DataProvider\DataGenerator;
use Tests\Support\Helper\Acceptance\Integrations\FieldCustomizer;
use Tests\Support\Helper\Acceptance\Integrations\IntegrationHelper;
use Tests\Support\Selectors\FieldSelectors;
use Tests\Support\Selectors\FluentFormsSelectors;
use \Codeception\Util\Debug;


class IntegrationInventoryModuleCest
{
    use IntegrationHelper, FieldCustomizer;

    public function _before(AcceptanceTester $I): void
    {
        $I->loadDotEnvFile();
        $I->loginWordpress();
        $I->runShellCommand($I,["php vendor/bin/codecept clean"]);
    }

    // tests
    public function test_inventory_module(AcceptanceTester $I, DataGenerator $faker): void
    {
        $pageName = __FUNCTION__.'_'.rand(1,100);
        $customName = [
            'nameFields' => 'Name',
            'email' => 'Email Address',
            'checkBox' => ['T-shirt']
        ];
        $this->prepareForm($I, $pageName, ['generalFields' => ['nameFields','email','checkBox']],
            'yes',$customName);
        $ind = $this->convertToIndexArray($customName);
        $options = ['Small Size','Medium Size', 'Large Size'];
        $this->customizeCheckBox($I, $ind[2],
            ['adminFieldLabel' => 'T-shirt Inventory', 'options' => $options,],
            ['inventorySettings' => [1,1,1],]);

        $this->preparePage($I, $pageName);

        $I->restartSession();
        $I->amOnPage('/' . $pageName);
        $fillAbleDataArr = [
            'Email Address'=>'email',
            'First Name'=>'firstName',
            'Last Name'=>'lastName',
        ];
        $returnedFakeData = $faker->generatedData($fillAbleDataArr);
        foreach ($returnedFakeData as $selector => $value) {
            $I->tryToFilledField(FluentFormsSelectors::fillAbleArea($selector), $value);
        }

        foreach ($options as $value) {
            $I->clickedOnText($value);
        }
        $I->clicked(FieldSelectors::submitButton);
        $I->dontSee("This Item is Stock Out");

        $I->restartSession();
        $I->amOnPage('/' . $pageName);
        foreach ($returnedFakeData as $selector => $value) {
            $I->tryToFilledField(FluentFormsSelectors::fillAbleArea($selector), $value);
        }

        foreach ($options as $value) {
            $I->clickedOnText($value);
        }
        $I->clicked(FieldSelectors::submitButton);
        $I->seeText(['This Item is Stock Out']);

    }
}
