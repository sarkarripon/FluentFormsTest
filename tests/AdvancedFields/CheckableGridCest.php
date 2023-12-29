<?php


namespace Tests\AdvancedFields;

use Faker\Factory;
use Tests\Support\AcceptanceTester;
use Tests\Support\Factories\DataProvider\DataGenerator;
use Tests\Support\Helper\AdvancedFieldCustomizer;
use Tests\Support\Helper\Integrations\IntegrationHelper;
use Tests\Support\Selectors\FieldSelectors;

class CheckableGridCest
{
    use IntegrationHelper, AdvancedFieldCustomizer, DataGenerator;
    public function _before(AcceptanceTester $I)
    {
        $I->loadDotEnvFile();
        $I->loginWordpress();
    }

    // tests
    public function test_checkable_grid(AcceptanceTester $I)
    {

        $pageName = __FUNCTION__ . '_' . rand(1, 100);
        $faker = Factory::create();

        $elementLabel = $faker->words(2, true);
        $adminFieldLabel = $faker->words(2, true);
        $requiredMessage = $faker->words(2, true);

        $containerClass = $faker->firstName();
        $helpMessage = $faker->words(4, true);

        $gridColumnsLabel1 = $faker->words(2, true);
        $gridColumnsLabel2 = $faker->words(2, true);
        $gridColumnsLabel3 = $faker->words(2, true);
        $gridColumnsLabel4 = $faker->words(2, true);

        $gridRowsLabel1 = $faker->words(2, true);
        $gridRowsLabel2 = $faker->words(2, true);
        $gridRowsLabel3 = $faker->words(2, true);
        $gridRowsLabel4 = $faker->words(2, true);

        $gridColumnsValue1 = $faker->words(3, true);
        $gridColumnsValue2 = $faker->words(3, true);
        $gridColumnsValue3 = $faker->words(3, true);
        $gridColumnsValue4 = $faker->words(3, true);

        $gridRowsValue1 = $faker->words(3, true);
        $gridRowsValue2 = $faker->words(3, true);
        $gridRowsValue3 = $faker->words(3, true);
        $gridRowsValue4 = $faker->words(3, true);

        $nameAttribute = $faker->firstName();

        $customName = [
            'checkableGrid' => $elementLabel,
        ];

        $this->prepareForm($I, $pageName, [
            'advancedFields' => ['checkableGrid'],
        ], true, $customName);

        $this->customizeCheckAbleGrid($I, $elementLabel,
            [
                'adminFieldLabel' => $adminFieldLabel,
                'fieldType' => 'checkBox',  // radio, checkBox
                'gridColumns' => [
                    [
                        'label'=> $gridColumnsLabel1,
                        'value' => $gridColumnsValue1,
                    ],
                    [
                        'label'=> $gridColumnsLabel2,
                        'value' => $gridColumnsValue2,
                    ],
                    [
                        'label'=> $gridColumnsLabel3,
                        'value' => $gridColumnsValue3,
                    ],
                    [
                        'label'=> $gridColumnsLabel4,
                        'value' => $gridColumnsValue4,
                    ],
                ],
                'gridRows' => [
                    [
                        'label'=> $gridRowsLabel1,
                        'value' => $gridRowsValue1,
                    ],
                    [
                        'label'=> $gridRowsLabel2,
                        'value' => $gridRowsValue2,
                    ],
                    [
                        'label'=> $gridRowsLabel3,
                        'value' => $gridRowsValue3,
                    ],
                    [
                        'label'=> $gridRowsLabel4,
                        'value' => $gridRowsValue4,
                    ],
                ],
                'requiredMessage' => $requiredMessage,
            ],
            [
                'containerClass' => $containerClass,
                'helpMessage' => $helpMessage,
                'nameAttribute' => $nameAttribute,
            ]);

        $this->preparePage($I, $pageName);
        $I->clicked(FieldSelectors::submitButton);
        $I->seeText([
            $elementLabel,
            $requiredMessage,
        ], $I->cmnt('Check element label, required message'));

        $I->canSeeElement("//input[contains(@name,$nameAttribute)]", [], $I->cmnt('Check Rating field name attribute'));
        $I->canSeeElement("//input[contains(@data-name,$nameAttribute)]",[], $I->cmnt('Check Rating field data-name attribute'));
        $I->canSeeElement("//input[contains(@class,$containerClass)]", [], $I->cmnt('Check Rating field container class'));
        $I->canSeeElement("//div", ['data-content' => $helpMessage], $I->cmnt('Check Rating field help message'));
        echo $I->cmnt("All test cases went through. ",'yellow','',array('blink'));

        // some problem with this test case
    }
}
