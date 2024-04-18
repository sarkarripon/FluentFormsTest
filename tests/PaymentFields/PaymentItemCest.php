<?php


namespace Tests\PaymentFields;

use Codeception\Attribute\Group;
use Faker\Factory;
use Tests\Support\AcceptanceTester;
use Tests\Support\Factories\DataProvider\DataGenerator;
use Tests\Support\Helper\Integrations\IntegrationHelper;
use Tests\Support\Helper\PaymentFieldCustomizer;
use Tests\Support\Selectors\FieldSelectors;

class PaymentItemCest
{
    use IntegrationHelper, PaymentFieldCustomizer, DataGenerator;
    public function _before(AcceptanceTester $I): void
    {
        $I->loaddotenvfile();
        $I->loginWordpress();
    }

    // tests
    #[Group('PaymentFields', 'all')]
    public function test_payment_Item(AcceptanceTester $I)
    {
        $pageName = __FUNCTION__ . '_' . rand(1, 100);
        $faker = Factory::create();

        $elementLabel = $faker->words(3, true);
        $adminFieldLabel = $faker->words(2, true);
        $paymentAmount = $faker->numberBetween(5, 99);
        $amountLabel = $faker->words(3, true).":";
        $requiredMessage = $faker->words(2, true);

        $containerClass = $faker->firstName();
        $helpMessage = $faker->words(4, true);
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
                'productDisplayType' => "Single", // Single, Radio, Checkbox, Select,
                'paymentAmount' => $paymentAmount,
                'amountLabel' => $amountLabel,
                'requiredMessage' => $requiredMessage,
            ],
            [
                'containerClass' => $containerClass,
                'helpMessage' => $helpMessage,
                'nameAttribute' => $nameAttribute,
            ]);



        $this->openInPreview($I); // check the form element in preview mode
//        $this->preparePage($I, $pageName);
//        $I->clicked(FieldSelectors::submitButton);
        $I->seeText([
            $elementLabel,
//            $requiredMessage,
        ], $I->cmnt('Check element label, required message'));


        $I->canSeeElement("//input[contains(@name,$nameAttribute)]", [], $I->cmnt('Check PaymentItem field name attribute'));
        $I->canSeeElement("//input[contains(@data-name,$nameAttribute)]",[], $I->cmnt('Check PaymentItem field data-name attribute'));
        $I->canSeeElement("//input[contains(@class,$containerClass)]", [], $I->cmnt('Check PaymentItem field container class'));
        $I->canSeeElement("//div", ['data-content' => $helpMessage], $I->cmnt('Check PaymentItem field help message'));
        echo $I->cmnt("All test cases went through. ",'yellow','',array('blink'));

    }
}
