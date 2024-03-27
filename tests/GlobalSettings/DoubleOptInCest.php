<?php


namespace Tests\GlobalSettings;

use Tests\Support\AcceptanceTester;
use Tests\Support\Helper\GlobalSettingsCustomizer;

class DoubleOptInCest
{
    use GlobalSettingsCustomizer;
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

        $emailSubject = $faker->words(2, true);
        $emailBody = $faker->words(5, true);
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


    }
}
