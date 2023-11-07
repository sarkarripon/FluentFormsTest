<?php


namespace Tests\GeneralFields;

use Tests\Support\AcceptanceTester;
use Tests\Support\Factories\DataProvider\DataGenerator;
use Tests\Support\Helper\FieldCustomizer;
use Tests\Support\Helper\Integrations\IntegrationHelper;
use Tests\Support\Selectors\FieldSelectors;

class DropDownCest
{
    use IntegrationHelper, FieldCustomizer, DataGenerator;

    public function _before(AcceptanceTester $I)
    {
        $I->loadDotEnvFile();
        $I->loginWordpress();
    }

    // tests
    public function test_dropdown_field(AcceptanceTester $I)
    {
        $pageName = __FUNCTION__ . '_' . rand(1, 100);
        $faker = \Faker\Factory::create();

        $elementLabel = $faker->words(2, true);
        $adminFieldLabel = $faker->words(2, true);
        $placeholder = $faker->words(3, true);
        $requiredMessage = $faker->words(2, true);

        $defaultValue = $faker->words(2, true);
        $containerClass = $faker->firstName();
        $elementClass = $faker->userName();
        $helpMessage = $faker->words(4, true);
        $optionLabel1 = $faker->words(2, true);
        $optionLabel2 = $faker->words(2, true);
        $optionLabel3 = $faker->words(2, true);
        $optionValue1 = $faker->words(3, true);
        $optionValue2 = $faker->words(3, true);
        $optionValue3 = $faker->words(3, true);
        $optionCalcValue1 = $faker->numberBetween(1, 100);
        $optionCalcValue2 = $faker->numberBetween(1, 100);
        $optionCalcValue3 = $faker->numberBetween(1, 100);
        $nameAttribute = $faker->firstName();


        $customName = [
            'dropdown' => $elementLabel,
        ];

        $this->prepareForm($I, $pageName, [
            'generalFields' => ['dropdown'],
        ], true, $customName);

        $this->customizeDropdown($I, $elementLabel,
            [
//                'adminFieldLabel' => $adminFieldLabel,
//                'placeholder' => $placeholder,
                'options' => [
                                [
                                'label'=> $optionLabel1,
                                'value' => $optionValue1,
                                'calcValue' => $optionCalcValue1
                                ],
                                [
                                'label'=> $optionLabel2,
                                'value' => $optionValue2,
                                'calcValue' => $optionCalcValue2
                                ],
                                [
                                'label'=> $optionLabel3,
                                'value' => $optionValue3,
                                'calcValue' => $optionCalcValue3
                                ],
                ],
                'showValues' => false,
                'calcValues' => false,
                'shuffleOption' => false,
                'searchableOption' => false,
                'requiredMessage' => $requiredMessage,
            ],
            [
                'defaultValue' => $defaultValue,
                'containerClass' => $containerClass,
                'elementClass' => $elementClass,
                'helpMessage' => $helpMessage,
                'nameAttribute' => $nameAttribute,
            ]);
        exit();

        $this->preparePage($I, $pageName);
        $I->clicked(FieldSelectors::submitButton);
        $I->seeText([
            $elementLabel,
            $prefixLabel,
            $suffixLabel,
            $requiredMessage,

        ], $I->cmnt('Check element label, prefix label, suffix label and required message'));

        $I->seeElement("//input", ['placeholder' => $placeholder], $I->cmnt('Check maskinput placeholder'));
        $I->seeElement("//input", ['name' => $nameAttribute], $I->cmnt('Check maskinput name attribute'));
        $I->seeElement("//input", ['data-name' => $nameAttribute], $I->cmnt('Check maskinput name attribute'));
        $I->seeElement("//div[contains(@class,'$containerClass')]", [], $I->cmnt('Check maskinput container class'));
        $I->seeElement("//input[contains(@class,'$elementClass')]", [], $I->cmnt('Check maskinput element class'));
        $I->seeElement("//div", ['data-content' => $helpMessage], $I->cmnt('Check maskinput help message'));

        echo $I->cmnt("All test cases went through. ",'yellow','',array('blink') );

    }
}
