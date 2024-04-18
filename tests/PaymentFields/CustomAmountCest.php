<?php


namespace Tests\PaymentFields;

use Codeception\Attribute\Group;
use Tests\Support\AcceptanceTester;
use Tests\Support\Factories\DataProvider\DataGenerator;
use Tests\Support\Helper\Integrations\IntegrationHelper;
use Tests\Support\Helper\PaymentFieldCustomizer;
use Tests\Support\Selectors\FieldSelectors;

class CustomAmountCest
{
    use IntegrationHelper, PaymentFieldCustomizer, DataGenerator;
    public function _before(AcceptanceTester $I)
    {
        $I->loaddotenvfile();
        $I->loginWordpress();
    }

    // tests
    #[Group('PaymentFields', 'all')]
    public function test_custom_amount(AcceptanceTester $I)
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
        $minValueErrMsg = $faker->words(3, true);
        $maxValue = $faker->numberBetween(60, 99);
        $maxValueErrMsg = $faker->words(3, true);

        $customName = [
            'customPaymentAmount' => $elementLabel,
        ];

        $this->prepareForm($I, $pageName, [
            'paymentFields' => ['customPaymentAmount'],
        ], true, $customName);

        $this->customizeCustomAmount($I, $elementLabel,
            [
            'adminFieldLabel' => $adminFieldLabel,
                'placeholder' => $placeholder,
                'requiredMessage' => $requiredMessage,
                'minValue' => $minValue,
                'minValueErrMsg' => $minValueErrMsg,
                'maxValue' => $maxValue,
                'maxValueErrMsg' => $maxValueErrMsg,

            ],
            [
                'defaultValue' => $defaultValue,
                'containerClass' => $containerClass,
                'elementClass' => $elementClass,
                'helpMessage' => $helpMessage,
                'prefixLabel' => $prefixLabel,
                'suffixLabel' => $suffixLabel,
                'nameAttribute' => $nameAttribute,
//                'calculation' => 'Sum',
            ]);

//        $this->preparePage($I, $pageName);
        $this->openInPreview($I);

        $I->clicked(FieldSelectors::submitButton);
        $I->seeText([
            $elementLabel,
            $requiredMessage,
            $prefixLabel,
            $suffixLabel,
        ], $I->cmnt('Check element label, required message, prefix label, suffix label'));

        $I->canSeeElement("//input", ['placeholder' => $placeholder], $I->cmnt('Check Custom Amount placeholder'));
        $I->canSeeElement("//input", ['name' => $nameAttribute], $I->cmnt('Check Custom Amount name attribute'));
        $I->canSeeElement("//input", ['data-name' => $nameAttribute], $I->cmnt('Check Custom Amount name attribute'));
        $I->canSeeElement("//div[contains(@class,'$containerClass')]", [], $I->cmnt('Check Custom Amount container class'));
        $I->canSeeElement("//input[contains(@class,'$elementClass')]", [], $I->cmnt('Check Custom Amount element class'));


        $I->canSeeElement("//input", ['min' => $minValue], $I->cmnt('Check Custom Amount min value'));
        $I->canSeeElement("//input", ['max' => $maxValue], $I->cmnt('Check Custom Amount max value'));


        echo $I->cmnt("All test cases went through. ", 'yellow', '', array('blink'));

    }
}
