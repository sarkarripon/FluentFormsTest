<?php


namespace Tests\GeneralFields;

use Tests\Support\AcceptanceTester;
use Tests\Support\Factories\DataProvider\DataGenerator;
use Tests\Support\Helper\FieldCustomizer;
use Tests\Support\Helper\Integrations\IntegrationHelper;
use Tests\Support\Selectors\FieldSelectors;

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
        $containerClass = $faker->firstName();
        $elementClass = $faker->userName();
        $helpMessage = $faker->words(4, true);
        $duplicateValidationMessage = $faker->words(4, true);
        $prefixLabel = $faker->words(2, true);
        $suffixLabel = $faker->words(3, true);
        $nameAttribute = $faker->firstName();

        $customName = [
            'email' => $elementLabel,
        ];

        $this->prepareForm($I, $pageName, [
            'generalFields' => ['email'],
        ], true, $customName);

        $this->customizeEmail($I, $elementLabel,
            [
//            'adminFieldLabel' => $adminFieldLabel,
            'placeholder' => $placeholder,
            'requiredMessage' => $requiredMessage,
            'validationMessage' => $validationMessage,
            ],
            [
//            'defaultValue' => $defaultValue,
            'containerClass' => $containerClass,
            'elementClass' => $elementClass,
            'helpMessage' => $helpMessage,
            'duplicateValidationMessage' => $duplicateValidationMessage,
            'prefixLabel' => $prefixLabel,
            'suffixLabel' => $suffixLabel,
            'nameAttribute' => $nameAttribute,
        ]);

        $this->preparePage($I, $pageName);
        $I->clicked(FieldSelectors::submitButton);
        $I->seeText([
            $elementLabel,
            $prefixLabel,
            $suffixLabel,
            $requiredMessage,

        ], $I->cmnt('Check element label, prefix label, suffix label and required message'));
        exit();
        $I->seeElement("(//input[@name='{$nameAttribute}[first_name]'])[1]", ['placeholder' => $fplaceholder], $I->cmnt('Check first name placeholder'));
        $I->seeElement("(//input[@name='{$nameAttribute}[middle_name]'])[1]", ['placeholder' => $mplaceholder], $I->cmnt('Check middle name placeholder'));
        $I->seeElement("(//input[@name='{$nameAttribute}[last_name]'])[1]", ['placeholder' => $lplaceholder], $I->cmnt('Check last name placeholder'));

        $I->seeElement("//div", ['data-content' => $fhelpMessage], $I->cmnt('Check first name help message'));
        $I->seeElement("//div", ['data-content' => $mhelpMessage], $I->cmnt('Check middle name help message'));
        $I->seeElement("//div", ['data-content' => $lhelpMessage], $I->cmnt('Check last name help message'));

        $I->seeElement("//div[contains(@class,'$containerClass')]", [], $I->cmnt('Check container class'));
        $I->seeElement("//div", ['data-name' => $nameAttribute], $I->cmnt('Check name attribute'));

        echo $I->cmnt("Tested Name Fields without default value and everything looks good.",'yellow','',array('blink') );

    }
}
