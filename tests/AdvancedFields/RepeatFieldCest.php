<?php


namespace Tests\AdvancedFields;

use Tests\Support\AcceptanceTester;
use Tests\Support\Factories\DataProvider\DataGenerator;
use Tests\Support\Helper\AdvancedFieldCustomizer;
use Tests\Support\Helper\GeneralFieldCustomizer;
use Tests\Support\Helper\Integrations\IntegrationHelper;
use Tests\Support\Selectors\FieldSelectors;

class RepeatFieldCest
{
    use IntegrationHelper, AdvancedFieldCustomizer, DataGenerator;
    public function _before(AcceptanceTester $I)
    {
        $I->loadDotEnvFile();
        $I->loginWordpress();
    }

    // tests
    public function test_repeat_field(AcceptanceTester $I)
    {
        $pageName = __FUNCTION__ . '_' . rand(1, 100);
        $faker = \Faker\Factory::create();

        $addFieldElementLabel = $faker->words(2, true);
        $addFieldAdminFieldLabel = $faker->words(2, true);

        $textFieldLabel = $faker->words(2, true);
        $textFieldDefault = $faker->words(3, true);
        $textFieldPlaceholder = $faker->words(2, true);
        $textFieldRequire = $faker->words(4, true);

        $emailFieldLabel = $faker->words(2, true);
        $emailFieldDefault = $faker->words(3, true);
        $emailFieldPlaceholder = $faker->words(2, true);
        $emailFieldRequire = $faker->words(4, true);
        $emailFieldValidate = $faker->words(4, true);

        $numericFieldLabel = $faker->words(2, true);
        $numericFieldDefault = $faker->words(3, true);
        $numericFieldPlaceholder = $faker->words(2, true);
        $numericFieldRequire = $faker->words(4, true);

        $selectFieldLabel = $faker->words(2, true);
        $selectFieldPlaceholder = $faker->words(2, true);

                $optionLabel1 = $faker->words(2, true);
                $optionValue1 = $faker->words(2, true);
                $optionCalcValue1 = $faker->numberBetween(10, 50);

                $optionLabel2 = $faker->words(2, true);
                $optionValue2 = $faker->words(2, true);
                $optionCalcValue2 = $faker->numberBetween(10, 50);

                $optionLabel3 = $faker->words(2, true);
                $optionValue3 = $faker->words(2, true);
                $optionCalcValue3 = $faker->numberBetween(10, 50);

        $selectFieldRequire = $faker->words(4, true);

        $maskInputFieldLabel = $faker->words(2, true);
        $maskInputFieldDefault = $faker->words(3, true);
        $maskInputFieldPlaceholder = $faker->words(2, true);
        $maskInputFieldRequire = $faker->words(4, true);

        $containerClass = $faker->firstNameMale();
        $nameAttribute = $faker->lastName();
        $maxRepeatInputs = $faker->numberBetween(2, 5);

        $customName = [
            'repeat' => $addFieldElementLabel,
        ];

        $this->prepareForm($I, $pageName, [
            'advancedFields' => ['repeat'],
        ], true, $customName);

        $this->customizeRepeatField($I,
            $addFieldElementLabel,
            ['adminFieldLabel' => $addFieldAdminFieldLabel,
                'repeatFieldColumns' => [
                            'textField' => [
                                'label' => $textFieldLabel,
//                                'default' => $textFieldDefault,
                                'placeholder' => $textFieldPlaceholder,
                                'required' => $textFieldRequire,
                            ],
                            'emailField' => [
                                'label' => $emailFieldLabel,
//                                'default' => $emailFieldDefault,
                                'placeholder' => $emailFieldPlaceholder,
                                'required' => $emailFieldRequire,
                                'validateEmail' => $emailFieldValidate,
                            ],
                            'numericField' => [
                                'label' => $numericFieldLabel,
//                                'default' => $numericFieldDefault,
                                'placeholder' => $numericFieldPlaceholder,
                                'required' => $numericFieldRequire,
                            ],
                            'selectField' => [
                                'label' => $selectFieldLabel,
                                'placeholder' => $selectFieldPlaceholder,
                                'options' => [
                                                ['label'=> $optionLabel1,
                                                    'value'=> $optionValue1,
                                                    'calcValue'=> $optionCalcValue1,
                                                ],
                                                ['label'=> $optionLabel2,
                                                    'value'=> $optionValue2,
                                                    'calcValue'=> $optionCalcValue2,
                                                ],
                                                ['label'=> $optionLabel3,
                                                    'value'=> $optionValue3,
                                                    'calcValue'=> $optionCalcValue3,
                                                ],
                                ],
                                'required' => $selectFieldRequire,
                            ],
                            'maskInputField' => [
                                'label' => $maskInputFieldLabel,
//                                'default' => $maskInputFieldDefault,
                                'placeholder' => $maskInputFieldPlaceholder,
                                'maskInput' => '23/03/2018',
                                'required' => $maskInputFieldRequire,
                            ],
                ],
            ],
            [   'containerClass' => $containerClass,
                'nameAttribute' => $nameAttribute,
                'maxRepeatInputs' => $maxRepeatInputs,
            ]
        );

        $this->preparePage($I, $pageName);

        $I->executeJS("
            var emailInput = document.querySelector('input[type=\"email\"]');
            if (emailInput) {
                emailInput.setAttribute('type', 'something');
            }");
        $I->clicked(FieldSelectors::submitButton);
        $I->seeText([
            $addFieldElementLabel,
            $textFieldLabel,
            $emailFieldLabel,
            $numericFieldLabel,
            $selectFieldLabel,
            $maskInputFieldLabel,

            $textFieldRequire,
            $emailFieldRequire,
            $numericFieldRequire,
            $selectFieldRequire,
            $maskInputFieldRequire,

        ], $I->cmnt('Check all field label and error message'));

        $I->canSeeElement("(//input[@name='{$nameAttribute}[address_line_1]'])[1]", ['placeholder' => $addr1placeholder], $I->cmnt('Check addr1 placeholder'));
        $I->canSeeElement("(//input[@name='{$nameAttribute}[address_line_2]'])[1]", ['placeholder' => $addr2placeholder], $I->cmnt('Check addr2 placeholder'));
        $I->canSeeElement("(//input[@name='{$nameAttribute}[city]'])[1]", ['placeholder' => $cityplaceholder], $I->cmnt('Check city placeholder'));
        $I->canSeeElement("(//input[@name='{$nameAttribute}[state]'])[1]", ['placeholder' => $stateplaceholder], $I->cmnt('Check state placeholder'));
        $I->canSeeElement("(//input[@name='{$nameAttribute}[zip]'])[1]", ['placeholder' => $zipplaceholder], $I->cmnt('Check zip placeholder'));
        $I->seeElement("//select", ['placeholder' => $countryplaceholder], $I->cmnt('Check country placeholder'));

        $I->canSeeElement("//div[contains(@class,'$elementClass')]", [], $I->cmnt('Check address field element class'));

        echo $I->cmnt("All test cases went through.",'yellow','', array('blink'));

    }
}
