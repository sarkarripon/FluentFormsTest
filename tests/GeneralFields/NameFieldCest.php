<?php


namespace Tests\GeneralFields;

use Tests\Support\AcceptanceTester;
use Tests\Support\Helper\FieldCustomizer;
use Tests\Support\Helper\Integrations\IntegrationHelper;
use Tests\Support\Selectors\FieldSelectors;

class NameFieldCest
{
    use IntegrationHelper, FieldCustomizer;
    public function _before(AcceptanceTester $I)
    {
        $I->loadDotEnvFile();
        $I->loginWordpress();
    }

    // tests
    public function test_name_fields_without_default_value(AcceptanceTester $I)
    {

        $pageName = __FUNCTION__ . '_' . rand(1, 100);
        $faker = \Faker\Factory::create();

        $flabel = $faker->words(2, true);
        $fdefault = $faker->words(3, true);
        $fplaceholder = $faker->words(2, true);
        $fhelpMessage = $faker->words(4, true);
        $ferrorMessage = $faker->words(4, true);

        $mlabel = $faker->words(2, true);
        $mdefault = $faker->words(3, true);
        $mplaceholder = $faker->words(2, true);
        $mhelpMessage = $faker->words(4, true);
        $merrorMessage = $faker->words(4, true);

        $llabel = $faker->words(2, true);
        $ldefault = $faker->words(3, true);
        $lplaceholder = $faker->words(2, true);
        $lhelpMessage = $faker->words(4, true);
        $lerrorMessage = $faker->words(4, true);

        $containerClass = $faker->firstNameMale();
        $nameAttribute = $faker->lastName();

        $customName = [
            'nameFields' => 'Full Name',
        ];

        $this->prepareForm($I, $pageName, [
            'generalFields' => ['nameFields'],
        ], true, $customName);

        $this->customizeNameFields($I,
          'First Name',
            ['adminFieldLabel' => 'Full Name',
              'firstName' => [
                  'label' => $flabel,
//                  'default' => $fdefault,
                  'placeholder' => $fplaceholder,
                  'helpMessage' => $fhelpMessage,
                  'required' => $ferrorMessage,
                    ],
                'middleName' => [
                  'label' => $mlabel,
//                  'default' => $mdefault,
                  'placeholder' => $mplaceholder,
                    'helpMessage' => $mhelpMessage,
                  'required' => $merrorMessage,
                    ],
                'lastName' => [
                  'label' => $llabel,
//                  'default' => $ldefault,
                  'placeholder' => $lplaceholder,
                    'helpMessage' => $lhelpMessage,
                  'required' => $lerrorMessage,
                    ],
            ],
            [   'containerClass' => $containerClass,
                'nameAttribute' => $nameAttribute,
            ]
        );
        $this->preparePage($I, $pageName);
        $I->clicked(FieldSelectors::submitButton);
        $I->seeText([
            $flabel,
            $ferrorMessage,
            $mlabel,
            $merrorMessage,
            $llabel,
            $lerrorMessage,
        ], $I->cmnt('Check label and error message for each name field'));

        $I->seeElement("(//input[@name='{$nameAttribute}[first_name]'])[1]", ['placeholder' => $fplaceholder], $I->cmnt('Check first name placeholder'));
        $I->seeElement("(//input[@name='{$nameAttribute}[middle_name]'])[1]", ['placeholder' => $mplaceholder], $I->cmnt('Check middle name placeholder'));
        $I->seeElement("(//input[@name='{$nameAttribute}[last_name]'])[1]", ['placeholder' => $lplaceholder], $I->cmnt('Check last name placeholder'));

        $I->seeElement("//div", ['data-content' => $fhelpMessage], $I->cmnt('Check first name help message'));
        $I->seeElement("//div", ['data-content' => $mhelpMessage], $I->cmnt('Check middle name help message'));
        $I->seeElement("//div", ['data-content' => $lhelpMessage], $I->cmnt('Check last name help message'));

        $I->seeElement("//div[contains(@class,'$containerClass')]", [], $I->cmnt('Check container class'));
        $I->seeElement("//div", ['data-name' => $nameAttribute], $I->cmnt('Check name attribute'));

        echo $I->cmnt("Tested Name Fields without default value and everything looks good.",'yellow','',array('blink') );
    }
    public function test_name_fields_with_default_value(AcceptanceTester $I)
    {
        $pageName = __FUNCTION__ . '_' . rand(1, 100);
        $faker = \Faker\Factory::create();

        $fdefault = $faker->words(3, true);
        $mdefault = $faker->words(3, true);
        $ldefault = $faker->words(3, true);

        $customName = [
            'nameFields' => 'Full Name',
        ];
        $this->prepareForm($I, $pageName, [
            'generalFields' => ['nameFields'],
        ], true, $customName);
        $this->customizeNameFields($I,
          'First Name',
            ['adminFieldLabel' => 'Full Name',
              'firstName' => [
                  'default' => $fdefault,
                    ],
                'middleName' => [
                  'default' => $mdefault,
                    ],
                'lastName' => [
                  'default' => $ldefault,
                    ],
            ]
        );
        $this->preparePage($I, $pageName);
        $I->seeElement("//input", ['value' => $fdefault]);
        $I->seeElement("//input", ['value' => $mdefault]);
        $I->seeElement("//input", ['value' => $ldefault]);

        echo $I->cmnt("Tested Name Fields with default value and everything looks good. ", 'yellow','',array('blink'));
    }
    public function test_name_fields_hide_label(AcceptanceTester $I): void
    {
        $pageName = __FUNCTION__ . '_' . rand(1, 100);
        $faker = \Faker\Factory::create();

        $flabel = $faker->words(2, true);
        $mlabel = $faker->words(2, true);
        $llabel = $faker->words(2, true);


        $customName = [
            'nameFields' => 'Full Name',
        ];
        $this->prepareForm($I, $pageName, [
            'generalFields' => ['nameFields'],
        ], true, $customName);
        $this->customizeNameFields($I,
          'First Name',
            ['adminFieldLabel' => 'Full Name',
              'firstName' => [
                  'label' => $flabel,
              ],
                'middleName' => [
                    'label' => $mlabel,
                    ],
                'lastName' => [
                    'label' => $llabel,
                    ],
            ],
            null,
            true
        );
        $this->preparePage($I, $pageName);
        $I->dontSeeElement("//label", ['aria-label'=> $flabel]);
        $I->dontSeeElement("//label", ['aria-label'=> $mlabel]);
        $I->dontSeeElement("//label", ['aria-label'=> $llabel]);

        echo $I->cmnt("Tested Name Fields whether it can hide label, everything looks good. ", 'yellow','',array('blink'));
    }




}
