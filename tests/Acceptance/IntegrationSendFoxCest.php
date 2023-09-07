<?php


namespace Tests\Acceptance;

use Tests\Support\AcceptanceTester;
use Tests\Support\Factories\DataProvider\DataGenerator;
use Tests\Support\Helper\Acceptance\Integrations\FieldCustomizer;
use Tests\Support\Helper\Acceptance\Integrations\IntegrationHelper;
use Tests\Support\Helper\Acceptance\Integrations\SendFox;
use Tests\Support\Selectors\FieldSelectors;
use Tests\Support\Selectors\FluentFormsSelectors;

class IntegrationSendFoxCest
{
    use IntegrationHelper, SendFox, FieldCustomizer, DataGenerator;
    public function _before(AcceptanceTester $I): void
    {
        $I->loadDotEnvFile();
        $I->loginWordpress();
    }

    // tests
    public function test_sendFox_push_data(AcceptanceTester $I)
    {
//        $jhhdf = $this->fetchData("gebuwo@gmail.cm");
//        print_r($jhhdf);
//        exit();

        $pageName = __FUNCTION__.'_'.rand(1,100);
        $extraListOrService =['SendFox Mailing Lists'=>getenv('SENDFOX_LIST_NAME')];
        $customName=[
            'email'=>'Email Address',
            'nameFields'=>'Name',
        ];
        $this->prepareForm($I, $pageName, [
            'generalFields' => ['email', 'nameFields'],
        ],'yes',$customName);
        $this->configureSendFox($I, "SendFox");

        $fieldMapping= $this->buildArrayWithKey($customName);
//        print_r($fieldMapping);
        $this->mapSendFoxFields($I,$fieldMapping,$extraListOrService);
        $this->preparePage($I,$pageName);

        $fillAbleDataArr = [
            'Email Address'=>'email',
            'First Name'=>'firstName',
            'Last Name'=>'lastName',
        ];
        $returnedFakeData = $this->generatedData($fillAbleDataArr);
        print_r($returnedFakeData);

        foreach ($returnedFakeData as $selector => $value) {
            $I->tryToFilledField(FluentFormsSelectors::fillAbleArea($selector), $value);
        }
        $I->clicked(FieldSelectors::submitButton);
        $remoteData = $this->fetchSendFoxData($I, $returnedFakeData['Email Address'],);
        print_r($remoteData);

        if (isset($remoteData['data'])) {
            $email = $remoteData['data'][0]['email'];
            $firstName = $remoteData['data'][0]['first_name'];
            $lastName = $remoteData['data'][0]['last_name'];

            $I->assertString([
                $returnedFakeData['Email Address'] => $email,
                $returnedFakeData['First Name'] => $firstName,
                $returnedFakeData['Last Name'] => $lastName,
            ]);
        }else{
            $I->fail("Data not found");
        }


    }
}
