<?php


namespace Tests\GeneralFields;

use Tests\Support\AcceptanceTester;
use Tests\Support\Factories\DataProvider\DataGenerator;
use Tests\Support\Helper\FieldCustomizer;
use Tests\Support\Helper\Integrations\IntegrationHelper;
use Tests\Support\Selectors\FieldSelectors;

class NumericFieldCest
{
    use IntegrationHelper, FieldCustomizer, DataGenerator;
    public function _before(AcceptanceTester $I)
    {
        $I->loadDotEnvFile();
        $I->loginWordpress();
    }

    // tests
    public function test_numeric_field(AcceptanceTester $I)
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
        $prefixLabel = $faker->words(2, true);
        $suffixLabel = $faker->words(3, true);
        $nameAttribute = $faker->firstName();
        $minValue = $faker->numberBetween(10, 50);
        $maxValue = $faker->numberBetween(60, 99);
        $digits = $faker->numberBetween(2, 2);

        $customName = [
            'numericField' => $elementLabel,
        ];

        $this->prepareForm($I, $pageName, [
            'generalFields' => ['numericField'],
        ], true, $customName);

        $this->customizeNumericField($I, $elementLabel,
            [
//            'adminFieldLabel' => $adminFieldLabel,
                'placeholder' => $placeholder,
                'requiredMessage' => $requiredMessage,
                'minValue' => $minValue,
                'maxValue' => $maxValue,
                'digits' => $digits,
//                'numberFormat' => 'US Style with Decimal (EX: 123,456.00)',
            ],
            [
//                'defaultValue' => $defaultValue,
                'containerClass' => $containerClass,
                'elementClass' => $elementClass,
                'helpMessage' => $helpMessage,
                'step' => 'any',
                'prefixLabel' => $prefixLabel,
                'suffixLabel' => $suffixLabel,
                'nameAttribute' => $nameAttribute,
//                'calculation' => 'Sum',
            ]);

        $this->preparePage($I, $pageName);
        $I->clicked(FieldSelectors::submitButton);
        $I->seeText([
            $elementLabel,
//            $requiredMessage,
            $prefixLabel,
            $suffixLabel,
        ], $I->cmnt('Check element label, required message, prefix label, suffix label'));

        $I->seeElement("//input", ['placeholder' => $placeholder], $I->cmnt('Check numericField placeholder'));
        $I->seeElement("//input", ['name' => $nameAttribute], $I->cmnt('Check numericField name attribute'));
        $I->seeElement("//input", ['data-name' => $nameAttribute], $I->cmnt('Check numericField name attribute'));
        $I->seeElement("//div[contains(@class,'$containerClass')]", [], $I->cmnt('Check numericField container class'));
        $I->seeElement("//input[contains(@class,'$elementClass')]", [], $I->cmnt('Check numericField element class'));
        echo $I->cmnt("All test cases went through. ", 'yellow','',array('blink'));

    }
}
