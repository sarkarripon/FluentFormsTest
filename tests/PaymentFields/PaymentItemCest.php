<?php


namespace Tests\PaymentFields;

use Faker\Factory;
use Tests\Support\AcceptanceTester;
use Tests\Support\Factories\DataProvider\DataGenerator;
use Tests\Support\Helper\Integrations\IntegrationHelper;
use Tests\Support\Helper\PaymentFieldCustomizer;
use Tests\Support\Selectors\FieldSelectors;

class PaymentItemCest
{
    use IntegrationHelper, PaymentFieldCustomizer, DataGenerator;
    public function _before(AcceptanceTester $I)
    {
        $I->loaddotenvfile();
        $I->loginWordpress();
    }

    // tests
    public function test_payment_Item(AcceptanceTester $I)
    {
        $pageName = __FUNCTION__ . '_' . rand(1, 100);
        $faker = Factory::create();

        $elementLabel = $faker->words(2, true);
        $adminFieldLabel = $faker->words(2, true);
        $requiredMessage = $faker->words(2, true);

        $containerClass = $faker->firstName();
        $helpMessage = $faker->words(4, true);

        $paymentAmount = $faker->numberBetween(5, 99);
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
            'paymentItem' => $elementLabel,
        ];

        $this->prepareForm($I, $pageName, [
            'paymentFields' => ['paymentItem'],
        ], true, $customName);

        $this->customizePaymentItem($I, $elementLabel,
            [
                'adminFieldLabel' => $adminFieldLabel,
                'paymentAmount' => $paymentAmount,
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

        $I->canSeeElement("//input[contains(@name,$nameAttribute)]", [], $I->cmnt('Check Checkable Grid field name attribute'));
        $I->canSeeElement("//input[contains(@data-name,$nameAttribute)]",[], $I->cmnt('Check Checkable Grid field data-name attribute'));
        $I->canSeeElement("//input[contains(@class,$containerClass)]", [], $I->cmnt('Check Checkable Grid field container class'));
        $I->canSeeElement("//div", ['data-content' => $helpMessage], $I->cmnt('Check Checkable Grid field help message'));
        echo $I->cmnt("All test cases went through. ",'yellow','',array('blink'));

    }
}
