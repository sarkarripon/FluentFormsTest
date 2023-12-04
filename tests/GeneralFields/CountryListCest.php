<?php


namespace Tests\GeneralFields;

use Tests\Support\AcceptanceTester;
use Tests\Support\Factories\DataProvider\DataGenerator;
use Tests\Support\Helper\GeneralFieldCustomizer;
use Tests\Support\Helper\Integrations\IntegrationHelper;
use Tests\Support\Selectors\FieldSelectors;

class CountryListCest
{
    use IntegrationHelper, GeneralFieldCustomizer, DataGenerator;
    public function _before(AcceptanceTester $I)
    {
        $I->loadDotEnvFile();
        $I->loginWordpress();
    }

    // tests
    public function test_country_list(AcceptanceTester $I)
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
            'countryList' => $elementLabel,
        ];

        $this->prepareForm($I, $pageName, [
            'generalFields' => ['countryList'],
        ], true, $customName);

        $this->customizeCountryList($I, $elementLabel,
            [
                'adminFieldLabel' => $adminFieldLabel,
                'placeholder' => $placeholder,
                'requiredMessage' => $requiredMessage,
                'smartSearch' => true,
            ],
            [
                'nameAttribute' => $nameAttribute,
                'containerClass' => $containerClass,
                'elementClass' => $elementClass,
                'helpMessage' => $helpMessage,
//                'defaultValue' => $this->generatedData(['Country' => ['country'=> true]])['Country'],
                'countryList' => false,
            ]);

        $this->preparePage($I, $pageName);
        $I->clicked(FieldSelectors::submitButton);
        $I->seeText([
            $elementLabel,
            $requiredMessage,
        ], $I->cmnt('Check element label, prefix label, suffix label and required message'));

        $I->canSeeElement("//div/select", ['placeholder' => $placeholder], $I->cmnt('Check Mobile Field placeholder'));
        $I->canSeeElement("//select", ['name' => $nameAttribute], $I->cmnt('Check Mobile Field name attribute'));
        $I->canSeeElement("//select", ['data-name' => $nameAttribute], $I->cmnt('Check Mobile Field name attribute'));
        $I->canSeeElement("//div[contains(@class,'$containerClass')]", [], $I->cmnt('Check Mobile Field container class'));
        $I->canSeeElement("//div[contains(@class,'$elementClass')]", [], $I->cmnt('Check Mobile Field element class'));
        $I->canSeeElement("//div", ['data-content' => $helpMessage], $I->cmnt('Check Mobile Field help message'));
        $I->canSeeElement("//input", ['type' => 'tel'], $I->cmnt('Check Mobile Field type'));
        echo $I->cmnt("All test cases went through. ", 'yellow','',array('blink'));

    }
}
