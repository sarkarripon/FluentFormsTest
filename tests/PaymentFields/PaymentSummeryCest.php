<?php


namespace Tests\PaymentFields;

use Tests\Support\AcceptanceTester;
use Tests\Support\Factories\DataProvider\DataGenerator;
use Tests\Support\Helper\Integrations\IntegrationHelper;
use Tests\Support\Helper\PaymentFieldCustomizer;

class PaymentSummeryCest
{
    use IntegrationHelper, PaymentFieldCustomizer, DataGenerator;
    public function _before(AcceptanceTester $I)
    {
        $I->loaddotenvfile();
        $I->loginWordpress();
    }

    // tests
    public function test_payment_summery_field(AcceptanceTester $I)
    {
        $pageName = __FUNCTION__ . '_' . rand(1, 100);
        $faker = \Faker\Factory::create();

        $elementLabel = $faker->words(2, true);
        $description = $faker->words(9, true);
        $containerClass = $faker->userName();

        $customName = [
            'paymentSummary' => $elementLabel,
        ];

        $this->prepareForm($I, $pageName, [
            'paymentFields' => ['paymentSummary'],
        ], false, $customName);

        $this->customizePaymentSummery($I, $elementLabel,
            [
                'htmlAreaText' => $description,
            ],
            [
                'containerClass' => $containerClass,
            ]);

        $this->openInPreview($I);
//        $this->preparePage($I, $pageName);
//        $I->clicked(FieldSelectors::submitButton);
        $I->seeText([
            substr($description, 0, -1),
        ], $I->cmnt('Check description'));

        $I->canSeeElement("//div[contains(@class,'$containerClass')]", [], $I->cmnt('CheckPayment Summery Container class'));

        echo $I->cmnt("All test cases went through. ", 'yellow','',array('blink'));
    }
}
