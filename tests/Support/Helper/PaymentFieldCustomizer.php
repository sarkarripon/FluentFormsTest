<?php

namespace Tests\Support\Helper;

use Tests\Support\AcceptanceTester;
use Tests\Support\Selectors\FluentFormsSelectors;
use Tests\Support\Selectors\GeneralSelectors;

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
                ? $I->filledField(GeneralSelectors::adminFieldLabel, $basicOperand['adminFieldLabel'], 'Fill As Admin Field Label')
                : null;

            if ($basicOperand['productDisplayType'] == 'Single') { // Product Display Type Single
                $basicOperand['paymentAmount']
                    ? $I->filledField(GeneralSelectors::customizationFields("Payment Amount"), $basicOperand['paymentAmount'], 'Fill As paymentAmount')
                    : null;
            }elseif ($basicOperand['productDisplayType'] == 'Radio') { // Product Display Type Radio

            }

            $basicOperand['amountLabel']
                ? $I->filledField(GeneralSelectors::customizationFields("Amount Label"), $basicOperand['amountLabel'], 'Fill As paymentAmount')
                : null;

            if ($basicOperand['requiredMessage']) { // Required Message
                $I->clicked(GeneralSelectors::radioSelect('Required',1),'Mark Yes from Required because by default it is No');
                if ($I->checkElement("//div[contains(@class, 'is-checked') and @role='switch']")){
                    $I->clickByJS("//div[contains(@class, 'is-checked') and @role='switch']",'Enable custom error message');
                }
                $I->filledField(GeneralSelectors::customizationFields('Custom Error Message'), $basicOperand['requiredMessage'], 'Fill As custom Required Message');
            }
        }

        //                                           Advanced options                                              //

        if (isset($advancedOperand)) {
            $I->scrollTo(GeneralSelectors::advancedOptions);
            $I->clicked(GeneralSelectors::advancedOptions,'Expand advanced options');
            $I->wait(2);

            $advancedOperand['containerClass'] // Container Class
                ? $I->filledField(GeneralSelectors::customizationFields('Container Class'), $advancedOperand['containerClass'], 'Fill As Container Class')
                : null;
            $advancedOperand['helpMessage'] // Help Message
                ? $I->filledField("//textarea[@class='el-textarea__inner']", $advancedOperand['helpMessage'], 'Fill As Help Message')
                : null;
            $advancedOperand['nameAttribute'] // Name Attribute
                ? $I->filledField(GeneralSelectors::customizationFields('Name Attribute'), $advancedOperand['nameAttribute'], 'Fill As Name Attribute')
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
                ? $I->filledField(GeneralSelectors::adminFieldLabel, $basicOperand['adminFieldLabel'], 'Fill As Admin Field Label')
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
                             ? $I->filledField(GeneralSelectors::customizationFields("Plan Name"), $planName, 'Fill As Plan Name')
                             : null;

                         $price
                             ? $I->filledField(GeneralSelectors::customizationFields("Price"), $price, 'Fill As Price')
                             : null;

                        if (isset($billingInterval)){
                            $I->clicked("(//input[@placeholder='Select'])[1]");
                            $I->clickOnExactText( $billingInterval, 'Billing Interval');
                        }
                        if (isset($hasSignupFee)){
                            $I->toggleOn($I,"Has Signup Fee?");
                            $I->filledField(GeneralSelectors::customizationFields("Has Signup Fee?"), $hasSignupFee, 'Fill As Has Signup Fee');
                        }
                        if (isset($hasTrailPeriod)){
                            $I->toggleOn($I,"Has Trial Days? (in days)");
                            $I->filledField(GeneralSelectors::customizationFields("Has Trial Days? (in days)"), $hasTrailPeriod, 'Fill As Has Trial Days');
                        }
                    if (isset($totalBillingTimes)){
                        $I->filledField(GeneralSelectors::customizationFields("Total Billing times"), $totalBillingTimes, 'Fill As Total Billing times');
                    }
                }
            }
            if ($basicOperand['requiredMessage']) { // Required Message
                $I->clicked(GeneralSelectors::radioSelect('Required',1),'Mark Yes from Required because by default it is No');
                if ($I->checkElement("//div[normalize-space()='Required']/following::div[contains(@class, 'is-checked') and @role='switch']")){
                    $I->clickByJS("//div[normalize-space()='Required']/following::div[contains(@class, 'is-checked') and @role='switch']",'Enable custom error message');
                }
                $I->filledField(GeneralSelectors::customizationFields('Custom Error Message'), $basicOperand['requiredMessage'], 'Fill As custom Required Message');
            }
        }

        //                                           Advanced options                                              //

        if (isset($advancedOperand)) {
            $I->scrollTo(GeneralSelectors::advancedOptions);
            $I->clicked(GeneralSelectors::advancedOptions,'Expand advanced options');
            $I->wait(2);

            $advancedOperand['containerClass'] // Container Class
                ? $I->filledField(GeneralSelectors::customizationFields('Container Class'), $advancedOperand['containerClass'], 'Fill As Container Class')
                : null;
            $advancedOperand['helpMessage'] // Help Message
                ? $I->filledField("//textarea[@class='el-textarea__inner']", $advancedOperand['helpMessage'], 'Fill As Help Message')
                : null;
            $advancedOperand['nameAttribute'] // Name Attribute
                ? $I->filledField(GeneralSelectors::customizationFields('Name Attribute'), $advancedOperand['nameAttribute'], 'Fill As Name Attribute')
                : null;
        }
        $I->clicked(FluentFormsSelectors::saveForm);

    }

    public function customizeCustomAmount(
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
            'placeholder' => false,
            'requiredMessage' => false,
            'minValue' => false,
            'minValueErrMsg' => false,
            'maxValue' => false,
            'maxValueErrMsg' => false,

        ];

        $advancedOptionsDefault = [
            'defaultValue' => false,
            'containerClass' => false,
            'elementClass' => false,
            'helpMessage' => false,
            'prefixLabel' => false,
            'suffixLabel' => false,
            'nameAttribute' => false,
            'calculation' => false,
        ];

        if (!is_null($basicOptions)) {
            $basicOperand = array_merge($basicOptionsDefault, $basicOptions);
        }

        if (!is_null($advancedOptions)) {
            $advancedOperand = array_merge($advancedOptionsDefault, $advancedOptions);
        }

        //                                           Basic options                                              //
        // adminFieldLabel
        if (isset($basicOperand)) {
            $basicOperand['adminFieldLabel']
                ? $I->filledField(GeneralSelectors::adminFieldLabel, $basicOperand['adminFieldLabel'], 'Fill As Admin Field Label')
                : null;

            $basicOperand['placeholder'] //Placeholder
                ? $I->filledField(GeneralSelectors::placeholder, $basicOperand['placeholder'], 'Fill As Placeholder')
                : null;

            if ($basicOperand['requiredMessage']) { // Required Message
                $I->clicked(GeneralSelectors::radioSelect('Required',1),'Mark Yes from Required because by default it is No');
                if ($I->checkElement("//div[contains(@class, 'is-checked') and @role='switch']")){
                    $I->clickByJS("//div[contains(@class, 'is-checked') and @role='switch']",'Enable custom error message');
                }
                $I->filledField(GeneralSelectors::customizationFields('Custom Error Message'), $basicOperand['requiredMessage'], 'Fill As custom Required Message');
            }

            if($basicOperand['minValue']){  // Min Value
                $I->filledField("(//input[@type='number'])[2]", $basicOperand['minValue'], 'Fill As Min Value');
                $I->filledField(GeneralSelectors::customizationFields('Min Value'), $basicOperand['minValueErrMsg'], 'Fill As Min Value Error Message');
            }

            if($basicOperand['maxValue']){  // Max Value
                $I->filledField("(//input[@type='number'])[3]", $basicOperand['maxValue'], 'Fill As Max Value');
                $I->filledField(GeneralSelectors::customizationFields('Max Value'), $basicOperand['maxValueErrMsg'], 'Fill As Max Value Error Message');
            }

        }
        //                                           Advanced options                                              //

        if (isset($advancedOperand)) {
            $I->scrollTo(GeneralSelectors::advancedOptions);
            $I->clickByJS(GeneralSelectors::advancedOptions, 'Expand advanced options');
            $I->wait(2);

            $advancedOperand['defaultValue'] // Default Value
                ? $I->filledField(GeneralSelectors::defaultField, $advancedOperand['defaultValue'], 'Fill As Default Value')
                : null;

            $advancedOperand['containerClass'] // Container Class
                ? $I->filledField(GeneralSelectors::customizationFields('Container Class'), $advancedOperand['containerClass'], 'Fill As Container Class')
                : null;

            $advancedOperand['elementClass'] // Element Class
                ? $I->filledField(GeneralSelectors::customizationFields('Element Class'), $advancedOperand['elementClass'], 'Fill As Element Class')
                : null;

            $advancedOperand['helpMessage'] // Help Message
                ? $I->filledField("(//textarea[@class='el-textarea__inner'])", $advancedOperand['helpMessage'], 'Fill As Help Message')
                : null;

            $advancedOperand['prefixLabel'] // Prefix Label
                ? $I->filledField(GeneralSelectors::customizationFields('Prefix Label'), $advancedOperand['prefixLabel'], 'Fill As Prefix Label')
                : null;

            $advancedOperand['suffixLabel'] // Suffix Label
                ? $I->filledField(GeneralSelectors::customizationFields('Suffix Label'), $advancedOperand['suffixLabel'], 'Fill As Suffix Label')
                : null;

            $advancedOperand['nameAttribute'] // Name Attribute
                ? $I->filledField(GeneralSelectors::customizationFields('Name Attribute'), $advancedOperand['nameAttribute'], 'Fill As Name Attribute')
                : null;
        }
        $I->clicked(FluentFormsSelectors::saveForm);

    }

    public function customizeItemQuantity(
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
            'placeholder' => false,
            'requiredMessage' => false,
            'minValue' => false,
            'minValueErrMsg' => false,
            'maxValue' => false,
            'maxValueErrMsg' => false,

        ];

        $advancedOptionsDefault = [
            'defaultValue' => false,
            'containerClass' => false,
            'elementClass' => false,
            'helpMessage' => false,
            'prefixLabel' => false,
            'suffixLabel' => false,
            'nameAttribute' => false,
            'calculation' => false,
        ];

        if (!is_null($basicOptions)) {
            $basicOperand = array_merge($basicOptionsDefault, $basicOptions);
        }

        if (!is_null($advancedOptions)) {
            $advancedOperand = array_merge($advancedOptionsDefault, $advancedOptions);
        }

        //                                           Basic options                                              //
        // adminFieldLabel
        if (isset($basicOperand)) {
            $basicOperand['adminFieldLabel']
                ? $I->filledField(GeneralSelectors::adminFieldLabel, $basicOperand['adminFieldLabel'], 'Fill As Admin Field Label')
                : null;

            $basicOperand['placeholder'] //Placeholder
                ? $I->filledField(GeneralSelectors::placeholder, $basicOperand['placeholder'], 'Fill As Placeholder')
                : null;

            if ($basicOperand['requiredMessage']) { // Required Message
                $I->clicked(GeneralSelectors::radioSelect('Required',1),'Mark Yes from Required because by default it is No');
                if ($I->checkElement("//div[contains(@class, 'is-checked') and @role='switch']")){
                    $I->clickByJS("//div[contains(@class, 'is-checked') and @role='switch']",'Enable custom error message');
                }
                $I->filledField(GeneralSelectors::customizationFields('Custom Error Message'), $basicOperand['requiredMessage'], 'Fill As custom Required Message');
            }

            if($basicOperand['minValue']){  // Min Value
                $I->filledField("(//input[@type='number'])[2]", $basicOperand['minValue'], 'Fill As Min Value');
                $I->filledField(GeneralSelectors::customizationFields('Min Value'), $basicOperand['minValueErrMsg'], 'Fill As Min Value Error Message');
            }

            if($basicOperand['maxValue']){  // Max Value
                $I->filledField("(//input[@type='number'])[3]", $basicOperand['maxValue'], 'Fill As Max Value');
                $I->filledField(GeneralSelectors::customizationFields('Max Value'), $basicOperand['maxValueErrMsg'], 'Fill As Max Value Error Message');
            }

        }
        //                                           Advanced options                                              //

        if (isset($advancedOperand)) {
            $I->scrollTo(GeneralSelectors::advancedOptions);
            $I->clickByJS(GeneralSelectors::advancedOptions, 'Expand advanced options');
            $I->wait(2);

            $advancedOperand['defaultValue'] // Default Value
                ? $I->filledField(GeneralSelectors::defaultField, $advancedOperand['defaultValue'], 'Fill As Default Value')
                : null;

            $advancedOperand['containerClass'] // Container Class
                ? $I->filledField(GeneralSelectors::customizationFields('Container Class'), $advancedOperand['containerClass'], 'Fill As Container Class')
                : null;

            $advancedOperand['elementClass'] // Element Class
                ? $I->filledField(GeneralSelectors::customizationFields('Element Class'), $advancedOperand['elementClass'], 'Fill As Element Class')
                : null;

            $advancedOperand['helpMessage'] // Help Message
                ? $I->filledField("(//textarea[@class='el-textarea__inner'])", $advancedOperand['helpMessage'], 'Fill As Help Message')
                : null;

            $advancedOperand['prefixLabel'] // Prefix Label
                ? $I->filledField(GeneralSelectors::customizationFields('Prefix Label'), $advancedOperand['prefixLabel'], 'Fill As Prefix Label')
                : null;

            $advancedOperand['suffixLabel'] // Suffix Label
                ? $I->filledField(GeneralSelectors::customizationFields('Suffix Label'), $advancedOperand['suffixLabel'], 'Fill As Suffix Label')
                : null;

            $advancedOperand['nameAttribute'] // Name Attribute
                ? $I->filledField(GeneralSelectors::customizationFields('Name Attribute'), $advancedOperand['nameAttribute'], 'Fill As Name Attribute')
                : null;
        }
        $I->clicked(FluentFormsSelectors::saveForm);

    }

    public function customizePaymentSummery(
        AcceptanceTester $I,
        $fieldName,
        ?array $basicOptions = null,
        ?array $advancedOptions = null,
        ?bool $isHiddenLabel = false
    ): void
    {
        $I->clickByJS("(//div[contains(@class,'item-actions-wrapper')])[1]");
//        $I->clickOnExactText($fieldName);

        $basicOperand = null;
        $advancedOperand = null;

        $basicOptionsDefault = [
            'htmlAreaText' => false,
        ];

        $advancedOptionsDefault = [
            'containerClass' => false,
        ];

        if (!is_null($basicOptions)) {
            $basicOperand = array_merge($basicOptionsDefault, $basicOptions);
        }

        if (!is_null($advancedOptions)) {
            $advancedOperand = array_merge($advancedOptionsDefault, $advancedOptions);
        }

        //                                           Basic options                                              //
        if (isset($basicOperand)) {

            if ($basicOperand['htmlAreaText']) { //description
                $I->waitForElementVisible("//iframe[contains(@id,'wp_editor')]",5);
                $I->switchToIFrame("//iframe[contains(@id,'wp_editor')]");
                $I->filledField("body p:nth-child(1)", $basicOperand['htmlAreaText'], 'Fill in  rich text area');
                $I->switchToIFrame();
            }

        }

        //                                           Advanced options                                              //

        if (isset($advancedOperand)) {
            $I->scrollTo(GeneralSelectors::advancedOptions);
            $I->clickByJS(GeneralSelectors::advancedOptions, 'Expand advanced options');
            $I->wait(2);

            $advancedOperand['containerClass'] // Container Class
                ? $I->filledField(GeneralSelectors::customizationFields('Container Class'), $advancedOperand['containerClass'], 'Fill As Container Class')
                : null;
        }

        $I->clickByJS(FluentFormsSelectors::saveForm);
        $I->seeSuccess('The form is successfully updated.');

    }

    public function customizeCoupon(
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
            'placeholder' => false,
            'suffixLabel' => false,
        ];

        $advancedOptionsDefault = [
            'containerClass' => false,
            'elementClass' => false,
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
        // adminFieldLabel
        if (isset($basicOperand)) {
            $basicOperand['adminFieldLabel']
                ? $I->filledField(GeneralSelectors::adminFieldLabel, $basicOperand['adminFieldLabel'], 'Fill As Admin Field Label')
                : null;

            $basicOperand['placeholder'] //Placeholder
                ? $I->filledField(GeneralSelectors::placeholder, $basicOperand['placeholder'], 'Fill As Placeholder')
                : null;

            $basicOperand['suffixLabel'] // Suffix Label
                ? $I->filledField(GeneralSelectors::customizationFields('Suffix Label'), $basicOperand['suffixLabel'], 'Fill As Suffix Label')
                : null;

        }
        //                                           Advanced options                                              //

        if (isset($advancedOperand)) {
            $I->scrollTo(GeneralSelectors::advancedOptions);
            $I->clickByJS(GeneralSelectors::advancedOptions, 'Expand advanced options');
            $I->wait(2);

            $advancedOperand['containerClass'] // Container Class
                ? $I->filledField(GeneralSelectors::customizationFields('Container Class'), $advancedOperand['containerClass'], 'Fill As Container Class')
                : null;

            $advancedOperand['elementClass'] // Element Class
                ? $I->filledField(GeneralSelectors::customizationFields('Element Class'), $advancedOperand['elementClass'], 'Fill As Element Class')
                : null;

            $advancedOperand['helpMessage'] // Help Message
                ? $I->filledField("(//textarea[@class='el-textarea__inner'])", $advancedOperand['helpMessage'], 'Fill As Help Message')
                : null;

            $advancedOperand['nameAttribute'] // Name Attribute
                ? $I->filledField(GeneralSelectors::customizationFields('Name Attribute'), $advancedOperand['nameAttribute'], 'Fill As Name Attribute')
                : null;

        }
        $I->clicked(FluentFormsSelectors::saveForm);
        $I->seeSuccess('The form is successfully updated.');
    }

}