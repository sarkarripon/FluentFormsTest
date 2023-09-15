<?php


namespace Tests\Acceptance;

use Tests\Support\Factories\DataProvider\DataGenerator;
use Tests\Support\Helper\Acceptance\Integrations\ClickSend;
use Tests\Support\AcceptanceTester;
use Tests\Support\Helper\Acceptance\Integrations\FieldCustomizer;
use Tests\Support\Selectors\FieldSelectors;
use Tests\Support\Selectors\FluentFormsSelectors;

class IntegrationClickSendCest
{
    use ClickSend, FieldCustomizer, DataGenerator;
    public function _before(AcceptanceTester $I)
    {
        $I->loadDotEnvFile();
        $I->loginWordpress();
    }

    // tests
    public function test_clickSend_push_data(AcceptanceTester $I)
    {
//        $jvhhfdh = $this->fetchClickSendData($I,"jyte@gmail.com");
//        dd($jvhhfdh);

        $pageName = __FUNCTION__.'_'.rand(1,100);
        $extraListOrService =['Services'=>'Create Subscriber Contact', 'Campaign List'=>'Example List'];
        $customName=[
            'email' => 'Email',
            'phone'=>'Phone Number',
        ];
        $this->prepareForm($I, $pageName, [
            'generalFields' => ['email', 'phone'],
        ],'yes',$customName);
        $this->configureClickSend($I, "ClickSend");

        $fieldMapping = array_merge($this->buildArrayWithKey($customName),['Email'=>'Email']);

        $this->mapClickSendFields($I,$fieldMapping,$extraListOrService);
        $this->preparePage($I,$pageName);

//        $I->amOnPage("test_airtable_push_data_57/");
        $fillAbleDataArr = [
            'Email'=>'email',
            'Phone Number' => 'phoneNumber',

        ];
        $returnedFakeData = $this->generatedData($fillAbleDataArr);
//        print_r($returnedFakeData);
//        exit();

        foreach ($returnedFakeData as $selector => $value) {
            $I->tryToFilledField(FluentFormsSelectors::fillAbleArea($selector), $value);
        }
        $I->clicked(FieldSelectors::submitButton);

        $remoteData = $this->fetchClickSendData($I, $returnedFakeData['Email']);
//        print_r($remoteData);

        if (isset($remoteData)) {
            $phone =  $remoteData['phone_number'];;
            $email = $remoteData['email'];

            $I->assertString([
                $returnedFakeData['Email'] => $email,
                $returnedFakeData['Phone Number'] => $phone,
            ]);
        }else{
            $I->fail("Data not found");
        }

    }
}
