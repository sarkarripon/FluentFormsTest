<?php


namespace Tests\PaymentFields;

use Faker\Factory;
use Tests\Support\AcceptanceTester;
use Tests\Support\Factories\DataProvider\DataGenerator;
use Tests\Support\Helper\Integrations\IntegrationHelper;
use Tests\Support\Helper\PaymentFieldCustomizer;

class SubscriptionCest
{
    use IntegrationHelper, PaymentFieldCustomizer, DataGenerator;
    public function _before(AcceptanceTester $I)
    {
        $I->loaddotenvfile();
        $I->loginWordpress();
    }

    // tests
    public function test_subscription_field(AcceptanceTester $I)
    {
        $pageName = __FUNCTION__ . '_' . rand(1, 100);
        $faker = Factory::create();

        $elementLabel = $faker->words(3, true);
        $adminFieldLabel = $faker->words(2, true);
        $paymentAmount = $faker->numberBetween(5, 99);
        $signupFee = $faker->numberBetween(5, 99);
        $trailPeriod = $faker->numberBetween(5, 99);
        $totalBillingTimes = $faker->numberBetween(5, 99);

        $requiredMessage = $faker->words(2, true);

        $containerClass = strtolower($faker->firstName());
        $helpMessage = $faker->words(4, true);
        $nameAttribute = strtolower($faker->firstName());

        $customName = [
            'subscription' => $elementLabel,
        ];

        $this->prepareForm($I, $pageName, [
            'paymentFields' => ['subscription'],
        ], true, $customName);

        $this->customizeSubscription($I, $elementLabel,
            [
                'adminFieldLabel' => $adminFieldLabel,
                'subscriptionType' => "singleRecurringPlan", // singleRecurringPlan, multiplePricingPlans
                'pricingPlans' => [
                        'planName' => $faker->words(2, true),
                        'price' => $paymentAmount,
                        'billingInterval' => 'Monthly', // Daily, Weekly, Monthly, Yearly
                        'hasSignupFee' => $signupFee, // 0, 1, 2, 3 ...
                        'hasTrailPeriod' => false, // 0, 1, 2, 3 ... in days
                        'totalBillingTimes' => $totalBillingTimes, // 0, 1, 2, 3 ... 0 for unlimited
                    ],
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
            "\$".($paymentAmount + $signupFee).".00 for first month then \$".$paymentAmount.".00 for each month, for ".$totalBillingTimes." installments",
//            $requiredMessage,
        ], $I->cmnt('Check element label, required message'));

        $I->canSeeElement("//input[contains(@name,$nameAttribute)]", [], $I->cmnt('Check Subscription field name attribute'));
        $I->canSeeElement("//input[contains(@data-name,$nameAttribute)]",[], $I->cmnt('Check Subscription field data-name attribute'));
        $I->canSeeElement("//input[contains(@class,$containerClass)]", [], $I->cmnt('Check Subscription field container class'));
        $I->canSeeElement("//div", ['data-content' => $helpMessage], $I->cmnt('Check Subscription field help message'));
        echo $I->cmnt("All test cases went through. ",'yellow','',array('blink'));

    }
}
