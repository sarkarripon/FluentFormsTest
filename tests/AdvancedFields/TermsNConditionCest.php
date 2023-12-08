<?php


namespace Tests\AdvancedFields;

use Tests\Support\AcceptanceTester;
use Tests\Support\Factories\DataProvider\DataGenerator;
use Tests\Support\Helper\AdvancedFieldCustomizer;
use Tests\Support\Helper\Integrations\IntegrationHelper;
use Tests\Support\Selectors\FieldSelectors;

class TermsNConditionCest
{
    use IntegrationHelper, AdvancedFieldCustomizer, DataGenerator;
    public function _before(AcceptanceTester $I)
    {
        $I->loadDotEnvFile();
        $I->loginWordpress();
    }

    // tests
    public function test_terms_and_condition(AcceptanceTester $I)
    {
        $pageName = __FUNCTION__ . '_' . rand(1, 100);
        $faker = \Faker\Factory::create();

        $elementLabel = $faker->words(2, true);
        $adminFieldLabel = $faker->words(2, true);
        $requiredMessage = $faker->words(2, true);
        $termsNConditions = $faker->paragraph(5, true);

        $containerClass = $faker->firstName();
        $elementClass = $faker->userName();
        $nameAttribute = $faker->firstName();


        $customName = [
            'tnc' => $elementLabel,
        ];

        $this->prepareForm($I, $pageName, [
            'advancedFields' => ['tnc'],
        ], false, $customName);

        $this->customizeTnC($I, $elementLabel,
            [
//                'adminFieldLabel' => $adminFieldLabel,
                'requiredMessage' => $requiredMessage,
                'termsNConditions' => $termsNConditions,
                'showCheckbox' => true,
            ],
            [
                'containerClass' => $containerClass,
                'elementClass' => $elementClass,
                'nameAttribute' => $nameAttribute,
            ]);

        $this->preparePage($I, $pageName);
        $I->clicked(FieldSelectors::submitButton);
        $I->seeText([
            $termsNConditions,
            $requiredMessage,
        ], $I->cmnt('Check element label, terms n condition, and required message'));

        $I->canSeeElement("//div[contains(@name,$nameAttribute)]", [], $I->cmnt('Check DropDown name attribute'));
        $I->canSeeElement("//div[contains(@data-name,$nameAttribute)]",[], $I->cmnt('Check DropDown data-name attribute'));
        $I->canSeeElement("//input[contains(@class,$containerClass)]", [], $I->cmnt('Check DropDown container class'));
        $I->canSeeElement("//input[contains(@class,$elementClass)]", [], $I->cmnt('Check DropDown element class'));


        echo $I->cmnt("All test cases went through. ", 'yellow','',array('blink'));
    }
}
