<?php


namespace Tests\GlobalSettings;

use Tests\Support\AcceptanceTester;
use Tests\Support\Helper\FormSpecificSettings;
use Tests\Support\Helper\GlobalSettingsCustomizer;
use Tests\Support\Helper\Integrations\IntegrationHelper;

class DoubleOptInCest
{
    use GlobalSettingsCustomizer;
    use IntegrationHelper;
    use FormSpecificSettings;
    public function _before(AcceptanceTester $I)
    {
        $I->loadDotEnvFile();
        $I->loginWordpress();
    }

    // tests
    public function test_double_opt_in(AcceptanceTester $I)
    {

        $pageName = __FUNCTION__ . '_' . rand(1, 100);
        $faker = \Faker\Factory::create();

        $nameFieldLabel = $faker->words(2, true);
        $emailFieldLabel = $faker->words(2, true);

        $emailSubject = $faker->words(2, true);
        $emailBody = $faker->words(5, true);
        $initialSuccessMsg = $faker->words(5, true);
        $fromName = $faker->words(5, true);
        $replyTo = $faker->email();
        $deleteInterval = $faker->numberBetween(1, 9);

        $this->customizeGlobalDoubleOptIn($I,
            [
                'enableModule' => true,
                'emailSubject' => $emailSubject,
                'emailBody' => $emailBody,
//                'rawHtmlFormat' => true,
                'fromName' => $fromName,
                'replyTo' => $replyTo,
                'deleteInterval' => $deleteInterval,
            ]);

        $customName = [
            'nameFields' => $nameFieldLabel,
            'email' => $emailFieldLabel,
        ];

        $this->prepareForm($I, $pageName, [
            'generalFields' => ['nameFields','email'],
        ], true, $customName);

        $I->clicked("//a[normalize-space()='Settings & Integrations']", 'Click on Settings & Integrations');
        $this->doubleOptInConfirmation($I, $emailFieldLabel,
            [
                'initialSuccessMsg' => $initialSuccessMsg,
                'customizedEmail' => [
                    'emailSubject' => $emailSubject,
                    'emailBody' => $emailBody,
                    'rawHtmlFormat' => true,
                    'fromName' => $fromName,
                    'replyTo' => $replyTo,
                ],
                'isDisableForLoggedInUser' => false,
            ]
        );





    }
}
