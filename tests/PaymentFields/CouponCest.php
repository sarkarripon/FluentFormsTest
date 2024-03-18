<?php


namespace Tests\PaymentFields;

use Tests\Support\AcceptanceTester;
use Tests\Support\Factories\DataProvider\DataGenerator;
use Tests\Support\Helper\Integrations\IntegrationHelper;
use Tests\Support\Helper\PaymentFieldCustomizer;
use Tests\Support\Selectors\FieldSelectors;

class CouponCest
{
    use IntegrationHelper, PaymentFieldCustomizer, DataGenerator;
    public function _before(AcceptanceTester $I)
    {
        $I->loaddotenvfile();
        $I->loginWordpress();
    }

    // tests
    public function test_coupon(AcceptanceTester $I)
    {
        $pageName = __FUNCTION__ . '_' . rand(1, 100);
        $faker = \Faker\Factory::create();

        $elementLabel = $faker->words(2, true);
        $adminFieldLabel = $faker->words(2, true);
        $placeholder = $faker->words(3, true);
        $suffixLabel = $faker->words(3, true);

        $containerClass = $faker->firstName();
        $elementClass = $faker->userName();
        $helpMessage = $faker->words(4, true);
        $nameAttribute = $faker->firstName();

        $customName = [
            'coupon' => $elementLabel,
        ];

        $this->prepareForm($I, $pageName, [
            'paymentFields' => ['coupon'],
        ], true, $customName);

        $this->customizeCoupon($I, $elementLabel,
            [
            'adminFieldLabel' => $adminFieldLabel,
                'placeholder' => $placeholder,
                'suffixLabel' => $suffixLabel,
            ],
            [
                'containerClass' => $containerClass,
                'elementClass' => $elementClass,
                'helpMessage' => $helpMessage,
                'nameAttribute' => $nameAttribute,
            ]);

        $this->openInPreview($I);
//        $this->preparePage($I, $pageName);
//        $I->clicked(FieldSelectors::submitButton);
        $I->seeText([
            $elementLabel,
            $suffixLabel,
        ], $I->cmnt('Check element label, suffix label'));

        $I->canSeeElement("//input[@placeholder='$placeholder']", [], $I->cmnt('Check Coupon placeholder'));
        $I->canSeeElement("//input[@name='$nameAttribute']", [], $I->cmnt('Check Coupon name attribute'));
        $I->canSeeElement("//input[@data-name='$nameAttribute']", [], $I->cmnt('Check Coupon name attribute'));
        $I->canSeeElement("//div[contains(@class,'$containerClass')]", [], $I->cmnt('Check Coupon container class'));
        $I->canSeeElement("//input[contains(@class,'$elementClass')]", [], $I->cmnt('Check Coupon element class'));


        echo $I->cmnt("All test cases went through. ", 'yellow', '', array('blink'));

        // checking error message remaining, because of the bug in this field


    }
}
