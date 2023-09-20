<?php


namespace Tests\Acceptance;

use Tests\Support\AcceptanceTester;
use Tests\Support\Factories\DataProvider\DataGenerator;
use Tests\Support\Helper\Acceptance\Integrations\IntegrationHelper;
use Tests\Support\Helper\Acceptance\Integrations\Telegram;
use Tests\Support\Selectors\FieldSelectors;
use Tests\Support\Selectors\FluentFormsSelectors;

class IntegrationTelegramCest
{
    use Telegram, IntegrationHelper, DataGenerator;
    public function _before(AcceptanceTester $I): void
    {
        $I->loadDotEnvFile();
//        $I->loginWordpress();
    }

    // tests
    public function test_telegram_notification(AcceptanceTester $I)
    {
        $jhvf = $this->fetchTelegramData($I,'hello');
        dd($jhvf);

        $pageName = __FUNCTION__.'_'.rand(1,100);
        $customName=[
            'email' => 'Email Address',
            'nameFields'=>'Name',
            'simpleText'=>'Message',
        ];
        $this->prepareForm($I, $pageName, [
            'generalFields' => ['email','nameFields','simpleText'],
        ],'yes',$customName);
        $this->configureTelegram($I, "Telegram");

        $this->mapTelegramFields($I);
        $this->preparePage($I,$pageName);

//        $I->amOnPage("test_airtable_push_data_57/");
        $fillAbleDataArr = [
            'Email Address'=>'email',
            'First Name'=>'firstName',
            'Last Name'=>'lastName',
            'Message'=> 'sentence',
        ];
        $returnedFakeData = $this->generatedData($fillAbleDataArr);
        print_r($returnedFakeData);
//        exit();

        foreach ($returnedFakeData as $selector => $value) {
            $I->tryToFilledField(FluentFormsSelectors::fillAbleArea($selector), $value);
        }
        $I->clicked(FieldSelectors::submitButton);

        $remoteData = $this->fetchTelegramData($I, $returnedFakeData['Message']);
        print_r($remoteData);

        if (!empty($remoteData)) {
            $I->checkValuesInArray($remoteData, [
                $returnedFakeData['Last Name'],
                $returnedFakeData['First Name'],
                $returnedFakeData['Email Address'],
            ]);
            echo " Hurray.....! Data found in slack";
        }else{
            $I->fail("Could not fetch data from slack");
        }



    }
}
