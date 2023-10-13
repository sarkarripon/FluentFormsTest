<?php


namespace Tests\GeneralFields;

use Tests\Support\AcceptanceTester;
use Tests\Support\Helper\FieldCustomizer;
use Tests\Support\Helper\Integrations\IntegrationHelper;

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

        $flabel = $faker->words(3, true);
        $fdefault = $faker->words(3, true);
        $fplaceholder = $faker->words(4, true);
        $fhelpMessage = $faker->words(4, true);
        $ferrorMessage = $faker->words(4, true);

        $mlabel = $faker->words(3, true);
        $mdefault = $faker->words(3, true);
        $mplaceholder = $faker->words(4, true);
        $mhelpMessage = $faker->words(4, true);
        $merrorMessage = $faker->words(4, true);

        $llabel = $faker->words(3, true);
        $ldefault = $faker->words(3, true);
        $lplaceholder = $faker->words(4, true);
        $lhelpMessage = $faker->words(4, true);
        $lerrorMessage = $faker->words(4, true);


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
                  'default' => $fdefault,
                  'placeholder' => $fplaceholder,
                  'helpMessage' => $fhelpMessage,
                  'required' => $ferrorMessage,
                    ],
                'middleName' => [
                  'label' => $mlabel,
                  'default' => $mdefault,
                  'placeholder' => $mplaceholder,
                    'helpMessage' => $mhelpMessage,
                  'required' => $merrorMessage,
                    ],
                'lastName' => [
                  'label' => $llabel,
                  'default' => $ldefault,
                  'placeholder' => $lplaceholder,
                    'helpMessage' => $lhelpMessage,
                  'required' => $lerrorMessage,
                    ],
            ]

        );

        exit();

    }
}
