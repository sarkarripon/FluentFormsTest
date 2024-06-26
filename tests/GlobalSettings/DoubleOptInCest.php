<?php


namespace Tests\GlobalSettings;

use Tests\Support\AcceptanceTester;
use Tests\Support\Factories\DataProvider\DataGenerator;
use Tests\Support\Helper\FormSpecificSettings;
use Tests\Support\Helper\GlobalSettingsCustomizer;
use Tests\Support\Helper\Integrations\IntegrationHelper;
use Tests\Support\Selectors\FieldSelectors;
use Tests\Support\Selectors\FluentFormsSelectors;

class DoubleOptInCest
{
    use GlobalSettingsCustomizer;
    use IntegrationHelper;
    use FormSpecificSettings;
    use DataGenerator;
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
        $fromEmail = $faker->email();
        $deleteInterval = $faker->numberBetween(1, 9);

        $this->configureGlobalDoubleOptIn($I,
            [
                'enableModule' => true,
                'emailSubject' => $emailSubject,
                'emailBody' => $emailBody,
//                'rawHtmlFormat' => true,
                'fromName' => $fromName,
                'fromEmail' => $fromEmail,
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

        $this->enableDoubleOptIn($I, $emailFieldLabel,
            [
                'initialSuccessMsg' => $initialSuccessMsg,
                'customizedEmail' => [
//                    'emailSubject' => $emailSubject,
//                    'emailBody' => $emailBody,
//                    'rawHtmlFormat' => true,
//                    'fromName' => $fromName,
//                    'replyTo' => $replyTo,
                ],
                'isDisableForLoggedInUser' => false,
            ]
        );

        $this->openInPreview($I);

        $fillableDataArr = [
            $emailFieldLabel => 'email',
            'First Name' => 'firstName',
            'Last Name' => 'lastName',
        ];

        $fakeData = $this->generatedData($fillableDataArr);

        foreach ($fakeData as $selector => $value) {
            $I->tryToFilledField(FluentFormsSelectors::fillAbleArea($selector), $value);
        }

        $I->clicked(FieldSelectors::submitButton);
        $I->waitForElementVisible("(//div[contains(@class,'ff-message-success')])",10, "Wait for success message");

        $I->seeText([
            $initialSuccessMsg,
        ]);
        $this->checkInEmailLog($I, $emailSubject,[
            $emailBody,
            $fromName,
            $replyTo,
            $fromEmail,
        ]);
    }
}
