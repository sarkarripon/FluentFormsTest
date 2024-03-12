<?php

namespace Tests\Support\Helper;

use Tests\Support\AcceptanceTester;
use Tests\Support\Selectors\FluentFormsSelectors;
use Tests\Support\Selectors\GeneralFields;

trait PaymentFieldCustomizer
{
    public function customizePaymentItem(
        AcceptanceTester $I,
        $fieldName,
        ?array $basicOptions = null,
        ?array $advancedOptions = null,
        ?bool $isHiddenLabel = false
    ): void
    {
        $I->clickOnExactText($fieldName);

        $basicOperand = null;
        $advancedOperand = null;

        $basicOptionsDefault = [
            'adminFieldLabel' => false,
            'productDisplayType' => false,
            'paymentAmount' => false,
            'amountLabel' => false,
            'requiredMessage' => false,
        ];

        $advancedOptionsDefault = [
            'containerClass' => false,
            'helpMessage' => false,
            'nameAttribute' => false,
        ];

        if (!is_null($basicOptions)) {
            $basicOperand = array_merge($basicOptionsDefault, $basicOptions);
        }

        if (!is_null($advancedOptions)) {
            $advancedOperand = array_merge($advancedOptionsDefault, $advancedOptions);
        }

        //                                           Basic options                                              //

        if (isset($basicOperand)) {

            $basicOperand['adminFieldLabel'] // adminFieldLabel
                ? $I->filledField(GeneralFields::adminFieldLabel, $basicOperand['adminFieldLabel'], 'Fill As Admin Field Label')
                : null;

            if ($basicOperand['productDisplayType'] == 'Single') { // Product Display Type Single
                $basicOperand['paymentAmount']
                    ? $I->filledField(GeneralFields::customizationFields("Payment Amount"), $basicOperand['paymentAmount'], 'Fill As paymentAmount')
                    : null;
            }elseif ($basicOperand['productDisplayType'] == 'Radio') { // Product Display Type Radio

            }

            $basicOperand['amountLabel']
                ? $I->filledField(GeneralFields::customizationFields("Amount Label"), $basicOperand['amountLabel'], 'Fill As paymentAmount')
                : null;

            if ($basicOperand['requiredMessage']) { // Required Message
                $I->clicked(GeneralFields::radioSelect('Required',1),'Mark Yes from Required because by default it is No');
                if ($I->checkElement("//div[contains(@class, 'is-checked') and @role='switch']")){
                    $I->clickByJS("//div[contains(@class, 'is-checked') and @role='switch']",'Enable custom error message');
                }
                $I->filledField(GeneralFields::customizationFields('Custom Error Message'), $basicOperand['requiredMessage'], 'Fill As custom Required Message');
            }
        }

        //                                           Advanced options                                              //

        if (isset($advancedOperand)) {
            $I->scrollTo(GeneralFields::advancedOptions);
            $I->clicked(GeneralFields::advancedOptions,'Expand advanced options');
            $I->wait(2);

            $advancedOperand['containerClass'] // Container Class
                ? $I->filledField(GeneralFields::customizationFields('Container Class'), $advancedOperand['containerClass'], 'Fill As Container Class')
                : null;
            $advancedOperand['helpMessage'] // Help Message
                ? $I->filledField("//textarea[@class='el-textarea__inner']", $advancedOperand['helpMessage'], 'Fill As Help Message')
                : null;
            $advancedOperand['nameAttribute'] // Name Attribute
                ? $I->filledField(GeneralFields::customizationFields('Name Attribute'), $advancedOperand['nameAttribute'], 'Fill As Name Attribute')
                : null;
        }
        $I->clicked(FluentFormsSelectors::saveForm);
    }

    public function customizeSubscription(
        AcceptanceTester $I,
        $fieldName,
        ?array $basicOptions = null,
        ?array $advancedOptions = null,
        ?bool $isHiddenLabel = false
    ): void
    {
        $I->clickOnExactText($fieldName);

        $basicOperand = null;
        $advancedOperand = null;

        $basicOptionsDefault = [
            'adminFieldLabel' => false,
            'subscriptionType' => false,
            'pricingPlans' => false,
            'requiredMessage' => false,
        ];

        $advancedOptionsDefault = [
            'containerClass' => false,
            'helpMessage' => false,
            'nameAttribute' => false,
        ];

        if (!is_null($basicOptions)) {
            $basicOperand = array_merge($basicOptionsDefault, $basicOptions);
        }

        if (!is_null($advancedOptions)) {
            $advancedOperand = array_merge($advancedOptionsDefault, $advancedOptions);
        }
//
//        print_r($basicOperand);
//        print_r($advancedOperand);
//        exit();

        //                                           Basic options                                              //

        if (isset($basicOperand)) {

            $basicOperand['adminFieldLabel'] // adminFieldLabel
                ? $I->filledField(GeneralFields::adminFieldLabel, $basicOperand['adminFieldLabel'], 'Fill As Admin Field Label')
                : null;

            if (isset($basicOperand['subscriptionType'])) { // subscription Type
                $type = $basicOperand['subscriptionType'];
                $planName = $basicOperand['pricingPlans']['planName']??null;
                $price = $basicOperand['pricingPlans']['price']??null;
                $billingInterval = $basicOperand['pricingPlans']['billingInterval']??null;
                $hasSignupFee = $basicOperand['pricingPlans']['hasSignupFee']??null;
                $hasTrailPeriod = $basicOperand['pricingPlans']['hasTrailPeriod']??null;
                $totalBillingTimes = $basicOperand['pricingPlans']['totalBillingTimes']??null;


                if ($type == 'singleRecurringPlan'){
                     $I->clicked("//span[normalize-space()='Single Recurring Plan']", "Click on Single Recurring Plan");
                         $planName
                             ? $I->filledField(GeneralFields::customizationFields("Plan Name"), $planName, 'Fill As Plan Name')
                             : null;

                         $price
                             ? $I->filledField(GeneralFields::customizationFields("Price"), $price, 'Fill As Price')
                             : null;

                        if (isset($billingInterval)){
                            $I->clicked("(//input[@placeholder='Select'])[1]");
                            $I->clickOnExactText( $billingInterval, 'Billing Interval');
                        }
                        if (isset($hasSignupFee)){
                            $I->toggleOn($I,"Has Signup Fee?");
                            $I->filledField(GeneralFields::customizationFields("Has Signup Fee?"), $hasSignupFee, 'Fill As Has Signup Fee');
                        }
                        if (isset($hasTrailPeriod)){
                            $I->toggleOn($I,"Has Trial Days? (in days)");
                            $I->filledField(GeneralFields::customizationFields("Has Trial Days? (in days)"), $hasTrailPeriod, 'Fill As Has Trial Days');
                        }
                    if (isset($totalBillingTimes)){
                        $I->filledField(GeneralFields::customizationFields("Total Billing times"), $totalBillingTimes, 'Fill As Total Billing times');
                    }
                }
            }
            if ($basicOperand['requiredMessage']) { // Required Message
                $I->clicked(GeneralFields::radioSelect('Required',1),'Mark Yes from Required because by default it is No');
                if ($I->checkElement("//div[normalize-space()='Required']/following::div[contains(@class, 'is-checked') and @role='switch']")){
                    $I->clickByJS("//div[normalize-space()='Required']/following::div[contains(@class, 'is-checked') and @role='switch']",'Enable custom error message');
                }
                $I->filledField(GeneralFields::customizationFields('Custom Error Message'), $basicOperand['requiredMessage'], 'Fill As custom Required Message');
            }
        }

        //                                           Advanced options                                              //

        if (isset($advancedOperand)) {
            $I->scrollTo(GeneralFields::advancedOptions);
            $I->clicked(GeneralFields::advancedOptions,'Expand advanced options');
            $I->wait(2);

            $advancedOperand['containerClass'] // Container Class
                ? $I->filledField(GeneralFields::customizationFields('Container Class'), $advancedOperand['containerClass'], 'Fill As Container Class')
                : null;
            $advancedOperand['helpMessage'] // Help Message
                ? $I->filledField("//textarea[@class='el-textarea__inner']", $advancedOperand['helpMessage'], 'Fill As Help Message')
                : null;
            $advancedOperand['nameAttribute'] // Name Attribute
                ? $I->filledField(GeneralFields::customizationFields('Name Attribute'), $advancedOperand['nameAttribute'], 'Fill As Name Attribute')
                : null;
        }
        $I->clicked(FluentFormsSelectors::saveForm);

    }



}