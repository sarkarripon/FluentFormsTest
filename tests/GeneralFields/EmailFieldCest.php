<?php


namespace Tests\GeneralFields;

use Tests\Support\AcceptanceTester;
use Tests\Support\Factories\DataProvider\DataGenerator;
use Tests\Support\Helper\FieldCustomizer;
use Tests\Support\Helper\Integrations\IntegrationHelper;

class EmailFieldCest
{
    use IntegrationHelper, FieldCustomizer, DataGenerator;
    public function _before(AcceptanceTester $I)
    {
        $I->loadDotEnvFile();
        $I->loginWordpress();
    }

    // tests
    public function test_email_field(AcceptanceTester $I)
    {
        $pageName = __FUNCTION__ . '_' . rand(1, 100);
        $faker = \Faker\Factory::create();

        $elementLabel = $faker->words(2, true);
        $adminFieldLabel = $faker->words(2, true);
        $placeholder = $faker->words(3, true);
        $requiredMessage = $faker->words(2, true);
        $validationMessage = $faker->words(4, true);

        $defaultValue = $faker->words(2, true);
        $containerClass = $faker->words(3, true);
        $elementClass = $faker->words(2, true);
        $helpMessage = $faker->words(4, true);
        $duplicateValidationMessage = $faker->words(4, true);
        $prefixLabel = $faker->words(2, true);
        $suffixLabel = $faker->words(3, true);
        $nameAttribute = $faker->words(4, true);

        $customName = [
            'email' => $elementLabel,
        ];

        $this->prepareForm($I, $pageName, [
            'generalFields' => ['email'],
        ], true, $customName);

        $this->customizeEmail($I, $elementLabel,
            [
            'adminFieldLabel' => $adminFieldLabel,
            'placeholder' => $placeholder,
            'requiredMessage' => $requiredMessage,
            'validationMessage' => $validationMessage,
            ],
            [
            'defaultValue' => $defaultValue,
            'containerClass' => $containerClass,
            'elementClass' => $elementClass,
            'helpMessage' => $helpMessage,
            'duplicateValidationMessage' => $duplicateValidationMessage,
            'prefixLabel' => $prefixLabel,
            'suffixLabel' => $suffixLabel,
            'nameAttribute' => $nameAttribute,
        ]);
        exit();

    }
}
